<?php

use App\Events\MonitoringEvent;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

//use Ratchet\Http\HttpServer;
//use Ratchet\Server\IoServer;
//use Ratchet\WebSocket\WsServer;
//use App\WebSockets\TerminalWebSocket;

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
    //    Routes Global Function
    Route::resource('users', 'UserController');
    Route::resource('role', 'RoleController');
    Route::resource('category', 'CategoryController');
    Route::resource('interface', 'InterfaceController');
    Route::resource('hotspot', 'HotspotController');
    Route::resource('permission', 'PermissionController');
    Route::resource('post', 'PostController');
    Route::resource('setting', 'SettingController');
    Route::resource('address', 'AddressController');
    Route::resource('terminal', 'TerminalController');

    Route::post('/terminal/process/executeProcess', [\App\Http\Controllers\Admin\TerminalController::class, 'executeProcess']);

    //   Not Definition
    Route::post('/role/{role}/permissions', [\App\Http\Controllers\Admin\RoleController::class, 'givePermission'])->name('role.permissions');
    Route::post('/users/{users}', [\App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update');
    Route::delete('/role/{role}/permissions/{permission}', [\App\Http\Controllers\Admin\RoleController::class, 'revokePermission'])->name('roles.permissions.revoke');
    Route::get('/dashboard/resource', [\App\Http\Controllers\Admin\DashboardController::class, 'resource'])->name('dashboard.resource');
    Route::get('/dashboard/interface', [\App\Http\Controllers\Admin\DashboardController::class, 'interface'])->name('dashboard.interface');
    Route::get('/dashboard/ether1', [\App\Http\Controllers\Admin\DashboardController::class, 'ether1'])->name('dashboard.ether1');

    //    Routes Interface
    Route::get('/interface/stream/{ether}', [\App\Http\Controllers\Admin\InterfaceController::class, 'stream'])->name('interface.stream');
    Route::get('/interface/detail/{ether}', [\App\Http\Controllers\Admin\InterfaceController::class, 'detail'])->name('interface.detail');

    //    Routes Hotspot
    Route::get('/hotspot/profile/{profile}', [\App\Http\Controllers\Admin\HotspotController::class, 'detailHotspot'])->name('hotspot.profile');
    Route::get('/hotspot/user/active', [\App\Http\Controllers\Admin\HotspotController::class, 'activeHotspot'])->name('hotspot.active');
    Route::get('/hotspot/user/StreamActiveHotspot', [\App\Http\Controllers\Admin\HotspotController::class, 'StreamActiveHotspot'])->name('hotspot.StreamActiveHotspot');
    Route::get('/hotspot/user/create', [\App\Http\Controllers\Admin\HotspotController::class, 'createUserHotspot'])->name('hotspot.add');
    Route::delete('/hotspot/user/remove/{id}', [\App\Http\Controllers\Admin\HotspotController::class, 'removeUserHotspot'])->name('hotspot.destroy');
    Route::post('/hotspot/user/store', [\App\Http\Controllers\Admin\HotspotController::class, 'addUserHotpot'])->name('hotspot.store');
});


Route::middleware('auth')->group(function () {
    Route::get('/updateProfil', [\App\Http\Controllers\ProfileImageController::class, 'index'])->name('updateProfil.index');
    Route::put('/updateProfil/{user}', [\App\Http\Controllers\ProfileImageController::class, 'update'])->name('updateProfil.updateImage');
});

//Route Broadcast
Route::get('/broadcast', function () {
    broadcast(new MonitoringEvent());
});

require __DIR__ . '/auth.php';
