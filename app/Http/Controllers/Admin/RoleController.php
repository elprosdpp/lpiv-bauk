<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionRequest;
use App\Http\Requests\RoleRequest;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:role list', ['only' => ['index', 'show']]);
        $this->middleware('can:role create', ['only' => ['create', 'store']]);
        $this->middleware('can:role edit', ['only' => ['edit', 'update', 'givePermission']]);
        $this->middleware('can:role delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): Response
    {
//        $roles = (new Role)->newQuery();
//        $roles->latest();
//        $roles = $roles->paginate(100)->onEachSide(2)->appends(request()->query());
        $permission = Permission::pluck('name');

        $roles = DB::table('view_index_permission_role')->when(Request::input('search'), function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        })->paginate(10)
            ->withQueryString();

//        dd($roles);

        return Inertia::render('Admin/Role/Index', [
            'roles' => $roles,
            'permission' => $permission,
            'filters' => Request::only(['search']),
            'can' => [
                'create' => Auth::user()->can('role create'),
                'edit' => Auth::user()->can('role edit'),
                'delete' => Auth::user()->can('role delete'),
            ]
        ]);
    }


    public function create(): Response
    {
        return Inertia::render('Admin/Role/Create');
    }

    public function store(RoleRequest $request, PermissionRequest $permissionRequest): RedirectResponse
    {
//        \Spatie\Permission\Models\Role::create($request->validated());
        $role1 = \Spatie\Permission\Models\Role::create($request->validated());
        $permissions = $permissionRequest->validated();

        foreach ($permissions as $permission) {
            $role1->givePermissionTo($permission);
        }

        return to_route('role.index')->with("message", "Data Role Berhasil Ditambah");
//        return back()->with('message', "Data Role Berhasil Ditambah");
    }

    public function edit($id): Response
    {
        $role = \Spatie\Permission\Models\Role::findById($id);
        $permission = Permission::pluck('name');
        $permissionJSON = DB::table('view_permission_role')->where('role_id', $id)->select('name')->get();

//       $data = $getID->toJson();
        $data = $permissionJSON->collect();
        $plucked = $data->pluck('name')->all();

//        dd($plucked);

        return Inertia::render('Admin/Role/Edit', [
            'role' => $role,
            'permission' => $permission,
            'permissionJSON' => $plucked
        ]);
    }

    public function update(RoleRequest $request, $id): RedirectResponse
    {
        $role = \Spatie\Permission\Models\Role::findById($id);
        $role->update($request->validated());

        return to_route('role.index')->with("message", "Data Role Berhasil Diubah");
//        return back()->with("message", "Data Role Berhasil Diubah");
    }


    public function destroy($id): RedirectResponse
    {
        $role = \Spatie\Permission\Models\Role::findById($id);
        $role->delete();

        return to_route('role.index')->with("message", "Data Role Berhasil Dihapus");
//        return back()->with('message', "Data Profil Berhasil Dihapus");
    }

    public function givePermission(PermissionRequest $request, Role $role): RedirectResponse
    {
//        if ($role->hasPermissionTo($request->permission)) {
//            return back()->with('message', 'Permission Sudah Tersedia');
//        }
        $permissions = $request->validated();
//
        foreach ($permissions as $permission) {
            $role->syncPermissions($permission);
        }

//        dd($permissions);
//        $role->givePermissionTo($permissions);
        return to_route('role.index')->with('message', 'Permission ' . $role->name . ' Berhasil Diubah');
//        return back()->with('message', 'Permission ' . $role->name . ' Berhasil Ditambah');
    }

    public function revokePermission(Role $role, Permission $permission): RedirectResponse
    {
        if ($role->hasPermissionTo($permission)) {
            $role->revokePermissionTo($permission);
            return back()->with('message', 'Permission Berhasil Dihapus.');
        }
        return back()->with('message', 'Permission Tidak Ada');
    }


}
