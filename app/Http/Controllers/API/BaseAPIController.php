<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

class BaseAPIController extends Controller
{
  public function me()
  {
    return auth()->user();
  }
}
