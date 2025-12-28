<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordUpdateRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();
        $user->load([
            'recipes' => fn($q) => $q->withCount('reviews'),
            'reviews.recipe'
        ]);
        $isOwner = true;

        return view('profile.index', compact('user', 'isOwner'));
    }

    public function show(User $user)
    {
        // If viewing own profile, redirect to profile.index
        if (Auth::check() && Auth::id() === $user->id) {
            return redirect()->route('profile.index');
        }

        $user->load([
            'recipes' => fn($q) => $q->withCount('reviews'),
            'reviews.recipe'
        ]);
        $isOwner = false;

        return view('profile.index', compact('user', 'isOwner'));
    }

    public function edit()
    {
        /** @var User $user */
        $user = Auth::user();

        return view('profile.edit', compact('user'));
    }

    public function update(ProfileUpdateRequest $request)
    {
        /** @var User $user */
        $user = $request->user();
        $data = $request->validated();

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($data);

        return redirect()->route('profile.index')->with('status', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(PasswordUpdateRequest $request)
    {
        /** @var User $user */
        $user = $request->user();
        $user->update([
            'password' => Hash::make($request->validated()['password']),
        ]);

        return redirect()->route('profile.index')->with('status', 'Kata sandi berhasil diperbarui.');
    }
}
