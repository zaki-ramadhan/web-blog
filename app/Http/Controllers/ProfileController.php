<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
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
        if($request->hasFile('avatar')) {
            // jika si user sudah ada data avatar sebelumnya, maka data avatar yang lama akan dihapus agar irit storage
            if(!empty($request->user()->avatar)) {
                // gunakan facades storage (karena tidak bisa langsung mendapatkan request filenya), untuk mencari data avatar dan kemudian hapus datanya
                Storage::disk('public')->delete($request->user()->avatar);
            }
            $path = $request->file('avatar')->store('img/avatars', 'public'); // disimpan ke folder storage/app/public/img/avatars dan di kirimkan ke public/img/avatars untuk ditampilkan di view
            $validated['avatar'] = $path;
        }

        // $request->user()->save();
        $request->user()->update($validated); // gunakan yang ini

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
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
