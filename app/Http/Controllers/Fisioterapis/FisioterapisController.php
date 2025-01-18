<?php

namespace App\Http\Controllers\Fisioterapis;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class FisioterapisController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $user = User::all();
    $data = [
      'users' => $user
    ];
    return view('fisioterapis.dashboard');
  }

}