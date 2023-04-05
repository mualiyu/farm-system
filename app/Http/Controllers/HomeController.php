<?php

namespace App\Http\Controllers;

use App\Models\SensorDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

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
        Artisan::call("inspire");
        $s_details = SensorDetail::where('org_id', '=', Auth::user()->org_id)->orderBy('created_at', 'desc')->get();
        return view('main.dashboard', compact('s_details'));
    }


    public function profile()
    {
        return view('main.account.index');
    }
}
