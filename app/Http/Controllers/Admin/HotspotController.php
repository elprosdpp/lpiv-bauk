<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddressRequest;
use App\Models\Setting;
use http\Client\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use RouterOS\Client;
use RouterOS\Exceptions\BadCredentialsException;
use RouterOS\Exceptions\ClientException;
use RouterOS\Exceptions\ConfigException;
use RouterOS\Exceptions\ConnectException;
use RouterOS\Exceptions\QueryException;
use RouterOS\Query;
use App\Traits\getMikrotikIP;
use App\Traits\PaginatableAndSearchableTrait;
use Symfony\Component\HttpFoundation\StreamedResponse;

class HotspotController extends Controller
{

    //Get function From Get Mikrotik Trait
    use getMikrotikIP;

    //Get function From PaginatableAndSearchableTrait Trait
    use PaginatableAndSearchableTrait;


    public function __construct()
    {
        $this->middleware('can:hotspot list', ['only' => ['index', 'show']]);
        $this->middleware('can:hotspot create', ['only' => ['create', 'store']]);
        $this->middleware('can:hotspot edit', ['only' => ['edit', 'update']]);
        $this->middleware('can:hotspot delete', ['only' => ['destroy']]);
    }

    /**
     * @return mixed
     * @throws BadCredentialsException
     * @throws ClientException
     * @throws ConfigException
     * @throws ConnectException
     * @throws QueryException
     */
    public function getAllProfileHotspot(): mixed //Get All Profile Hotspot
    {
        //Get IP Mikrotik From User Login (Setting)
        $getIP = $this->connectIP();

        //Query Data
        $query = (new Query('/ip/hotspot/user/print'));
        // Ask for monitoring details
        return $getIP->query($query)->read();
    }


    /**
     * @throws ClientException
     * @throws ConnectException
     * @throws QueryException
     * @throws BadCredentialsException
     * @throws ConfigException
     */
    public function getHotspotByProfile($profile) //get User Hotspot By Profile
    {
        //Get IP Mikrotik From User Login (Setting)
        $getIP = $this->connectIP();

        //Query Data
        $query = (new Query('/ip/hotspot/user/print'))
            ->where('profile', $profile);
        // Ask for monitoring details
        return $getIP->query($query)->read();
    }

    /**
     * @throws ClientException
     * @throws ConnectException
     * @throws QueryException
     * @throws BadCredentialsException
     * @throws ConfigException
     */
    public function userHotspotActive() //Stream Active User Hotspot
    {
        //Get IP Mikrotik From User Login (Setting)
        $getIP = $this->connectIP();

        //Query Data
        $query = (new Query('/ip/hotspot/active/print'));
        // Ask for monitoring details
        return $getIP->query($query)->read();
    }

    /**
     * @throws ClientException
     * @throws ConnectException
     * @throws QueryException
     * @throws BadCredentialsException
     * @throws ConfigException
     */
    //    Add User hotspot
    public function addUserHotpot(AddressRequest $request): \Illuminate\Http\RedirectResponse
    {
        //Get IP Mikrotik From User Login (Setting)
        $getIP = $this->connectIP();

        //Query Data
        $query = (new Query('/ip/hotspot/user/add'))
            ->equal('name', $request->input('name'))
            ->equal('password', $request->input('password'))
            ->equal('profile', $request->input('profile'))
            ->equal('server', $request->input('server'));

        // Ask for monitoring details
        $getIP->query($query)->read();
        // Redirect Back With Toast Callback
        return back()->with("message", "User Hotspot Berhasil Ditambah");
    }

    /**
     * @throws ClientException
     * @throws ConnectException
     * @throws QueryException
     * @throws BadCredentialsException
     * @throws ConfigException
     */
    //    Hotspot page Index
    public function index(\Illuminate\Http\Request $request): \Inertia\Response
    {
        //Get IP Mikrotik From User Login (Setting)
        $getIP = $this->connectIP();

        //Query Data
        $items = $getIP->query('/ip/hotspot/user/print')->read();
        $profile = $getIP->query('/ip/hotspot/user/profile/print')->read();
        $active = $getIP->query('/ip/hotspot/active/print')->read();
        $totalActive = count($active);

        //  Refactor Function Paginate
        list($searchQuery, $paginatedItems) = $this->paginated($request, $items);

        //  Debug
//        dd($paginatedItems);

        //Return Inertia Render Page
        return Inertia::render('Admin/Monitoring/Hotspot/Index', [
            'items' => $paginatedItems,
            'searchQuery' => $searchQuery,
            'totalActive' => $totalActive,
            'profile' => $profile,
            'can' => [
                'create' => Auth::user()->can('hotspot create'),
                'edit' => Auth::user()->can('hotspot edit'),
                'delete' => Auth::user()->can('hotspot delete'),
            ]
        ]);
    }

    /**
     * @throws ClientException
     * @throws ConnectException
     * @throws QueryException
     * @throws BadCredentialsException
     * @throws ConfigException
     */
    public function detailHotspot($profile): \Inertia\Response
    {
        //Get Data From Query Data Function
        $detail = $this->getHotspotByProfile($profile);

//        dd($detail);

        //Return Inertia Render Page
        return Inertia::render('Admin/Monitoring/Hotspot/Detail', [
            'detailHotspot' => $detail,
            'can' => [
                'create' => Auth::user()->can('hotspot create'),
                'edit' => Auth::user()->can('hotspot edit'),
                'delete' => Auth::user()->can('hotspot delete'),
            ]
        ]);

    }

    // Create Route
    public function createUserHotspot(): \Inertia\Response
    {
        return Inertia::render('Admin/Monitoring/Hotspot/Create');
    }


    /**
     * @throws ClientException
     * @throws ConnectException
     * @throws QueryException
     * @throws BadCredentialsException
     * @throws ConfigException
     */
    //Remove user hotspot
    public function removeUserHotspot($id): \Illuminate\Http\RedirectResponse
    {
        //Get IP Mikrotik From User Login (Setting)
        $getIP = $this->connectIP();

        //Query Data
        $getIP->query(['/ip/hotspot/user/remove', '=.id=' . $id])->read();

        // Redirect Back With Toast Callback
        return back()->with("message", "User Hotspot Berhasil Dihapus");
    }


    // Stream Data User/Active Hotspot From Mikrotik (SSE Method)
    public function StreamActiveHotspot(): StreamedResponse
    {

        $response = new StreamedResponse(function () {
            while (true) {
                // Logic Get Monitor Interface By Name URL
                $out = $this->userHotspotActive();

                $data = [
                    'message' => 'Hotspot Active Update',
                    'timestamp' => now()->toDateTimeString(),
                    'data' => $out,
                ];

                // Send Data To SSE Client
                echo "data: " . json_encode($data) . "\n\n";
                ob_flush();
                flush();

                // Add Delay From Backend To Client Repeat New Data Monitor
                sleep(1);
            }
        });

        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');
        $response->headers->set('Connection', 'keep-alive');
        $response->headers->set('Transfer-Encoding', 'identity');

        return $response;
    }

    // Return Data From Stream
    public function activeHotspot(): \Inertia\Response
    {
        return Inertia::render('Admin/Monitoring/Hotspot/Active');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param mixed $items
     * @return array
     */
    // Paginate Refactor Function
    public function paginated(\Illuminate\Http\Request $request, mixed $items): array
    {
        $perPage = 10; // Jumlah item per halaman
        $page = $request->input('page', 1); // Halaman saat ini, default: 1
        $searchQuery = $request->input('search'); // Kata kunci pencarian
        $searchableColumns = ['name']; // Kolom yang dapat dijadikan sebagai kriteria pencarian

        $paginatedItems = $this->paginateAndSearch($items, $perPage, $page, $searchQuery, $searchableColumns);
        return array($searchQuery, $paginatedItems);
    }


}
