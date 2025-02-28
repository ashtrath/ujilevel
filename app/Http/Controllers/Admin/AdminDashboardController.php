<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminDashboardController extends Controller
{
    /**
     * Tampilkan dashboard admin.
     */
    public function index()
    {
        return view('admin.dashboard');
    }
}
