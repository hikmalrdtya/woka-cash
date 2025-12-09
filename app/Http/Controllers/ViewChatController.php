<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ViewChatController extends Controller
{
    public function view() {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return view('admin.ai.index');
        }
    }
}
