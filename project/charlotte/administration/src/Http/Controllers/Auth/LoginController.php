<?php

namespace Charlotte\Administration\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Charlotte\Administration\Middleware\AdministratorLogged;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller {
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
    protected $redirectTo = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->redirectTo = route('administration.index');

        $this->middleware(AdministratorLogged::class, ['except' => ['logout']]);
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm() {
        return view('administration::auth.login');
    }

    protected function guard() {
        return Auth::guard(config('administration.guard'));
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendFailedLoginResponse(Request $request) {
        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors([
                $this->username() => trans('administration::admin.auth_failed'),
            ]);
    }

    public function logout(Request $request) {
        $this->guard()->logout();
//        $request->session()->invalidate();
        return Redirect::route('administration.login');
    }
}
