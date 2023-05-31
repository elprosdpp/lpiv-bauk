<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\SettingRequest;
use App\Models\Category;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Inertia\Response;
use RouterOS\Client;
use RouterOS\Exceptions\BadCredentialsException;
use RouterOS\Exceptions\ClientException;
use RouterOS\Exceptions\ConfigException;
use RouterOS\Exceptions\ConnectException;
use RouterOS\Exceptions\QueryException;
use RouterOS\Query;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:user list', ['only' => ['index', 'show']]);
        $this->middleware('can:user create', ['only' => ['create', 'store']]);
        $this->middleware('can:user edit', ['only' => ['edit', 'update']]);
        $this->middleware('can:user delete', ['only' => ['destroy']]);
    }


    /**
     * @throws ClientException
     * @throws ConnectException
     * @throws QueryException
     * @throws BadCredentialsException
     * @throws ConfigException
     */

    private function mikrotik($getIP): Client
    {
        return new Client([
            'host' => $getIP->ip_address_router,
            'user' => $getIP->username_router,
            'pass' => $getIP->password_router,
            'port' => 8728,
            'timeout' => 10
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * //     @return \Illuminate\Http\Response
     */

    //index setting
    public function index(): Response
    {
        //Query Data Settings
        $settings = DB::table('settings')->when(Request::input('search'), function ($query, $search) {
            $query->where('ip_address_router', 'like', '%' . $search . '%');
        })->paginate(10)
            ->withQueryString();

        //Return View Component
        return Inertia::render('Admin/Setting/Index', [
            'settings' => $settings,
            'filters' => \Illuminate\Support\Facades\Request::only(['search']),
            'can' => [
                'create' => Auth::user()->can('setting create'),
                'edit' => Auth::user()->can('setting edit'),
                'delete' => Auth::user()->can('setting delete'),
            ]
        ]);
    }


    //Store Setting Router Mikrotik
    public function store(SettingRequest $request): RedirectResponse
    {
        //Create Setting Eloquent
        $create = Setting::create($request->validated());

        //Redirect Back
        return to_route('setting.index')->with("message", "Berhasil Menambah Setting IP Address");
    }


    //    Create Page
    public function create(): Response
    {
        //Return View Component
        return Inertia::render('Admin/Setting/Create');
    }

    //    Edit Page Form
    public function edit($id): Response
    {
        //Get Setting By ID
        $settings = Setting::all();
        $setting = $settings->find($id);

        //Return View Component
        return Inertia::render('Admin/Setting/Edit', [
            'setting' => $setting,
        ]);
    }

    //Delete Store Form
    public function destroy($id): RedirectResponse
    {
        //Get Setting By ID
        $allSetting = Setting::all();
        $getSetting = $allSetting->find($id);

        //Delete Data By ID
        $getSetting->delete();
        return to_route('setting.index')->with("message", "Data Setting Berhasil Dihapus");
    }

    //Update Store Form
    public function update(SettingRequest $request, $id): RedirectResponse
    {
        //Get Setting By ID
        $allSetting = Setting::all();
        $getSetting = $allSetting->find($id);

        //Update Data By ID
        $getSetting->update($request->validated());
        return to_route('setting.index')->with("message", "Data Setting Berhasil Diubah");
    }

    /**
     * @throws ClientException
     * @throws ConnectException
     * @throws BadCredentialsException
     * @throws QueryException
     * @throws ConfigException
     */
    public function monitor(): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();

        $getAllIP = Setting::all();
        $getIP = $getAllIP->find($user);

        $client = $this->mikrotik($getIP);

        $query = new Query('/system/resource/print');

        // Send query and read response from RouterOS
        $response = $client->query($query)->read();
        return response()->json($response);
    }

}
