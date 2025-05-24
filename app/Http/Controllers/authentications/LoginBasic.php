<?php

namespace App\Http\Controllers\authentications;

use Throwable;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class LoginBasic extends Controller
{
  public function index()
  {
    return view('content.authentications.auth-login-basic');
  }
  public function login(Request $request)
  {
    $account = User::where('username', $request->email)->whereNull('deleted_at')->first();

    if (!$account || !Hash::check($request->password, $account->password)) {
        return redirect()->back()->withErrors([
          'email' => 'The provided credentials do not match our records.',
        ]);
    }

    Auth::login($account);
    return redirect()->route('dashboard-analytics');
  }
  public function logoutAccount(Request $request)
  {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login');
  }
  public function redirect($provider)
  {
      return Socialite::driver($provider)->redirect();
  }
  public function callback($provider)
  {
    try {
        $user = Socialite::driver($provider)->stateless()->user();
    } catch (Throwable $e) {
      return redirect('/login')->with('error', 'Authentication failed.');
    }

    $existingUser = User::where('email', $user->getEmail())->first();

    if ($existingUser) {
        Auth::login($existingUser);
        return redirect()->route('dashboard-analytics');
    } else {
      return redirect('/')->with('error', 'Invalid Login!!! This Emmail didnt register.'); //
    }

  }
}
