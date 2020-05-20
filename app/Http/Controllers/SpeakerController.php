<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Speakers;
use App\Classes;
use Yajra\DataTables\DataTables;
use DB;
use File;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class SpeakerController extends Controller
{
    /**
     * Halaman index dan edit speaker
     * 
     * @return view
     */
    public function index()
    {
        return view('pages.admin.speaker.speaker_view');
    }

    /**
     * Halaman add speaker
     * 
     * @param $request menerima data
     * 
     * @return json
     */
    public function addSpeaker(Request $request)
    {
        try {
            DB::beginTransaction();

            Speakers::create(
                [
                    'name' => $request->name,
                    'skill' => $request->skill,
                    'signature' => '',
                    'profil_pic' => '',
                ]
            );

            DB::commit();
            $response = [
                'status' => true,
                'message' => 'Data berhasil ditambahkan'
            ];
        } catch (\Exception $e) {
            DB::rollback();
            $response = [
                'status' => false,
                'message' => 'Data gagal ditambahkan'
            ];
        }

        return response()->json($response);
    }

    /**
     * Upload signature
     * 
     * @param $request menerima data
     * 
     * @return json
     */
    public function addSignature(Request $request)
    {
        $speaker = Speakers::where('id', '=', $request->id)->first();
        $signature = $request->file('signature');
        $extension = ['jpg', 'png', 'jpeg'];
        if (!in_array($signature->getClientOriginalExtension(), $extension)) {
            $response = [
                'status' => false,
                'message' => 'Format yang diperbolehkan jpg, png, jpeg',
                'notes' => ''
            ];
            return redirect('admin/speaker')->with('error', $response['message']);
        } else if ($signature->getSize() >= 500048) {
            $response = [
                'status' => false,
                'message' => 'Maaf, ukuran maksimal gambar 500KB',
                'notes' => ''
            ];
            return redirect('admin/speaker')->with('error', $response['message']);
        } else {
            if ($speaker->signature != '') {
                File::delete('assets/signature/' . $speaker->signature);
            }

            $signatureName = md5($speaker->id . $request->name) . '.' . $signature->getClientOriginalExtension();
            $signature->move('assets/signature', $signatureName);
            Speakers::where('id', '=', $speaker->id)->where('name', '=', $request->name)->update(
                [
                    'signature' => $signatureName
                ]
            );
            $response = [
                'status' => true,
                'message' => 'Signature berhasil ditambahkan',
                'notes' => ''
            ];
            return redirect('admin/speaker')->with('success', $response['message']);
        }
    }

    /**
     * Update speaker
     * 
     * @param $request menerima data
     * 
     * @return json
     */
    public function updateSpeaker(Request $request)
    {
        try {
            DB::beginTransaction();
            $speaker = Speakers::where('id', '=', $request->id)->first();
            Speakers::where('id', '=', $speaker->id)->update(
                [
                    'name' => $request->name,
                    'skill' => $request->skill,
                ]
            );

            DB::commit();
            $response = [
                'status' => true,
                'message' => 'Data berhasil diedit'
            ];
        } catch (\Exception $e) {
            DB::rollback();
            $response = [
                'status' => false,
                'message' => 'Data gagal diedit'
            ];
        }

        return response()->json($response);
    }

    /**
     * Get list data speaker
     * 
     * @param $request menerima request
     * 
     * @return json
     */
    public function getListSpeaker(Request $request)
    {
        if ($request->json()) {
            $listSpeaker = Speakers::where('deleted_at', '=', null)->get();
            return DataTables::of($listSpeaker)
                ->addColumn(
                    'action',
                    function ($listSpeaker) {
                        return '<div class="btn-group">
                                    <button class="btn btn-sm btn-edit btn-success"
                                        data-id="' . $listSpeaker->id . '"
                                        data-name="' . $listSpeaker->name . '"
                                        data-skill="' . $listSpeaker->skill . '"
                                        data-signature="' . $listSpeaker->signature . '"
                                    ><i class="fas fa-pencil-alt"></i></button>
                                    <button class="btn btn-sm btn-signature btn-primary"
                                        data-id="' . $listSpeaker->id . '"
                                        data-signature="' . $listSpeaker->signature . '"
                                        data-name="' . $listSpeaker->name . '"
                                    ><i class="fas fa-signature"></i></button>
                                </div>';
                    }
                )
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
    }
}
