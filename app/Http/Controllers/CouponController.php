<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Coupons;
use App\Classes;
use Yajra\DataTables\DataTables;

class CouponController extends Controller
{
    /**
     * Halaman index
     * 
     * @return view
     */
    public function index()
    {
        $listClasses = Classes::where('deleted_at', '=', null)->get();
        return view('pages.admin.coupon.index_coupon', compact('listClasses'));
    }

    /**
     * Create coupon
     * 
     * @param $request menerima data
     * 
     * @return json
     */
    public function createCoupon(Request $request)
    {
        $create = Coupons::create(
            [
                'class_id' => $request->class_id,
                'coupon' => $request->coupon
            ]
        );

        if ($create) {
            $response = [
                'status' => true,
                'message' => 'Kode promo berhasil dibuat',
                'notes' => ''
            ];
        } else {
            $response = [
                'status' => false,
                'message' => 'Kode promo gagal dibuat',
                'notes' => ''
            ];
        }

        return response()->json($response);
    }

    /**
     * Update coupon
     * 
     * @param $request menerima data
     * 
     * @return json
     */
    public function updateCoupon(Request $request)
    {
        $update = Coupons::where('id', '=', $request->id)->update(
            [
                'class_id' => $request->class_id,
                'coupon' => $request->coupon
            ]
        );

        if ($update) {
            $response = [
                'status' => true,
                'message' => 'Kode promo berhasil disunting',
                'notes' => ''
            ];
        } else {
            $response = [
                'status' => false,
                'message' => 'Kode promo gagal disunting',
                'notes' => ''
            ];
        }

        return response()->json($response);
    }

    /**
     * Delete coupon
     * 
     * @param $request menerima data
     * 
     * @return json
     */
    public function deleteCoupon(Request $request)
    {
        $delete = Coupons::where('id', '=', $request->id)->delete();

        if ($delete) {
            $response = [
                'status' => true,
                'message' => 'Kode promo berhasil disunting',
                'notes' => ''
            ];
        } else {
            $response = [
                'status' => false,
                'message' => 'Kode promo gagal disunting',
                'notes' => ''
            ];
        }

        return response()->json($response);
    }

    public function getListCoupon(Request $request)
    {
        if ($request->ajax()) {
            $listData = Coupons::with('class')->get();
            return DataTables::of($listData)
                ->addColumn(
                    'action',
                    function ($listData) {
                        return "<div class='btn-group'>
                                    <button class='btn btn-sm btn-warning btn-edit'
                                    data-id='" . $listData->id . "'
                                    data-classid='" . $listData->class_id . "'
                                    data-coupon='" . $listData->coupon . "'
                                    ><i class='fas fa-pencil-alt'></i></button>
                                    <button class='btn btn-sm btn-danger btn-delete' data-id='" . $listData->id . "'><i class='fas fa-trash-alt'></i></button>
                                </div>";
                    }
                )
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
    }
}
