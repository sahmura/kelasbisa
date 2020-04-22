<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\SubChapterRepository;
use App\SubChapters;

class SubChapterController extends Controller
{
    /**
     * Delete sub chapter
     * 
     * @param $request              menerima request
     * @param $subchapterRepository mengolah data
     * 
     * @return mixed
     */
    public function deleteSubChapter(Request $request, SubChapterRepository $subchapterRepository)
    {
        $deleteSubChapter = $subchapterRepository->deleteSubChapter($request);
        if ($deleteSubChapter) {
            Chapters::where('sub_chapter_id', '=', $request->id)->delete();
            $response = [
                'status' => true,
                'message' => 'Sub chapter berhasil dihapus',
                'notes' => ''
            ];
        } else {
            $response = [
                'status' => false,
                'message' => 'Sub chapter gagal dihapus',
                'notes' => ''
            ];
        }
        return response()->json($response);
    }

    /**
     * Add sub chapter
     * 
     * @param $request              menerima request
     * @param $subchapterRepository mengolah data
     * 
     * @return mixed
     */
    public function addSubChapter(Request $request, SubChapterRepository $subchapterRepository)
    {
        if (SubChapters::where('class_id', '=', $request->class_id)->where('name', '=', $request->name)->count() == 0) {
            $createSubChapter = $subchapterRepository->createNewSubChapter($request);
            if ($createSubChapter) {
                $response = [
                    'status' => true,
                    'message' => 'Sub chapter berhasil ditambahkan',
                    'notes' => ''
                ];
            } else {
                $response = [
                    'status' => false,
                    'message' => 'Sub chapter gagal ditambahkan',
                    'notes' => ''
                ];
            }
        } else {
            $response = [
                'status' => false,
                'message' => 'Sub chapter sudah ada',
                'notes' => ''
            ];
        }
        return response()->json($response);
    }

    /**
     * Edit sub chapter
     * 
     * @param $request              menerima request
     * @param $subchapterRepository mengolah data
     * 
     * @return mixed
     */
    public function editSubChapter(Request $request, SubChapterRepository $subchapterRepository)
    {
        if (SubChapters::where('class_id', '=', $request->class_id)->where('name', '=', $request->name)->whereNotIn('id', [$request->id])->count() == 0) {
            $updateSubChapter = $subchapterRepository->updateSubChapter($request);
            if ($updateSubChapter) {
                $response = [
                    'status' => true,
                    'message' => 'Sub chapter berhasil disunting',
                    'notes' => ''
                ];
            } else {
                $response = [
                    'status' => false,
                    'message' => 'Sub chapter gagal disunting',
                    'notes' => ''
                ];
            }
        } else {
            $response = [
                'status' => false,
                'message' => 'Sub chapter sudah ada',
                'notes' => ''
            ];
        }
        return response()->json($response);
    }
}
