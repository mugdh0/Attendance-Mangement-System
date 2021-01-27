<?php

namespace App\Http\Controllers;
use App\AppSettings;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $obj_setting=AppSettings::first();
      return view('admin.dashboard.dashboard',[
          'obj_setting'=>$obj_settings,
      ]);

    }
}
