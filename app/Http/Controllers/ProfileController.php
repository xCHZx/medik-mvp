<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Exception;

class ProfileController extends Controller

{
    /**
     * Display the user's profile form.
     */
    public function index(): View
    {
        return view('dashboard.profile.index', [
            'user' => Auth::user(),
        ]); 
    }

    /**
     * Display the edit user's profile form.
     */
    public function edit(): View
    {
        return view('dashboard.profile.edit', [
            'user' => Auth::user()
        ]);
    }

    /**
     * Display the password user's profile form.
     */
    public function changePassword(): View
    {
        return view('dashboard.profile.change-password', [
            'user' => Auth::user()
        ]);
    }


    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        try {
            app(UserController::class)->update($request);
            return Redirect::route('profile.index')->with('status', 'profile-updated');
        } catch (Exception $e) {
            return  $e;
        }
    }

    // update users password
    public function updatePassword(Request $request)
    {
        $currentPassword = Auth::user()->password;
        try {
            $validated = $request->validate([
                'currentPassword' => 'required',
                'newPassword' => 'required',
                'confirmNewPassword' => 'required'
            ]);
            // checar que conozca su contraseña
            if(!Hash::check($request->currentPassword,$currentPassword))
            {
                throw new Exception("incorrect password");
            }

            // checar que no use su contraseña anterior como la nueva
            if($request->currentPassword == $request->newPassword)
            {
                throw new Exception("Same password as new password");
            }
            
            app(UserController::class)->changePassword($validated);
            return Redirect::route('profile.index')->with('status', 'password-updated');
            
        } catch (Exception $e) 
        {
            app(LogController::class)->store(
                "Error",
                "El usuario #".Auth::user()->id." erro al intentar modificar su contraseña",
                "Profile",
                Auth::user()->id,
                $e->getMessage()
            );
            return Redirect::route('profile.change-password')->with('status', 'password-error');
            
        }
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
