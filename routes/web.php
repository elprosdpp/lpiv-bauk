<?php

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


    //Independent Dashboard
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
    Route::post('/role/{role}/permissions', [\App\Http\Controllers\Admin\RoleController::class, 'givePermission'])->name('role.permissions');
    Route::post('/users/{users}/edit', [\App\Http\Controllers\Admin\UserController::class, 'assignRole'])->name('users.assignRole');
    Route::delete('/role/{role}/permissions/{permission}', [\App\Http\Controllers\Admin\RoleController::class, 'revokePermission'])->name('roles.permissions.revoke');
    Route::resource('permission', 'PermissionController');
    Route::resource('post', 'PostController');
});


//->middleware(['auth', 'verified'])

Route::middleware('auth')->group(function () {
    Route::get('/updateProfil', [\App\Http\Controllers\ProfileImageController::class, 'index'])->name('updateProfil.index');
    Route::put('/updateProfil/{user}', [\App\Http\Controllers\ProfileImageController::class, 'update'])->name('updateProfil.updateImage');
});

require __DIR__ . '/auth.php';
