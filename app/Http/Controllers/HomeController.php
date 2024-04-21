<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Util;

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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();
       
        if ( $user->level == 0 || $user->level== 1 ){
            return view('admin.admin_home');
        }
        return redirect('/bai-kiem-tra');
        //return redirect('/');
       // return view('frontend.frontend_home');
        //return view('frontend.frontend_master');
    }
}
