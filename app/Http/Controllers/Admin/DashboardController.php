<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use RouterOS\Client;
use RouterOS\Exceptions\BadCredentialsException;
use RouterOS\Exceptions\ClientException;
use RouterOS\Exceptions\ConfigException;
use RouterOS\Exceptions\ConnectException;
use RouterOS\Exceptions\QueryException;
use RouterOS\Query;

class DashboardController extends Controller
{
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
        ]);
    }

//    public function index(): Response
//    {
//
//        return Inertia::render('Dashboard');
//
//    }

    /**
     * @throws ClientException
     * @throws ConnectException
     * @throws BadCredentialsException
     * @throws QueryException
     * @throws ConfigException
     */
    public function resource(): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();

        $getAllIP = Setting::all();
        $getIP = $getAllIP->find($user);

        $client = $this->mikrotik($getIP);

        $resource = $client->query('/system/resource/print')->read();

        // Send query and read response from RouterOS
        return response()->json([
            'resource' => $resource,
        ]);

    }

    /**
     * @throws ClientException
     * @throws ConnectException
     * @throws BadCredentialsException
     * @throws QueryException
     * @throws ConfigException
     */
    public function interface(): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();

        $getAllIP = Setting::all();
        $getIP = $getAllIP->find($user);

        $client = $this->mikrotik($getIP);

        $interface = $client->query('/interface/print')->read();


        // Send query and read response from RouterOS
        return response()->json([
            'interface' => $interface,
        ]);

    }


}
