<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use View;
use Response;
use Redirect;
use Input;
use Mail;

use App\User;
use Validator;

class HomeController extends Controller
{
    /**
     * Display homepage.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        return View::make('home');

    }


    /**
     * Display about page.
     *
     * @return \Illuminate\Http\Response
     */
    public function about() {

        return View::make('about');

    }


    /**
     * Display services page.
     *
     * @return \Illuminate\Http\Response
     */
    public function services() {

        return View::make('services');

    }


    /**
     * Display contact page.
     *
     * @return \Illuminate\Http\Response
     */
    public function contact() {

        return View::make('contact');

    }

}
