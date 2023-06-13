<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use RouterOS\Client;
use RouterOS\Exceptions\BadCredentialsException;
use RouterOS\Exceptions\ClientException;
use RouterOS\Exceptions\ConfigException;
use RouterOS\Exceptions\ConnectException;
use RouterOS\Exceptions\QueryException;
use RouterOS\Query;
use Symfony\Component\HttpFoundation\StreamedResponse;

class InterfaceController extends Controller
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

    /**
     * @return Collection|Model|mixed|null
     */
    private function getIP(): mixed
    {
        $user = Auth::user();

        $getAllIP = Setting::all();
        return $getAllIP->find($user);
    }


    /**
     * @return mixed
     * @throws BadCredentialsException
     * @throws ClientException
     * @throws ConfigException
     * @throws ConnectException
     * @throws QueryException
     */
    public function getAllInterface(): mixed
    {
        $getIP = $this->getIP();
//        dd($user);

        $client = $this->mikrotik($getIP);
        $query = (new Query('/interface/print'));
        // Ask for monitoring details
        return $client->query($query)->read();
    }

    /**
     * @param $ether
     * @return mixed
     * @throws BadCredentialsException
     * @throws ClientException
     * @throws ConfigException
     * @throws ConnectException
     * @throws QueryException
     */
    function getMonitorTrafficInterface($ether): mixed
    {
        $getIP = $this->getIP();

        $client = $this->mikrotik($getIP);
        $query = (new Query('/interface/monitor-traffic'))
            ->equal('interface', $ether)
            ->equal('once');
        // Ask for monitoring details
        return $client->query($query)->read();
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
        $out = $this->getAllInterface();

//        dd($out);

        return Inertia::render('Admin/Monitoring/Interface/Index', [
            'int' => $out,
            'can' => [
                'create' => Auth::user()->can('interface create'),
                'edit' => Auth::user()->can('interface edit'),
                'delete' => Auth::user()->can('interface delete'),
            ]
        ]);
    }


    //   View Detail Interface Monitor
    public function detail($ether): \Inertia\Response
    {
        return Inertia::render('Admin/Monitoring/Interface');
    }


    //    Stream Data Get All Interface
    public function stream(\Illuminate\Support\Facades\Request $request, $ether): StreamedResponse
    {
        $response = new StreamedResponse(function () use ($ether) {
            while (true) {
                // Logic Get Monitor Interface By Name URL
                $out = $this->getMonitorTrafficInterface($ether);

                $data = [
                    'message' => 'Data Ether Update',
                    'timestamp' => now()->toDateTimeString(),
//                    'data' => $out,
                    'name' => $out[0]["name"],
                    'tx_byte' => $out[0]["tx-bits-per-second"],
                    'rx_byte' => $out[0]["rx-bits-per-second"]
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
}
