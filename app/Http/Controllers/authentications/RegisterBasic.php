<?php

namespace App\Http\Controllers\authentications;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class RegisterBasic extends Controller
{
  public function index()
  {
    $users = User::orderBy('user_id', 'DESC')->whereNull('deleted_at')->get();
    return view('content.authentications.auth-register-basic', compact('users'));
  }
  public function store(Request $request){

    $userData = [
      'firstname' => $request->firstname,
      'middlename' => $request->middlename,
      'lastname' => $request->lastname,
      'role' => $request->role,
      'username' => $request->username,
      'email' => $request->email,
      'phone_number' => $request->phone,
      'password' => bcrypt($request->password),
      'created_at' => now(),
    ];

    $resultUser = User::insert($userData);

    if($resultUser){
      return response()->json(['Error' => 0, 'Message' => 'Successfully added a data']);
    }
  }
  public function update(Request $request){
    $userData = [
      'firstname' => $request->firstname,
      'middlename' => $request->middlename,
      'lastname' => $request->lastname,
      'username' => $request->username,
      'email' => $request->email,
      'phone_number' => $request->phone,
      'role' => $request->role,
    ];

    $resultUser = User::where('user_id', Crypt::decryptString($request->id))->update($userData);

    if($resultUser){
      return response()->json(['Error' => 0, 'Message' => 'Successfully update a data']);
    }
  }
  public function delete(Request $request){

    $userData = [
      'deleted_at' => now()
    ];

    $resultUser = User::where('user_id', Crypt::decryptString($request->id))->update($userData);

    if($resultUser){
      return response()->json(['Error' => 0, 'Message' => 'Successfully delete a data']);
    }
  }
}
