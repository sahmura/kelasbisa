<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Classes;
use App\LogRoll;
use App\LogClasses;

class DashboardController extends Controller
{
    /**
     * Halaman index user
     * 
     * @return \view
     */
    public function indexuser()
    {
        $lastClass = LogRoll::where('user_id', '=', Auth()->user()->id)->with('class')->orderBy('updated_at', 'desc')->first();
        $totalClass = LogClasses::where('user_id', '=', Auth()->user()->id)->count();
        return view('pages.user.user_dashboard', compact('lastClass', 'totalClass'));
    }
}
