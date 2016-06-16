<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use View;
use Response;
use Redirect;
use Input;
use Mail;

//use App\User;
use Validator;
use Sentinel;
//use App\Activation;
//use App\Exceptions\Handler;
//use App\Exceptions\Handler\InvalidConfirmationCodeException;
//use App
use App\Exceptions\InvalidConfirmationCodeException;
use App\Exceptions\CannotActivateUserException;
//use Illuminate\Validation\ValidationException;
use App\Http\Requests\EmailRequest;
use App\Exceptions\UserNotFoundException;
use App\User;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Hash;
use Reminder;
use App\Http\Requests\PasswordResetRequest;
use Activation;
//use Cartalyst\Sentinel\Users\UserInterface;
use Hashids\Hashids;
//use Vinkla\Hashids\HashidsManager;

class RegistrationController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$roles = Role::orderBy('id', 'desc')->lists('name', 'id');

        return View::make('register');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register()
    {
        $rules = array(
            'email' => 'required|min:4|max:254|email|unique:users,email',
            'password' => 'required|min:4|confirmed',
            'password_confirmation' => 'required',
            'first_name' => 'min:2|max:32|alpha_dash',
            'last_name' => 'min:2|max:32|alpha_dash',
        );

        $validator = Validator::make(Input::all(), $rules);

        // Process storing
        if ($validator->fails()) {
            return Redirect::to('register')
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        } else {
            $credentials = [
                'email'    => Input::get('email'),
                'password' => Input::get('password'),
                'first_name' => Input::get('first_name'),
                'last_name' => Input::get('last_name')
            ];

            $user = Sentinel::register($credentials, true);
        }

        if ($user) {
            $role = Sentinel::findRoleBySlug('user');

            $role->users()->attach($user);

            return Redirect::Route('home')->with('success', 'Your account has been created. Check your email for the confirmation link.');
        } else {
            return Redirect::Route('home')->with('error', 'There was an error during the registration process.');
        }
    }


    public function confirm($confirmation_code)
    {
        if (!$confirmation_code)
        {
            throw new InvalidConfirmationCodeException;
        }

        //$user = Activation::whereConfirmationCode($confirmation_code)->first();
        $activate_user = Activation::where('code', '=', $confirmation_code)->first();

        if (!$activate_user)
        {
            throw new CannotActivateUserException;
        }

        $activate_user->completed = 1;
        $activate_user->code = null;
        $activate_user->save();

        //Flash::message('You have successfully verified your account.');

        //return Redirect::route('login_path');
        return Redirect::Route('login')->with('success', 'Your account has been successfully activated!');
    }   

    /**
     * Show the 'Resend Activation' form
     *
     * @return View
     */
    function resendActivationForm($hash)
    //function resendActivationForm($id)
    {
        //dd($hash);
        $hashids = new Hashids('sentinel_oauth', 8, 'abcdefghij1234567890');
        //var_dump($hash);
        $id = $hashids->decode($hash)[0];
        //dd($id);
        $user = Sentinel::findById($id);
        $email = $user->email;
        //dd($email);
        if ($user) {
            if (Activation::exists($user)) {
                if (!Activation::completed($user)) {
                    return View::make('sentinel.resend')
                        ->with('hash', $hash)
                        ->with('email', $email);
                } else {
                    //dd('Activation has already been completed');
                    // Activation has already been completed
                    throw new CannotActivateUserException;
                }
            } else {
                //dd('Activation does not exist');
                // Activation does not exist
                $activation = Activation::create($user);
                return View::make('sentinel.resend')->with('hash', $hash);
            }
        } else {
            //dd('User does not exist');
            // $user does not exist
            throw new UserNotFoundException;
        }
        
    }

    /**
     * Process resend activation request
     * @return Response
     */
    public function resendActivation(EmailRequest $request, $hash)
    //public function resendActivation(UserInterface $user)
    {
        // Resend the activation email
        /*$result = $this->userRepository->resend(['email' => e(Input::get('email'))]);

        // It worked!  Use config to determine where we should go.
        return $this->redirectViaResponse('registration_resend', $result);*/
        //dd($user);

        /*$email = Input::get('email');
        
        $credentials = [
            'email' => $email,
        ];

        $user = Sentinel::findByCredentials($credentials);
        //dd($user);
        if ($user) {
            $activation = Activation::exists($user);
            if (!$activation) {
                // Activation does not exist
                $activation = Activation::create($user);

                $confirmation_code = $activation->code;
                Mail::send('emails.registration', ['confirmation_code' => $confirmation_code], function ($m) use ($user) {
                    $m->from('yourname@yoursite.com', 'YOUR_SITE');

                    $m->to($user->email, $user->first_name)->subject('YOUR_SITE verification mail');
                });
                return Redirect::Route('home')->with('success', 'We sent you an email. Check your email for the confirmation link.');
            } else {
                //$user = Sentinel::findById(4);
                //dd($user);
                // activation exists
                if ($completed = Activation::completed($user)) {
                    // User has already completed activation
                } else {
                    // Activation exists but has not been completed
                    Activation::remove($user); // remove old activation
                    $activation = Activation::create($user); // create new activation

                    $confirmation_code = $activation->code;
                    Mail::send('emails.registration', ['confirmation_code' => $confirmation_code], function ($m) use ($user) {
                        $m->from('yourname@yoursite.com', 'YOUR_SITE');

                        $m->to($user->email, $user->first_name)->subject('YOUR_SITE verification mail');
                    });
                    return Redirect::Route('home')->with('success', 'We sent you an email. Check your email for the confirmation link.');
                }
            }
        } else {
            // user does not exist
            throw new UserNotFoundException;
        }*/
        
        //dd($hash);
        $hashids = new Hashids('sentinel_oauth', 8, 'abcdefghij1234567890');
        $id = $hashids->decode($hash)[0];
        $user = Sentinel::findById($id);

        if ($user) {
            if ($activation = Activation::exists($user)) {
                $confirmation_code = $activation->code;
                $email = Mail::send('emails.registration', ['confirmation_code' => $confirmation_code], function ($m) use ($user) {
                    $m->from('yourname@yoursite.com', 'YOUR_SITE');
                    $m->to($user->email, $user->first_name)->subject('YOUR_SITE verification mail');
                });
                /*Mail::send('emails.reminder', ['user' => $user], function ($m) use ($user) {
                    $m->from('hello@app.com', 'Your Application');

                    $m->to($user->email, $user->first_name)->subject('Your Reminder!');
                });*/
                
                if ($email) {
                    return Redirect::Route('home')->with('success', 'We sent you an email. Check your email for the confirmation link.');
                } else {
                    throw new CannotActivateUserException;
                }
            }
        }
    }

    /**
     * Display the "Forgot Password" form
     *
     * @return \Illuminate\View\View
     */
    public function forgotPasswordForm()
    {
        return View::make('sentinel.forgot');
    }


    /**
     * Process Forgot Password request
     * @return Response
     */
    public function sendResetPasswordEmail(EmailRequest $request)
    {
        /*// Send Password Reset Email
        $result = $this->userRepository->triggerPasswordReset(e(Input::get('email')));

        // It worked!  Use config to determine where we should go.
        return $this->redirectViaResponse('registration_reset_triggered', $result);



        try {
            $user = $this->sentry->getUserProvider()->findByLogin(e($email));

            $this->dispatcher->fire('sentinel.user.reset', [
                'user' => $user,
                'code' => $user->getResetPasswordCode()
            ]);

            return new SuccessResponse(trans('Sentinel::users.emailinfo'), ['user' => $user]);
        } catch (UserNotFoundException $e) {
            // The user is trying to send a password reset link to an account that doesn't
            // exist.  This could be a vector for determining valid existing accounts,
            // so we will send a vague response without actually doing anything.
            $message = trans('Sentinel::users.emailinfo');

            return new SuccessResponse($message, []);
        }*/

        $email = Input::get('email');
        //dd($email);
        // Send email with password reset form.
        $credentials = [
            'email' => $email
        ];

        // Does this user exists?
        if ($user = User::where('email', '=', $email)->first()) {

            $user = Sentinel::findById($user->id);
            $create = Reminder::create($user);
            $code = $create->code;
            //dd($create->code);
            // Save new password
            //$reminder = Reminder::complete($user, $code, 'secret1');
            //Reminder::removeExpired();

            // Send email with password reset form
            //$code = str_random(10);
            //$hash = Hash::make($user->id);
            $id = $user->id;

            //$data['hash'] = urlencode($hash);
            $data['id'] = $id;
            $data['code'] = $code;
            $data['email'] = $user->email;
            //$data['code1'] = urlencode($hash);
            //dd($data);

            Mail::send('sentinel.emails.reset', $data, function ($m) use ($user) {
                $m->from('yourname@yoursite.com', 'YOUR_SITE');

                $m->to($user->email, $user->first_name)->subject('YOUR_SITE reset password');
            });

            return Redirect::Route('home')->with('success', 'Check your email box and follow instructions to pick a new password.');
        } else {
            throw new UserNotFoundException;
        }
    }

    public function passwordResetForm($id, $code)
    {
        /*// Decode the hashid
        $id = $this->hashids->decode($hash)[0];

        // Validate Reset Code
        $result = $this->userRepository->validateResetCode($id, $code);

        if (! $result->isSuccessful())
        {
            return $this->redirectViaResponse('registration_reset_invalid', $result);
        }

        return $this->viewFinder('Sentinel::users.reset', [
            'hash' => $hash,
            'code' => $code
        ]);*/
        $user = Sentinel::findById($id);
        if (Reminder::exists($user)) {

            return View::make('sentinel.reset')->with('id', $id)->with('code', $code);

        } else {
            dd('Sorry, Invalid password reset link.');
        }
    }

    public function resetPassword(PasswordResetRequest $request, $id, $code)
    {
        // Decode the hashid
        /*$id = $this->hashids->decode($hash)[0];

        // Gather input data
        $data = Input::only('password', 'password_confirmation');

        // Change the user's password
        $result = $this->userRepository->resetPassword($id, $code, e($data['password']));

        // It worked!  Use config to determine where we should go.
        return $this->redirectViaResponse('registration_reset_complete', $result);*/

        $new_password = Input::get('password');

        $user = Sentinel::findById($id);

        if (Reminder::exists($user)) {

            $reminder = Reminder::complete($user, $code, $new_password);
            Reminder::removeExpired();

            return Redirect::Route('home')->with('success', 'Your password has been modified.');
        }
    }

}
