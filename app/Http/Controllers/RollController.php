<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes;
use App\Chapters;
use App\SubChapters;
use App\LogRoll;

class RollController extends Controller
{
    /**
     * Halaman index roll class
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
        if ($chid == null) {
            $initialState = true;
            $rollChapter = null;
        } else {
            $initialState = false;
            $rollChapter = Chapters::where('id', '=', $chid)->where('class_id', '=', $classid)->first();
        }
        return view('pages.user.roll.roll_class', compact('class', 'listChapters', 'listSubChapters', 'initialState', 'rollChapter', 'chid'));
    }
}
