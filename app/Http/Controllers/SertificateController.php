<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spipu\Html2Pdf\Html2Pdf;
use App\LogClasses;
use Carbon\Carbon;

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

        $filename = 'Sertificate ' . $data['data']->user->name . ' Kelas ' . $data['data']->class->name . '.pdf';
        $template = $request->template;

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
}
