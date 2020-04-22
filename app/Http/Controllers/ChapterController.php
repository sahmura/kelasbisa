<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ChapterRepository;
use App\Chapters;

class ChapterController extends Controller
{
    /**
     * Add chapter
     * 
     * @param $request           menerima request
     * @param $chapterRepository mengolah data
     * 
     * @return mixed
     */
    public function addChapter(Request $request, ChapterRepository $chapterRepository)
    {
        $createChapter = $chapterRepository->createNewChapter($request);
        if ($createChapter) {
            $response = [
                'status' => true,
                'message' => 'Chapter berhasil ditambahkan',
                'notes' => ''
            ];
        } else {
            $response = [
                'status' => false,
                'message' => 'Chapter gagal ditambahkan',
                'notes' => ''
            ];
        }
        return response()->json($response);
    }

    /**
     * Edit chapter
     * 
     * @param $request           menerima request
     * @param $chapterRepository mengolah data
     * 
     * @return mixed
     */
    public function editChapter(Request $request, ChapterRepository $chapterRepository)
    {
        $editChapter = $chapterRepository->updateChapter($request);
        if ($editChapter) {
            $response = [
                'status' => true,
                'message' => 'Chapter berhasil disunting',
                'notes' => ''
            ];
        } else {
            $response = [
                'status' => false,
                'message' => 'Chapter gagal disunting',
                'notes' => ''
            ];
        }
        return response()->json($response);
    }

    /**
     * Delete chapter
     * 
     * @param $request           menerima request
     * @param $chapterRepository mengolah data
     * 
     * @return mixed
     */
    public function deleteChapter(Request $request, ChapterRepository $chapterRepository)
    {
        $deleteChapter = $chapterRepository->deleteChapter($request);
        if ($deleteChapter) {
            $response = [
                'status' => true,
                'message' => 'Chapter berhasil dihapus',
                'notes' => ''
            ];
        } else {
            $response = [
                'status' => false,
                'message' => 'Chapter gagal dihapus',
                'notes' => ''
            ];
        }
        return response()->json($response);
    }
}
