<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserDashboardController extends Controller
{
    /**
     * Tampilkan dashboard User.
     */
    public function index()
    {
        return view('user.dashboard');
    }
}
