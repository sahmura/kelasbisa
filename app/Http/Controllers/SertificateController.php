<?php

namespace App\Http\Controllers;

use App\DoneChapter;
use Illuminate\Http\Request;
use Spipu\Html2Pdf\Html2Pdf;
use App\LogClasses;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;

class SertificateController extends Controller
{
    /**
     * Fungsi untuk mendownload sertifikat
     * 
     * @param $request menerima data
     * 
     * @return mixed
     */
    public function download(Request $request)
    {
        $data['data'] = LogClasses::where('deleted_at', '=', null)->where('user_id', '=', Auth()->user()->id)->where('class_id', '=', $request->class_id)->with(['user', 'class'])->first();

        if (!$data['data'] || $data['data'] == null) {
            $response = [
                'status' => false,
                'message' => 'Data tidak ditemukan',
                'notes' => 'Kamu tidak mengambil kelas ini'
            ];

            return response()->json($response);
        }

        $filename = 'Sertifikat ' . $data['data']->user->name . ' Kelas ' . $data['data']->class->name . '.pdf';
        $template = $request->template;

        $data['data']->nomor = $data['data']->user_id . '/' . $data['data']->class_id . '/' . Carbon::parse($data['data']->created_at)->format('dmY');
        $data['data']->date = Carbon::parse($data['data']->created_at)->locale('id')->isoFormat('Do MMMM YYYY');

        $this->exportPdf(
            $data,
            $filename,
            $template
        );
    }

    /**
     * Proses pdf
     * 
     * @param $dataSertificate menerima data dari sertificate
     * @param $filename        nama sertifikat
     * @param $template        menerima data template
     * 
     * @return pdf
     */
    public function exportPdf($dataSertificate, $filename, $template)
    {
        $content = view('pages.sertificate.' . $template, $dataSertificate)->render();
        $pdf     = new Html2Pdf('L', 'A4', 'en');
        ob_end_clean();
        $pdf->addFont('helvetica', 'BI', '');
        $pdf->writeHTML($content);
        $pdf->output($filename, 'D');
    }

    /**
     * Halaman untuk cetak sertifikat
     * 
     * @return view
     */
    public function printSertificatePage()
    {
        return view('pages.user.sertificate.sertificate_page');
    }

    /**
     * List sertifikat
     * 
     * @return datatable
     */
    public function getListData()
    {
        $classDone = [];
        $classDonePremium = [];
        $classDoneIteration = 0;
        $myclass = LogClasses::where('user_id', '=', Auth()->user()->id)->with('class')->get();
        foreach ($myclass as $class) {
            $classDone[] = ['class_id' => $class->class_id, 'class_name' => $class->class->name, 'total_chapter' => $class->total_chapter, 'total_chapter_done' => DoneChapter::where('user_id', '=', Auth()->user()->id)->where('class_id', '=', $class->class_id)->count('chapter_id'), 'status' => '', 'type' => $class->class->type];
        }

        for ($classDoneIteration = 0; $classDoneIteration < count($classDone); $classDoneIteration++) {
            if ($classDone[$classDoneIteration]['total_chapter_done'] >= ($classDone[$classDoneIteration]['total_chapter'] * 1)) {
                $classDone[$classDoneIteration]['status'] = 'Sudah selesai';
            } else {
                $classDone[$classDoneIteration]['status'] = 'Belum selesai';
            }
        }

        for ($unsetDataIteration = 0; $unsetDataIteration < count($classDone); $unsetDataIteration++) {
            if ($classDone[$unsetDataIteration]['type'] == 'premium') {
                $classDonePremium[$unsetDataIteration] = $classDone[$unsetDataIteration];
            }
        }

        return DataTables::of($classDonePremium)
            ->addColumn(
                'action',
                function ($classDonePremium) {
                    if ($classDonePremium['status'] == 'Sudah selesai') {
                        return '<button class="btn btn-primary btn-sm downloadSertificate" data-classid="' . $classDonePremium['class_id'] . '">Cetak</button>';
                    } else {
                        return '<button class="btn btn-danger btn-sm disabled">Cetak</button>';
                    }
                }
            )
            ->addIndexColumn()
            ->make(true);
    }
}
