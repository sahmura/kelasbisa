<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categories;
use App\Chapters;
use App\Classes;
use App\LogClasses;
use App\Transactions;
use App\User;
use Yajra\DataTables\DataTables;
use DB;

class AdminController extends Controller
{
    /**
     * Index halaman admin
     * 
     * @return view
     */
    public function index()
    {
        $classes = Classes::where('deleted_at', '=', null);
        $users = User::where('role', '=', 'user');
        $transactions = Transactions::where('deleted_at', '=', null);

        $data['totalClasses'] = $classes->count();
        $data['totalUsers'] = $users->count();
        $data['totalTransactions'] = $transactions->count();
        $data['pendingTransaction'] = Transactions::where('deleted_at', '=', null)->where('status', '=', 'Pending')->count();
        $data['newUsers'] = $users->orderBy('id', 'desc')->limit(10)->get();
        $data['newTransactions'] = $transactions->with('user')->with('class')->orderBy('id', 'desc')->limit(10)->get();
        $data['bestClasses'] = $transactions->select(DB::raw('count(*) as total, class_id'))->with('class')->groupBy('class_id')->orderBy('total')->get();

        return view('pages.admin.admin_area', compact('data'));
    }

    /**
     * Halaman list user
     * 
     * @return view
     */
    public function listUser()
    {
        $classes = Classes::where('deleted_at', '=', null)->where('type', '=', 'premium')->get();
        return view('pages.admin.list_user', compact('classes'));
    }

    /**
     * Get list data 
     * 
     * @param $request menerima request
     * 
     * @return json
     */
    public function getListUser(Request $request)
    {
        if ($request->json()) {
            $listUser = User::where('role', '=', 'user')->get();
            return DataTables::of($listUser)
                ->addColumn(
                    'action',
                    function ($listUser) {
                        return '<div class="btn-group">
                                    <button class="btn btn-sm btn-asign btn-warning"
                                        data-id="' . $listUser->id . '"
                                        data-name="' . $listUser->name . '"
                                    ><i class="ni ni-bold-right"></i></button>
                                </div>';
                    }
                )
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
    }
}
