<?php

namespace App\Repositories;

use App\SubChapters;

class SubChapterRepository
{

    /**
     * Get Where data
     * 
     * @param $column column
     * @param $sign   sign
     * @param $value  value
     * 
     * @return SubChapters
     */
    public function getWhere($column, $sign, $value)
    {
        return SubChapters::where($column, $sign, $value);
    }

    /**
     * Membuat file baru
     * 
     * @param $request menerima data
     * 
     * @return SubChapters
     */
    public function createNewSubChapter($request)
    {
        return SubChapters::create(
            [
                'class_id' => $request->class_id,
                'name' => $request->name,
                'description' => $request->description,
            ]
        );
    }

    /**
     * Sunting data
     * 
     * @param $request menerima data
     * 
     * @return SubChapters
     */
    public function updateSubChapter($request)
    {
        return SubChapters::find($request->id)->update(
            [
                'class_id' => $request->class_id,
                'name' => $request->name,
                'description' => $request->description,
            ]
        );
    }

    /**
     * Menghapus data
     * 
     * @param $request menerima data
     * 
     * @return SubChapters
     */
    public function deleteSubChapter($request)
    {
        return SubChapters::find($request->id)->delete();
    }
}
