<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

//use Symfony\Component\Process\Process;

use Illuminate\Support\Facades\Process;


class TerminalController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Terminal/Index');
    }

    public function executeCommand(Request $request): \Illuminate\Http\JsonResponse
    {
//        $command = $request->input('command');

        $process = new Process(['ls']);
        $process->run();

        return response()->json([
            'output' => $process->getOutput(),
        ]);
    }

    public function executeProcess(Request $request): string

    {
        $process = new \Symfony\Component\Process\Process([$request->input('command')]);
        $process->setTimeout(3600); // Set timeout sesuai kebutuhan

        try {
            $process->run();

            if ($process->isSuccessful()) {
                return response()->json([
                    'output' => $process->getOutput(),
                ]);
            } else {
                return response()->json([
                    'error' => $process->getErrorOutput(),
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ]);
        }
    }

}
