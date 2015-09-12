<?php

namespace App\Http\Controllers\Auth;

use App\Entity\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;
use Validator;
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

    public $rules = [
        'name' => 'required|max:255',
        'email' => 'required|email|max:255|unique:users',
        'password' => 'required|confirmed|min:6',
    ];


    /**
     * Create a new authentication controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => ['getLogout', 'getLog']]);
    }

    /**
     * register a new user
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @internal param array $data
     */
    protected function register(Request $request)
    {
        $this->validate($request, $this->rules);
        return User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        Auth::logout();

        return ['result' => 'success'];
    }

    /**
     * @return mixed
     */
    public function me()
    {
        return User::find(Authorizer::getResourceOwnerId());
    }

    /**
     * @return mixed
     */
    public function users()
    {
        return ['data' => User::latest()->get()];
    }
}
