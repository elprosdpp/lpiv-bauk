<?php


namespace App\Traits;

use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use RouterOS\Client;
use RouterOS\Exceptions\BadCredentialsException;
use RouterOS\Exceptions\ClientException;
use RouterOS\Exceptions\ConfigException;
use RouterOS\Exceptions\ConnectException;
use RouterOS\Exceptions\QueryException;

trait getMikrotikIP
{

    /**
     * @throws ClientException
     * @throws ConnectException
     * @throws BadCredentialsException
     * @throws QueryException
     * @throws ConfigException
     */
    public function mikrotik($getIP): Client
    {
        return new Client([
            'host' => $getIP->ip_address_router,
            'user' => $getIP->username_router,
            'pass' => $getIP->password_router,
            'port' => 8728,
        ]);
    }

    public function getIP(): mixed
    {
        $user = Auth::user();

        $getAllIP = Setting::all();
        return $getAllIP->find($user);
    }

    /**
     * @throws ClientException
     * @throws ConnectException
     * @throws BadCredentialsException
     * @throws QueryException
     * @throws ConfigException
     */
    public function connectIP(): Client
    {
        $getIP = $this->getIP();
        return $this->mikrotik($getIP);
    }

}


