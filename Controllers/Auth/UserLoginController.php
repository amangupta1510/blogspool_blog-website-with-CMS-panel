<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Auth;
use App\cart;
use App\user;
use App\http\Requests;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class UserLoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/user';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:user')->except('logout');
    }


    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('user_login');
    }


    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {     
       $this->validate($request, [
            'username'   => 'required',
            'password' => 'required'
        ]);

        if (Auth::guard('user')->attempt(['username' => $request->username, 'password' => $request->password, 'active' => 1], $request->get('remember'))) {
           if($request->href!=""){
             if($request->href=="/user/cart"){
                return redirect()->intended($request->href);
  }
            return redirect()->intended($request->href);
          }
            return redirect()->intended('/user');
        }
        return back()->withErrors(['msg', 'The'])->withInput($request->only('username', 'remember'));
    }

    public function logout(Request $request)
    {
        $this->guard('user')->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/user/login');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('user');
    }
public function username()
    {
        return 'username';
    }
}
