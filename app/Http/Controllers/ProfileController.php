<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // $request->user()->fill($request->validated());
        $validated = $request->validated();


        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        // jika ada gambar / ada isi inputan file (jgn lupa artisan storage:link)
        // if($request->hasFile('avatar')) {
        //     // jika si user sudah ada data avatar sebelumnya, maka data avatar yang lama akan dihapus agar irit storage
        //     if(!empty($request->user()->avatar)) {
        //         // gunakan facades storage (karena tidak bisa langsung mendapatkan request filenya), untuk mencari data avatar dan kemudian hapus datanya
        //         Storage::disk('public')->delete($request->user()->avatar);
        //     }
        //     $path = $request->file('avatar')->store('img/avatars', 'public'); // disimpan ke folder storage/app/public/img/avatars dan di kirimkan ke public/img/avatars untuk ditampilkan di view
        //     $validated['avatar'] = $path;
        // }

        // ? gunakan versi untuk filepond ini untuk melakuikan proses periksa, hapus dan pindahkan data avatar 
        if ($request->avatar) {
            if (!empty($request->user()->avatar)) {
                // hapus avatar lama jika si user sudah ada avatar lama sebelumnya dan akan diganti dengan avatar baru
                Storage::disk(config('filesystems.default_public_disk'))->delete($request->user()->avatar);
            }

            // gunakan helper 'Str::after' mengambil nama file saja dari nama path+file (misalkan img/temp_avatars/ashcbhajcbhjac.png maka yang akan diambil nama file nya saja : ashcbhajcbhjac.png)
            $newFileName = Str::after($request->avatar, 'img/temp_avatars/');

            // memindahkan file dari folder 'img/temp_avatars' ke 'img/avatars'
            Storage::disk(config('filesystems.default_public_disk'))->move($request->avatar, 'img/avatars/' . $newFileName);

            // divalidasi datanya agar bisa dikirim ke database (path avatarnya)
            $validated['avatar'] = 'img/avatars/' . $newFileName;
        }

        // $request->user()->save();
        $request->user()->update($validated); // gunakan yang ini

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    // fungsi untuk upload avatar filepond
    public function upload(Request $request)
    {
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('img/temp_avatars', config('filesystems.default_public_disk'));
        }

        return $path;
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
