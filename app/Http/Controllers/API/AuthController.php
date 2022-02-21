<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
  /**
   * Authentication.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function login(Request $request)
  {
    //
  }

  /**
   * Register user.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function register(RegisterRequest $request)
  {
    $data = $request->validated();

    $user = User::create($data);

    return response()
      ->json([
        'data' => $user,
        'message' => 'User created'
      ], 201);
  }
}
