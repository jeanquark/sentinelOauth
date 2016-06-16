<?php namespace App\Http\Controllers;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use Socialite;
use Redirect;
use Response;
use Sentinel;
use Session;

use Cartalyst\Sentinel\Checkpoints\NotActivatedException;

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
            // Retrieve User data from Oauth service provider
            //dd($provider);
            //dd(Socialite::driver('github');
            //$user = Socialite::driver('github')->user();
            $user = Socialite::driver($provider)->user();
            //$user = Socialite::with($provider)->user();
            //dd($user);
        } catch (Exception $e) { // Cannot retrieve Oauth user data
            return Redirect::to('login');
        }
        //dd($user);
        //$authUser = $this->findOrCreateUser($user, $provider);
        $password = str_random(10);
        $OAuthUser = $this->findOrCreateUser($user, $provider, $password);
        //dd($OAuthUser);
        //Auth::login($authUser, true);
        //dd($user);
        try {
            $user = Sentinel::findById($OAuthUser->id);
        //dd($user);

        //dd($password);

            if (Sentinel::authenticateOauth($user)) {
                Sentinel::login($user);
                return Redirect::route('home')->with('success', 'Welcome <b>' . $user->email . '!</b>');
            } else {
                return Redirect::route('login')->with('error', 'Cannot authenticate.');
            }
        } catch (NotActivatedException $e) {

            return Redirect::route('login')->with('error', $e->getMessage());
        }

        //return Redirect::route('home')->with('success', 'Welcome <b>' . $user->email . '!</b>');
        
        //return Redirect::route('home');
    }

    /**
     * Return user if exists; create and return if doesn't
     *
     * @param $githubUser
     * @return User
     */
    //private function findOrCreateUser($githubUser, $provider)
    private function findOrCreateUser($user, $provider, $password)
    {
        //if ($authUser = User::where($provider . '_id', '=', $githubUser->id)->first()) { // User is already registered with this oauth service
        // Check if user exists
        if ($userExist = User::where('email', '=', $user->email)->first()) {
            // Check if user has already registered with this Oauth service provider
            if ($userProvider = User::where($provider . '_id', '=', $user->id)->first()) { // User is already registered with this oauth service
                //dd($password);
                //$credentials = ['email' => $authUser->email, 'password' = $authUser->password];
                //return $authUser;
                //dd($user2);
                return $userProvider;
            } else { // User exists but has never used this service provider before
                // Update user with new provider_id
                $provider1 = $provider . '_id';
                //dd($provider1);
                $userExist->$provider1 = $user->id;
                //$user1->$provider . '_id' = $user->id; 
                $userExist->save();  
                //dd($user1);
                return $userExist;                
            } // end if
        } else {
            // Register and activate new user and proceed to authentication. Return password.
            
            /*return User::create([
                'email' => $user->email,
                'password' => password_hash($password, PASSWORD_BCRYPT),
                $provider . '_id' => $user->id,
                'avatar' => $user->avatar
            ]);*/
            
            //$provider1 = $provider . '_id';

            $credentials = [
                'email' => $user->email,
                'password' => $password,
                $provider . '_id' => $user->id,
                'avatar' => $user->avatar
            ];

            $user = Sentinel::register($credentials, false);
            //dd($user);
            if ($user) {
                $role = Sentinel::findRoleBySlug('user');

                $role->users()->attach($user);
            }

            Session::flash('warning', "You successfully signed in via OAuth <span class='fa fa-smile-o'></span>.<br/>Your default attributed password: <b>$password</b><br/>Take a note of your password now, as you won't be able to access it anymore. You can always sign in with your favorite OAuth service tough.");
            //dd($user);
            return $user;
        } // end if
    }
}



