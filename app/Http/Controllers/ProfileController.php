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

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('dashboard.profile.account', [
            'user' => $request->user(),
        ]);

        
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        
        $request->user()->fill($request->all());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    // update users password
    public function updatePassword(Request $request)
    {
        $currentPasword = $request->user()->password;
        $validated = $request->validate([
            'currentPassword' => 'required',
            'newPassword' => 'required'
        ]);

        // checar que conozca su contraseña
        if(Hash::check($request->currentPassword,$currentPasword))
        {
            // checar que no use su contraseña anterior como la nueva
            if($request->currentPassword != $request->newPassword){
                $user = User::find($request->user()->id);
                $user->password = $request->newPassword;
                $user->save();

                return Redirect::route('profile.edit')->with('status', 'password-updated');
            }else{
                return Redirect::route('profile.edit')->with('status', 'password-error');

            }
            
            
        }else{
            return Redirect::route('profile.edit')->with('status', 'password-error');

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
