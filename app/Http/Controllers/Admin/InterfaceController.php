<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
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
     * @return mixed
     * @throws BadCredentialsException
     * @throws ClientException
     * @throws ConfigException
     * @throws ConnectException
     * @throws QueryException
     */
    public function getAllInterface(): mixed
    {
        $user = Auth::user();

        $getAllIP = Setting::all();
        $getIP = $getAllIP->find($user);

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
        $user = Auth::user();

        $getAllIP = Setting::all();
        $getIP = $getAllIP->find($user);

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

        return Inertia::render('Admin/Monitoring/Interface/Index', [
            'int' => $out,
            'can' => [
                'create' => Auth::user()->can('interface create'),
                'edit' => Auth::user()->can('interface edit'),
                'delete' => Auth::user()->can('interface delete'),
            ]
        ]);
    }

    public function detail($ether): \Inertia\Response
    {
        return Inertia::render('Admin/Monitoring/Interface');
    }


    public function stream(\Illuminate\Support\Facades\Request $request, $ether): StreamedResponse
    {
        $response = new StreamedResponse(function () use ($ether) {
            while (true) {
                // Lakukan logika untuk mendapatkan data SSE dari sumber data Anda
                $out = $this->getMonitorTrafficInterface($ether);


                $data = [
                    'message' => 'Data Ether Update',
                    'timestamp' => now(),
//                    'data' => $out,
                    'name' => $out[0]["name"],
                    'tx_byte' => $out[0]["tx-bits-per-second"],
                    'rx_byte' => $out[0]["rx-bits-per-second"]
                ];


                // Kirimkan data SSE ke client
                echo "data: " . json_encode($data) . "\n\n";
                ob_flush();
                flush();

                // Tambahkan delay jika perlu sebelum mengirimkan data berikutnya
                sleep(1);
            }
        });

        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');
        $response->headers->set('Connection', 'keep-alive');

        return $response;

    }
}
