<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Classes;

class DashboardController extends Controller
{
    /**
     * Halaman index user
     * 
     * @return \view
     */
    public function indexuser()
    {
        return view('pages.user.user_dashboard');
    }
}
