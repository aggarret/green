<?php

namespace App\Http\Controllers\VolunteerAuth;

use App\Volunteer;
use Validator;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

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

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/volunteer/dashboard';
    protected $guard = 'volunteer';
    


    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }




    public function showLoginForm(){

        if(view()->exists('volunteer.auth.authenticate')){
            return view('volunteer.auth.authenticate');
        }
        return view('volunteer.auth.login');
    }
    
    public function showRegistrationForm(){

        return view('volunteer.auth.register');
    }







    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'firstName' => 'required|max:255',
            'email' => 'required|email|max:255|unique:volunteers',
            'password' => 'required|min:6|confirmed',
        ]);
    }




    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return Volunteer
     */
    protected function create(array $data)
    {
        return Volunteer::create([
            'firstName' => $data['firstName'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
}
