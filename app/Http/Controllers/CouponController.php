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
        if (Coupons::where('coupon', '=', $request->coupon)->count() == 0) {
            $create = Coupons::create(
                [
                    'class_id' => $request->class_id,
                    'coupon' => $request->coupon,
                    'discount' => $request->discount,
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
        } else {
            $response = [
                'status' => false,
                'message' => 'Kode promo sudah ada',
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
        if (Coupons::where('coupon', '=', $request->coupon)->whereNotIn('id', [$request->id])->count() == 0) {
            $update = Coupons::where('id', '=', $request->id)->update(
                [
                    'class_id' => $request->class_id,
                    'coupon' => $request->coupon,
                    'discount' => $request->discount,
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
        } else {
            $response = [
                'status' => false,
                'message' => 'Kode promo sudah ada',
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
                                    data-dics='" . $listData->dicsount . "'
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

    /**
     * Check Coupon
     * 
     * @param $request menerima data
     * 
     * @return mixed
     */
    public function checkCoupon(Request $request)
    {
        $dataClass = Classes::where('id', '=', $request->idclass)->where('deleted_at', '=', null)->first();
        $checkCoupon = Coupons::where('class_id', '=', $dataClass->id)->where('coupon', '=', $request->code);
        if ($checkCoupon->count() == 0) {
            $response = [
                'status' => false,
                'message' => 'Kode kupon tidak ditemukan',
                'notes' => ''
            ];
        } else {
            $response = [
                'status' => true,
                'message' => 'Kode kupon berhasil digunakan',
                'notes' => '',
                'newPrices' => 'Rp' . ($dataClass->prices - $checkCoupon->first()->discount)
            ];
        }

        return response()->json($response);
    }
}
