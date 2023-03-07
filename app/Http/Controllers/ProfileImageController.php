<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileImageRequest;
use App\Models\ProfileImage;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class ProfileImageController extends Controller
{
    public function index(): Response
    {
        $getAllData = ProfileImage::all();
        $data = $getAllData->where('user_id', Auth::id());

//        dd($data);
        return Inertia::render('Profile/Index', compact('data'));
    }


    public function update(User $user): RedirectResponse
    {
        $id = $user->id;

        if (Request::file('image_profile')) {
            Storage::delete('public/' . $user->image_profile);
            $image = Request::file('image_profile')->store('images', 'public');

            $user->update([
                'id' => $id,
                'name' => Request::input('name'),
                'email' => Request::input('email'),
                'image_profile' => $image
            ]);

        } else {

            $user->update([
                'id' => $id,
                'name' => Request::input('name'),
                'email' => Request::input('email'),
//                'image_profile' => $image
            ]);

        }
        return Redirect::route('dashboard')->with("message", "Data Profil Berhasil Diubah");

    }

    private function delete_image($dossier, $image)
    {
        $destination = $dossier . $image;
        if (File::exists($destination)) {
            if ($image != 'noimage.jpg') {
                // Delete Image
                File::delete($destination);
                error_log('File::delete');
            } else {
                error_log('noimage else');
            }
        } else {
            error_log('File::existselse');
        }
    }
}
