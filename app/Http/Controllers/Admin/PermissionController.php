<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionStoreRequest;
use App\Models\Permission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:permission list', ['only' => ['index', 'show']]);
        $this->middleware('can:permission create', ['only' => ['create', 'store']]);
        $this->middleware('can:permission edit', ['only' => ['edit', 'update']]);
        $this->middleware('can:permission delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): Response
    {
        $permissions = (new Permission)->newQuery();
        $permissions->latest();
        $permissions = $permissions->paginate(100)->onEachSide(2)->appends(request()->query());

        return Inertia::render('Admin/Permission/Index', [
            'permissions' => $permissions,
            'can' => [
                'create' => Auth::user()->can('permission create'),
                'edit' => Auth::user()->can('permission edit'),
                'delete' => Auth::user()->can('permission delete'),
            ]
        ]);
    }

    public function store(PermissionStoreRequest $request): RedirectResponse
    {
        $permissions = $request->validated();

        \Spatie\Permission\Models\Permission::create($permissions);

//        return to_route('role.index')->with("message", "Data Permission Berhasil Ditambah");
        return back()->with("message", "Data Permission Berhasil Ditambah");
    }
}
