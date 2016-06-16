<?php namespace App\Http\Controllers;

use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use App\User;
use App\Role;
use View;
use Redirect;
use Session;
use Input;
use Sentinel;
use Activation;

use Cartalyst\Sentinel\Checkpoints\NotActivatedException;

class SessionController extends Controller
{
    /**
     * Retrieve admin credentials.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

        // Retrieve admin email and password
        $query = Role::where('slug', '=', 'admin')->first();
        
        if ($query) {
            $user = $query->users()->first();
        } else {
            $user = NULL;
        }

        return View::make('login')->with('user', $user);
    }


    /**
     * Validate credentials
     *
     * @return \Illuminate\Http\Response
     */
    public function store() {
        
        $credentials = [
            'email' => Input::get('email'),
            'password' => Input::get('password'),
        ];

        try {
            $user = Sentinel::findByCredentials($credentials);

            // Check if user has completed activation
            /*if (!Activation::completed($user)) {
                return Redirect::route('login')->with('error', 'Your account has not been activated yet.');
            }*/

            if (Input::get('remember') == 'on') {
                if (Sentinel::authenticateAndRemember($credentials)) {
                    Sentinel::login($user);

                    return Redirect::route('admin')->with('success', 'Welcome <b>' . $user->email . '</b> with remember on');
                } else {
                    return Redirect::route('login')->with('error', 'Incorrect credentials');
                }
            } elseif (Sentinel::authenticate($credentials)) {
                Sentinel::login($user);

                return Redirect::route('admin')->with('success', 'Welcome <b>' . $user->email . '</b> with remember off');
            } else {
                return Redirect::route('login')->with('error', 'Incorrect credentials');
            }
        } catch (NotActivatedException $e) {
            return Redirect::route('login')->with('error', $e->getMessage());
        }

    }


    /**
     * Logout
     *
     * @return \Illuminate\Http\Response
     */
    public function logout() {
        
        Sentinel::logout();

        return Redirect::route('home');

    }

}
