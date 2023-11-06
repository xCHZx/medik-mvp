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
//^^^^Hay que cambiar el nombre del controlador a UserControler, ya que gestionamos funcionadas semánticamente de Usuarios -CJ
//Agregar descripciones contextuales si son necesarias, de funciones del Controler
//Agregar trycatch para tratamiento de datos y consumo de servicios
{
    /**
     * Display the user's profile form.
     */
    public function index(Request $request): View
    {
        return view('dashboard.profile.index', [
            'user' => $request->user(),
        ]); //Porque se recibe un request??? Simplificar con facade Auth -CJ
    }

    /**
     * Display the edit user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('dashboard.profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Display the password user's profile form.
     */
    public function changePassword(Request $request): View
    {
        return view('dashboard.profile.change-password', [
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

        return Redirect::route('profile.index')->with('status', 'profile-updated');
    }

    // update users password
    public function updatePassword(Request $request)
    {
        $currentPasword = $request->user()->password;
        $validated = $request->validate([
            'currentPassword' => 'required',
            'newPassword' => 'required',
            'confirmNewPassword' => 'required'
        ]); //Mejorar en base a observaciones anteriores

        // checar que conozca su contraseña
        if(Hash::check($request->currentPassword,$currentPasword))
        {
            // checar que no use su contraseña anterior como la nueva
            if($request->currentPassword != $request->newPassword){
                //Si vas a manejar validaciones con If no tires error con Else, sinocon Throw
                //Ver ejemplo en http/requests/auth/loginrequest
                $user = User::find($request->user()->id);
                $user->password = $request->newPassword;
                $user->save();

                return Redirect::route('profile.index')->with('status', 'password-updated');
            }else{
                return Redirect::route('profile.change-password')->with('status', 'password-error');
            }
        }else{
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
