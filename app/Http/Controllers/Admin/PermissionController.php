<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionStoreRequest;
use App\Models\Permission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
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
//        $permissions = (new Permission)->newQuery();
//        $permissions->latest();
//        $permissions = $permissions->paginate(100)->onEachSide(2)->appends(request()->query());

        $permissions = DB::table('permissions')->when(Request::input('search'), function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        })->paginate(10)
            ->withQueryString();

        return Inertia::render('Admin/Permission/Index', [
            'permissions' => $permissions,
            'filters' => Request::only(['search']),
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

        return back()->with("message", "Data Permission Berhasil Ditambah");
    }

    public function edit($id): Response
    {
        $permission = \Spatie\Permission\Models\Permission::findById($id);

        return Inertia::render('Admin/Permission/Edit', [
            'permission' => $permission,
        ]);
    }

    public function update(PermissionStoreRequest $request, $id): RedirectResponse
    {
        $permission = \Spatie\Permission\Models\Permission::findById($id);
        $permission->update($request->validated());

        return to_route('permission.index')->with("message", "Data Permission Berhasil Diubah");
    }

    public function destroy($id): RedirectResponse
    {
        $permission = \Spatie\Permission\Models\Permission::findById($id);
        $permission->delete();

        return back()->with('message', "Data Permission Berhasil Dihapus");
    }
}
