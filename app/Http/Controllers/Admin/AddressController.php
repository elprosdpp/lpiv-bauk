<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\getMikrotikIP;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use RouterOS\Exceptions\BadCredentialsException;
use RouterOS\Exceptions\ClientException;
use RouterOS\Exceptions\ConfigException;
use RouterOS\Exceptions\ConnectException;
use RouterOS\Exceptions\QueryException;
use RouterOS\Query;

class AddressController extends Controller
{
    use getMikrotikIP;

    public function __construct()
    {
        $this->middleware('can:address list', ['only' => ['index', 'show']]);
        $this->middleware('can:address create', ['only' => ['create', 'store']]);
        $this->middleware('can:address edit', ['only' => ['edit', 'update']]);
        $this->middleware('can:address delete', ['only' => ['destroy']]);
    }

    /**
     * @throws ClientException
     * @throws ConnectException
     * @throws QueryException
     * @throws BadCredentialsException
     * @throws ConfigException
     */
    public function getAllIpAddress(): mixed
    {
        $getIP = $this->connectIP();

        $query = (new Query('/ip/address/print'));
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
    public function index(): \Inertia\Response
    {
        $out = $this->getAllIpAddress();

//        dd($out);

        return Inertia::render('Admin/Monitoring/Address/Index', [
            'IpAddress' => $out,
            'can' => [
                'create' => Auth::user()->can('address create'),
                'edit' => Auth::user()->can('address edit'),
                'delete' => Auth::user()->can('address delete'),
            ]
        ]);
    }
}
