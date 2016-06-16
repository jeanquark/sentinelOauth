<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\Exceptions\InvalidConfirmationCodeException;
use App\Exceptions\CannotActivateAccountException;
use App\Exceptions\UserNotFoundException;

use Redirect;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof InvalidConfirmationCodeException) {
            //return response()->view('errors.custom', [], 500);
            //return redirect()->to('/');
            return Redirect::route('home')->with('error', 'Your confirmation code is invalid.');
        }

        if ($e instanceof CannotActivateUserException) {
            return Redirect::route('home')->with('error', 'Sorry, your account cannot be activated.');
        }

        if ($e instanceof UserNotFoundException) {
            return Redirect::route('home')->with('error', 'Sorry, this email does not exist.');
        }

        return parent::render($request, $e);

    }
}
