<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class UserController extends Controller
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
    public function index(): Response
    {
//        $users = (new User)->newQuery();
//        $users->latest();
//        $users = $users->paginate(100)->onEachSide(2)->appends(request()->query());
        $users = DB::table('users')->when(\Illuminate\Support\Facades\Request::input('search'), function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        })->paginate(10)
            ->withQueryString();

        return Inertia::render('Admin/User/Index', [
            'users' => $users,
            'filters' => \Illuminate\Support\Facades\Request::only(['search']),
            'can' => [
                'create' => Auth::user()->can('user create'),
                'edit' => Auth::user()->can('user edit'),
                'delete' => Auth::user()->can('user delete'),
            ]
        ]);
    }

    public function create(): Response
    {
        //Get All Role
        $roles = Role::pluck('name');

        return Inertia::render('Admin/User/Create', [
            'roles' => $roles
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:' . User::class,
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->input('role'));
        $user->givePermissionTo($request->input('permission'));

        return to_route('users.index')->with("message", "Berhasil Menambah User");
    }

    public function edit($id): Response
    {

        //Get 1 User
        $users = User::all();
        $user = $users->find($id);

        //Get All Role & Permission
        $roles = Role::pluck('name');
        $permissions = Permission::pluck('name');

        //Get By ID
        $roleJSON = DB::table('view_assignrole_user')->where('id', $id)->select('name')->get();
        $permissionJSON = DB::table('view_givepermission_user')->where('id', $id)->select('name')->get();

        $data = $roleJSON->collect();
        $plucked = $data->pluck('name')->all();

        $permissionData = $permissionJSON->collect();
        $pluckedPermission = $permissionData->pluck('name')->all();


        return Inertia::render('Admin/User/Edit', [
            'user' => $user,
            'roles' => $roles,
            'permissions' => $permissions,
            'roleJSON' => $plucked,
            'permissionJSON' => $pluckedPermission
        ]);

    }

    public function update(Request $request, User $user): RedirectResponse
    {
        //Get 1 User
        $users = User::all();
        $data = $users->find($user);

        //Validation Update
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => ['sometimes', 'array'],
            'permission' => ['sometimes', 'array'],
        ]);

        //Update Data User Role & Permission
//        dd($request->name);
        if (\Illuminate\Support\Facades\Request::file('image_profile')) {
            Storage::delete('public/' . $user->image_profile);
            $image = \Illuminate\Support\Facades\Request::file('image_profile')->store('images', 'public');

            $user->update([
                'name' => \Illuminate\Support\Facades\Request::input('name'),
                'image_profile' => $image
            ]);
        } else {
            $user->update([
                'name' => \Illuminate\Support\Facades\Request::input('name'),
//                'image_profile' => $image
            ]);
        }

        //Update Role & Permission
        $user->syncRoles($request->input('role'));
        $user->syncPermissions($request->input('permission'));

        return to_route('users.index')->with("message", "Data User Berhasil Diubah");
    }

    public function destroy($id): RedirectResponse
    {
        //Get 1 User
        $users = User::all();
        $data = $users->find($id);

        $data->delete();

        return back()->with("message", "Data User Berhasil Dihapus");
    }


}
