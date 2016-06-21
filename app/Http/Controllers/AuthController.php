<?php namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use App\Http\Controllers\Controller;
use App\User;

use Socialite;
use Validator;
use Redirect;
use Response;
use Sentinel;
use Session;


class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider($provider=null)
    {
        if(!config("services.$provider")) Response::make("Not Found", 404); //just to handle providers that doesn't exist
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    /* 4 cases:
        1.  User register for the first time with Oauth
        2.  User sign in with Oauth, but is already registered
        3.  User sign in with Oauth, but has already used another Oauth service
        4.  User sign with an already used Oauth service
    */
    public function handleProviderCallback($provider=null)
    {
        try {
            $user = Socialite::driver($provider)->user();
        } catch (Exception $e) { // Cannot retrieve OAuth user data
            return Redirect::to('login');
        }

        $password = str_random(10);
        $OAuthUser = $this->findOrCreateUser($user, $provider, $password);

        try {
            $user = Sentinel::findById($OAuthUser->id);

            if (Sentinel::authenticateOauth($user)) {
                Sentinel::login($user);
                return Redirect::route('home')->with('success', 'Welcome <b>' . $user->email . '!</b>');
            } else {
                return Redirect::route('login')->with('error', 'Cannot authenticate.');
            }
        } catch (NotActivatedException $e) {

            return Redirect::route('login')->with('error', $e->getMessage());
        }
    }

    /**
     * Return user if exists; create and return if doesn't
     *
     * @param $githubUser
     * @return User
     */
    private function findOrCreateUser($user, $provider, $password)
    {
        if ($userExist = User::where('email', '=', $user->email)->first()) {
            if ($userProvider = User::where($provider . '_id', '=', $user->id)->first()) { // User is already registered with this oauth service
                return $userProvider;
            } else { // User exists but has never used this service provider before
                // Update user with new provider_id
                $new_provider = $provider . '_id';
                $userExist->$new_provider = $user->id;
                $userExist->save();  

                return $userExist;                
            } // end if
        } else {
            // Register and activate new user and proceed to authentication. Return password.

            $credentials = [
                'email' => $user->email,
                'password' => $password,
                $provider . '_id' => $user->id,
                'avatar' => $user->avatar
            ];

            $user = Sentinel::register($credentials, false);
            if ($user) {
                $role = Sentinel::findRoleBySlug('user');

                $role->users()->attach($user);
            }

            Session::flash('warning', "You successfully signed in via OAuth <span class='fa fa-smile-o'></span>.<br/>Your default attributed password: <b>$password</b><br/>Take a note of your password now, as you won't be able to access it anymore. You can always sign in with your favorite OAuth service tough.");
            return $user;
        } // end if
    }
}