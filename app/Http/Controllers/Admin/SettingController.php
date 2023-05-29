<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

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
     * Display a listing of the resource.
     *
     * //     @return \Illuminate\Http\Response
     */


    public function index():Response
    {
        return Inertia::render('Admin/Setting/Index', [
            'filters' => \Illuminate\Support\Facades\Request::only(['search']),
            'can' => [
                'create' => Auth::user()->can('setting create'),
                'edit' => Auth::user()->can('setting edit'),
                'delete' => Auth::user()->can('setting delete'),
            ]
        ]);
    }
}
