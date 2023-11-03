<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){
        $user = Auth::user();
        $status = $user->subscribed('default');
        return view('dashboard.dashboard', compact('user','status'));
    }
}
