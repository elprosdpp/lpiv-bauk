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
use Symfony\Component\HttpFoundation\StreamedResponse;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:setting list', ['only' => ['index', 'show']]);
        $this->middleware('can:setting create', ['only' => ['create', 'store']]);
        $this->middleware('can:setting edit', ['only' => ['edit', 'update']]);
        $this->middleware('can:setting delete', ['only' => ['destroy']]);
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

}
