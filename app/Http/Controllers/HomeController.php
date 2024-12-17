<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Software;
use App\Models\User;
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
        $user = Auth::user();

        if ($user->role()->first() && $user->role()->first()->role_name === 'Admin') {
            // Admin logic
            $software = Software::all();
        } elseif ($user->role()->first() && $user->role()->first()->role_name === 'Department Head') {
            // Department Head logic
            $software = Software::where('department_id', $user->department)->get();
        } else {
            // Normal User logic
            $software = Software::where('f_name', $user->f_name)
                ->where('l_name', $user->l_name)
                ->get();
        }

        return view('home', compact('software'));
    }
}
