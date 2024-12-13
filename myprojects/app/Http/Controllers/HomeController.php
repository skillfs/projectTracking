<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Software;

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
        $software = Software::all(); // Fetch all software requests
        return view('home', compact('software'));
    }
}
