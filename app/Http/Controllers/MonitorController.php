<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Setting;
use Illuminate\Http\Request;
use RouterOS\Client;
use RouterOS\Exceptions\BadCredentialsException;
use RouterOS\Exceptions\ClientException;
use RouterOS\Exceptions\ConfigException;
use RouterOS\Exceptions\ConnectException;
use RouterOS\Exceptions\QueryException;
use RouterOS\Query;
use Illuminate\Support\Facades\Auth;

class MonitorController extends Controller
{
    /**
     * @throws ClientException
     * @throws ConnectException
     * @throws QueryException
     * @throws BadCredentialsException
     * @throws ConfigException
     */
    public function __invoke(Request $request)
    {
//        $user = Auth::user();
//
//        $getAllIP = Setting::all();
//        $getIP = $getAllIP->find($user);
//
////        return Permission::all();
//        $client = new Client([
//            'host' => $getIP->ip_address_router,
//            'user' => $getIP->username_router,
//            'pass' => $getIP->password_router,
//            'port' => 8728,
//        ]);
//
//        $query = new Query('/system/resource/print');
//
//        // Send query and read response from RouterOS
//        $response = $client->query($query)->read();
//        return response()->json($response);
    }
}
