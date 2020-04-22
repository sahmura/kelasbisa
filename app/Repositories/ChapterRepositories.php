<?php

namespace App\Repositories;

use App\Chapters;

class ChapterRepository
{

    /**
     * Get Where data
     * 
     * @param $column column
     * @param $sign   sign
     * @param $value  value
     * 
     * @return Chapters
     */
    public function getWhere($column, $sign, $value)
    {
        return Chapters::where($column, $sign, $value);
    }

    /**
     * Membuat file baru
     * 
     * @param $request menerima data
     * 
     * @return Chapters
     */
    public function createNewChapter($request)
    {
        return Chapters::create(
            [
                'class_id' => $request->class_id,
                'title' => $request->title,
                'description' => $request->description,
                'video_url' => $request->video_url,
                'sub_chapter_id' => $request->sub_chapter_id
            ]
        );
    }

    /**
     * Sunting data
     * 
     * @param $request menerima data
     * 
     * @return Chapters
     */
    public function updateChapter($request)
    {
        return Chapters::find($request->id)->update(
            [
                'class_id' => $request->class_id,
                'title' => $request->title,
                'description' => $request->description,
                'video_url' => $request->video_url,
                'sub_chapter_id' => $request->sub_chapter_id
            ]
        );
    }

    /**
     * Menghapus data
     * 
     * @param $request menerima data
     * 
     * @return Chapters
     */
    public function deleteChapter($request)
    {
        return Chapters::find($request->id)->delete();
    }
}
