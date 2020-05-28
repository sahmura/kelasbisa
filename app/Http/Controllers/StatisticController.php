<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Classes;
use App\Transactions;
use App\LogClasses;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;
use DB;

class StatisticController extends Controller
{
    /**
     * Halaman index statistik
     * 
     * @return view
     */
    public function index()
    {
        return view('pages.admin.statistic.statistic_index');
    }

    /**
     * Get data statistik
     * 
     * @param $request menerima data
     * 
     * @return datatable
     */
    public function getDataStatistic(Request $request)
    {
        $data = DB::select('SELECT a.class_id, count(a.user_id) as total, b.name as nama_kelas, b.type as tipe_kelas from log_classes a JOIN classes b ON a.class_id = b.id GROUP BY a.class_id, b.name, b.type');
        return DataTables::of($data)
            ->addColumn(
                'action',
                function ($data) {
                    return '<a href="' . url("admin/statistic/" . $data->class_id) . '" class="btn btn-sm btn-primary"><i class="fas fa-search"></i></a>';
                }
            )
            ->addColumn(
                'tipe_kelas',
                function ($data) {
                    return ucfirst($data->tipe_kelas);
                }
            )
            ->addIndexColumn()
            ->make(true);
    }

    /**
     * Get detail statistic class
     * 
     * @param $id id kelas
     * 
     * @return view
     */
    public function getDetailClass($id)
    {
        $thisMonth = Carbon::now()->month;
        $thisYear = Carbon::now()->year;

        $class = Classes::where('id', '=', $id)->with(['category', 'chapters', 'speaker'])->first();
        $totalTransactionPrices = Transactions::where('class_id', '=', $id)->sum('total_prices');
        $totalTransactionPricesThisMonth = Transactions::where('class_id', '=', $id)->whereMonth('created_at', '=', $thisMonth)->whereYear('created_at', '=', $thisYear)->sum('total_prices');

        return view('pages.admin.statistic.statistic_detail', compact('class', 'totalTransactionPrices', 'totalTransactionPricesThisMonth'));
    }

    /**
     * Get transaction
     * 
     * @param $request menerima data request
     * 
     * @return datatable
     */
    public function getTransactionHistory(Request $request)
    {
        if ($request->start_date && $request->end_date) {
            $data = Transactions::where('class_id', '=', $request->id)
                ->where(DB::raw('LEFT(`transactions`.`created_at`, 10)'), '>=', date('Y-m-d', strtotime($request->start_date)))
                ->where(DB::raw('LEFT(`transactions`.`created_at`, 10)'), '<=', date('Y-m-d', strtotime($request->end_date)))
                ->get();
        } else {
            $data = Transactions::where('class_id', '=', $request->id)->get();
        }
        return DataTables::of($data)
            ->addColumn(
                'date',
                function ($data) {
                    return Carbon::parse($data->created_at)->format('d-m-Y');
                }
            )
            ->addColumn(
                'status',
                function ($data) {
                    return ucfirst($data->status);
                }
            )
            ->addIndexColumn()
            ->make(true);
    }
}
