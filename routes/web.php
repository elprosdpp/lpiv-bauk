<?php

use App\Events\MonitoringEvent;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::group(['prefix' => '/admin', 'middleware' => 'auth'], function () {


//    Independent Dashboard
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');


    //Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    //Posts
    Route::get('/posts', function () {
        return Inertia::render('Posts');
    })->name('posts');

});

Route::group([
    'namespace' => 'App\Http\Controllers\Admin',
    'prefix' => 'admin',
    'middleware' => ['auth'],
], function () {
    Route::resource('users', 'UserController');
    Route::resource('role', 'RoleController');
    Route::resource('category', 'CategoryController');
    Route::resource('interface', 'InterfaceController');
//    Route::resource('dashboard', 'DashboardController');
    Route::post('/role/{role}/permissions', [\App\Http\Controllers\Admin\RoleController::class, 'givePermission'])->name('role.permissions');
    Route::post('/users/{users}', [\App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update');
    Route::delete('/role/{role}/permissions/{permission}', [\App\Http\Controllers\Admin\RoleController::class, 'revokePermission'])->name('roles.permissions.revoke');
    Route::get('/dashboard/resource', [\App\Http\Controllers\Admin\DashboardController::class, 'resource'])->name('dashboard.resource');
    Route::get('/dashboard/interface', [\App\Http\Controllers\Admin\DashboardController::class, 'interface'])->name('dashboard.interface');
    Route::get('/dashboard/ether1', [\App\Http\Controllers\Admin\DashboardController::class, 'ether1'])->name('dashboard.ether1');
    Route::get('/interface/stream/{ether}', [\App\Http\Controllers\Admin\InterfaceController::class, 'stream'])->name('interface.stream');
    Route::get('/interface/detail/{ether}', [\App\Http\Controllers\Admin\InterfaceController::class, 'detail'])->name('interface.detail');
    Route::resource('permission', 'PermissionController');
    Route::resource('post', 'PostController');
    Route::resource('setting', 'SettingController');
});


//->middleware(['auth', 'verified'])

Route::middleware('auth')->group(function () {
    Route::get('/updateProfil', [\App\Http\Controllers\ProfileImageController::class, 'index'])->name('updateProfil.index');
    Route::put('/updateProfil/{user}', [\App\Http\Controllers\ProfileImageController::class, 'update'])->name('updateProfil.updateImage');
});

//Route Broadcast
Route::get('/broadcast', function () {
    broadcast(new MonitoringEvent());
});

require __DIR__ . '/auth.php';
