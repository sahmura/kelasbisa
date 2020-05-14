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
        $data['newUsers'] = $users->orderBy('id', 'desc')->limit(5)->get();
        $data['newTransactions'] = $transactions->with('user')->with('class')->orderBy('id', 'desc')->limit(5)->get();
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
            $listUser = User::orderBy('created_at', 'desc')->get();
            return DataTables::of($listUser)
                ->addColumn(
                    'status',
                    function ($listUser) {
                        if ($listUser->email_verified_at == '' || $listUser->email_verified_at == null) {
                            return 'Not Verified';
                        } else {
                            return 'Verified';
                        }
                    }
                )
                ->addColumn(
                    'action',
                    function ($listUser) {
                        return '<div class="btn-group">
                                    <button class="btn btn-sm btn-asign btn-success"
                                        data-id="' . $listUser->id . '"
                                        data-name="' . $listUser->name . '"
                                    ><i class="ni ni-bold-right"></i></button>
                                    <button class="btn btn-sm btn-change-permission btn-danger"
                                        data-id="' . $listUser->id . '"
                                    ><i class="ni ni-badge"></i></button>
                                </div>';
                    }
                )
                ->rawColumns(['action', 'status'])
                ->addIndexColumn()
                ->make(true);
        }
    }

    /**
     * Make admin or peserta
     * 
     * @param $request menerima data
     * 
     * @return mixed
     */
    public function changePermission(Request $request)
    {
        $user = User::where('id', '=', $request->id)->first();
        if ($user->role == 'admin') {
            $changeTo = 'user';
        } else if ($user->role == 'user') {
            $changeTo = 'admin';
        }
        $update = User::where('id', '=', $request->id)->update(
            [
                'role' => $changeTo
            ]
        );

        if ($update) {
            $response = [
                'status' => true,
                'message' => 'Berhasil mengubah permission ke ' . $changeTo
            ];
        } else {
            $response = [
                'status' => false,
                'message' => 'Gagal mengubah permission ke ' . $changeTo
            ];
        }

        return response()->json($response);
    }
}
