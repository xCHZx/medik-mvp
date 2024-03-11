<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\LogController;
use App\Http\Controllers\UserController;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Error;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'firstName' => ['required', 'string', 'max:255'],
                'lastName' => ['required', 'string', 'max:255'],
                'phone' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

        } catch (Error $e) {
            return Redirect::route('register')->with('status', 'register-error');
        }

        try{
        // $user = User::create([
        //     'firstName' => $request->firstName,
        //     'lastName' => $request->lastName,
        //     'phone' => $request->phone,
        //     'email' => $request->email,
        //     'password' => Hash::make($request->password),
        // ]);

       $user = app(UserController::class)->store(
            $request->firstName,
            $request->lastName,
            $request->phone,
            $request->email,
            Hash::make($request->password)
        );



       event(new Registered($user));


        $user->createAsStripeCustomer([
            'name' => "{$user->firstName} {$user->lastName}",
            'email' => $user->email,
            'phone' => $user->phone,
        ]);

            Auth::login($user);

            // app(LogController::class)->store(
            //     "success", //tipo
            //     "El usuario #".Auth::user()->id.", se registró",//contenido
            //     "Registro", //categoria
            //     Auth::user()->id, //userId
            //     Auth::user() //descripcion (Payload o Exception)
            //     );
            return redirect()->route('dashboard.index');

        }catch(Exception $e){
            // app(LogController::class)->store(
            //     "error", //tipo
            //     "Intento fallido de registro",//contenido
            //     "Registro", //categoria
            //     0, //userId, 0 internal issues
            //     $e //descripcion (Payload o Exception)
            //     );
            // return $e;
        }

    }
}
