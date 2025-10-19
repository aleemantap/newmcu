<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
class LoginController extends Controller
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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function authenticated(Request $request, $user)
    {
        // Check is user active
        if($user->active == 'N') {
            Auth::logout();
            return redirect('login')->withErrors(['email' => 'Inactive user. Please contact your Administrator']);
        }

        // Check is user group enable
        if($user->userGroup->active == 'N') {
            Auth::logout();
            return redirect('login')->withErrors(['email' => 'User group has been disabled. Please contact your Administrator']);
        }

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember?$request->remember:false)) {
            // Check if user has setting language
            $appLocale = Auth::user()->setting != null ? Auth::user()->setting->language : 'en';
			
		
            // Set session and redirect to home
            session(['user' => Auth::user(), 'menus' => $this->menu(), 'app-locale' => $appLocale]);
			
            return redirect()->intended('home');
        }
    }

    /**
     * Get menu access
     *
     * @return array
     */
    private function menu()
    {
        
		$userGroupActions = collect(Auth::user()->userGroup->menuActions)->pluck('id')->toArray();

        $menus = Menu::where('parent_id', null)
                ->whereHas('actions', function($q) use ($userGroupActions) { $q->whereIn('id', $userGroupActions); })
                ->orderBy('sequence')
                ->get();

        return $menus;
    }
}
