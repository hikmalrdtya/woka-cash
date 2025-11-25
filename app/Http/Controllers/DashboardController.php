<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $user = Auth::user();
        if ($user->role === 'admin') {
            return view('admin.dashboard', compact('user'));
        } elseif ($user->role === 'staff') {
            return view('staff.dashboard');
        }
    }
}
