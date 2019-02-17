<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $users = User::all();
    return response()->json(['data' => $users], 200);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //we first validate the only these 3 fileds from the user request
    $this->validate($request, [
      'name' => 'required',
      'email' => 'required|email|max:191|unique:users',
      'password' => 'required|min:6|confirmed',
    ]);

    $data = $request->all();
    $data['password'] = bcrypt($request->password);
    $data['verified'] = User::UNVERIFIED_USER;
    $data['verification_token'] = User::generateVerificationCode();
    $data['admin'] = User::REGULAR_USER;

    // return User::create($data);
    $user = User::create($data);
    return response()->json(['data' => $user]);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $user = User::findOrFail($id);
    return response()->json(['data' => $user], 200);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $user = User::findOrFail($id);
    $this->validate($request, [
      'email' => 'email|max:191|unique:users,email,'.$user->id,
      'password' => 'min:6|confirmed',
      'admin' => 'in:' . User::ADMIN_USER . ',' . User::REGULAR_USER,
    ]);

    if ($request->has('name')) {
      $user->name = $request->name;
    }
    if ($request->has('email') && $user->email != $request->email) {
      $user->verified = User::UNVERIFIED_USER;
      $user->verification_token = User::generateVerificationCode();
      $user->email = $request->email;
    }
    if ($request->has('password')) {
      $user->password = bcrypt($request->password);
    }
    if ($request->has('admin')) {
      if(!$user->isVerified()) {
        return response()->json(['error' => 'only verified users can modify admin field']);
      }
      $user->admin = $request->admin;
    }

    // when user sends an update request with changing any field data
    if ($user->isClean()) {
      return response()->json(['error' => 'You need to update a field before sending a new update'], 422);
    }

    $user->save();
    return response()->json(['data' => $user]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $user = User::findOrFail($id);
    $user->delete();
    
    return response()->json(['data' => 'user has been deleted']);
  }
}
