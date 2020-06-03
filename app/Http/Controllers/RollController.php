<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes;
use App\Chapters;
use App\SubChapters;
use App\LogRoll;
use App\DoneChapter;

class RollController extends Controller
{
    /**
     * Halaman index roll class
     * 
     * @param $classid menerima data kelas
     * @param $chid    menerima data chapter
     * 
     * @return view
     */
    public function index($classid, $chid = 0)
    {
        LogRoll::updateOrCreate(
            [
                'user_id' => Auth()->user()->id,
                'class_id' => $classid,
            ],
            [
                'user_id' => Auth()->user()->id,
                'class_id' => $classid,
                'updated_at' => now(),
                'chapter_id' => $chid
            ]
        );
        $class = Classes::where('id', '=', $classid)->first();
        $listChapters = Chapters::where('class_id', '=', $classid)->get();
        $listSubChapters = SubChapters::where('class_id', '=', $classid)->get();
        $getListChapterDone = DoneChapter::where('user_id', '=', Auth()->user()->id)->where('class_id', '=', $classid)->get()->pluck('chapter_id')->toArray();
        if ($chid == null) {
            $initialState = true;
            $rollChapter = null;
        } else {
            $initialState = false;
            $rollChapter = Chapters::where('id', '=', $chid)->where('class_id', '=', $classid)->first();
        }
        return view('pages.user.roll.roll_class', compact('class', 'listChapters', 'listSubChapters', 'initialState', 'rollChapter', 'chid', 'getListChapterDone'));
    }

    /**
     * FUngsi untuk done chapter
     * 
     * @param $request menerima data
     * 
     * @return json
     */
    public function checkChapterDone(Request $request)
    {
        $done = DoneChapter::updateOrCreate(
            ['user_id' => Auth()->user()->id, 'class_id' => $request->class_id, 'chapter_id' => $request->chapter_id],
            ['user_id', '=', Auth()->user()->id, 'class_id', '=', $request->class_id, 'chapter_id', '=', $request->chapter_id],
        );

        if ($done) {
            $response = [
                'status' => true,
                'message' => 'Chapter berhasil diselesaikan',
                'notes' => 'Silahkan lanjutkan belajar'
            ];
        } else {
            $response = [
                'status' => false,
                'message' => 'Chapter gagal diselesaikan',
                'notes' => 'Lanjutkan beberapa saat lagi'
            ];
        }

        return response()->json($response);
    }

    /**
     * FUngsi untuk undone chapter
     * 
     * @param $request menerima data
     * 
     * @return json
     */
    public function uncheckChapterDone(Request $request)
    {
        $done = DoneChapter::where('user_id', '=', Auth()->user()->id)->where('class_id', '=', $request->class_id)->where('chapter_id', '=', $request->chapter_id)->delete();

        if ($done) {
            $response = [
                'status' => true,
                'message' => 'Chapter berhasil di-uncheck',
                'notes' => 'Silahkan lanjutkan belajar'
            ];
        } else {
            $response = [
                'status' => false,
                'message' => 'Chapter gagal di-uncheck',
                'notes' => 'Lanjutkan beberapa saat lagi'
            ];
        }

        return response()->json($response);
    }
}
