<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use App\User;

use Validator;
use View;
use Sentinel;

class AdminController extends Controller
{
    /**
     * Retrieve all users
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $users = User::all();

        return View::make('admin.index')->with('users', $users);
    }

}
