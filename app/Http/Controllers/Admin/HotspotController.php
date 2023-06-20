<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
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
use Symfony\Component\HttpFoundation\StreamedResponse;

class HotspotController extends Controller
{

    use getMikrotikIP;

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
    public function getAllProfileHotspot(): mixed
    {
        $getIP = $this->connectIP();

        $query = (new Query('/ip/hotspot/user/profile/print'));
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
    public function getHotspotByProfile($profile)
    {
        $getIP = $this->connectIP();

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
    public function userHotspotActive()
    {
        $getIP = $this->connectIP();

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
    public function addUserHotpot($name, $password, $profile, $server): \Illuminate\Http\RedirectResponse
    {
        $getIP = $this->connectIP();

        $query = (new Query('/ip/hotspot/user/add'))
            ->equal('name', $name)
            ->equal('password', $password)
            ->equal('profile', $profile)
            ->equal('server', $server);
        
        // Ask for monitoring details
        $getIP->query($query)->read();

        return back()->with("message", "User Hotspot Berhasil Ditambah ");
    }

    /**
     * @throws ClientException
     * @throws ConnectException
     * @throws QueryException
     * @throws BadCredentialsException
     * @throws ConfigException
     */
    public function index(): \Inertia\Response
    {
        $out = $this->getAllProfileHotspot();

//        dd($out);

        return Inertia::render('Admin/Monitoring/Hotspot/Index', [
            'profileHotspot' => $out,
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
        $detail = $this->getHotspotByProfile($profile);

//        dd($detail);

        return Inertia::render('Admin/Monitoring/Hotspot/Detail', [
            'detailHotspot' => $detail,
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
    public function createUserHotspot(): \Inertia\Response
    {
        return Inertia::render('Admin/Monitoring/Hotspot/Create');
    }


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

        return $response;
    }

    public function activeHotspot(): \Inertia\Response
    {
        return Inertia::render('Admin/Monitoring/Hotspot/Active');
    }


}
