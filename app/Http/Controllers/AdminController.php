<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categories;
use App\Chapters;
use App\Classes;
use App\LogClasses;
use App\Transactions;

class AdminController extends Controller
{
    /**
     * Index halaman admin
     * 
     * @return view
     */
    public function index()
    {
        return view('pages.admin.admin_area');
    }
}
