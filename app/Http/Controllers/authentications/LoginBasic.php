<?php

namespace App\Http\Controllers\authentications;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
}
