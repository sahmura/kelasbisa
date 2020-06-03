<?php

namespace App\Repositories;

use App\Classes;

class ClassRepository
{

    /**
     * Get Where data
     * 
     * @param $column column
     * @param $sign   sign
     * @param $value  value
     * 
     * @return Classes
     */
    public function getWhere($column, $sign, $value)
    {
        return Classes::where($column, $sign, $value);
    }

    /**
     * Membuat file baru
     * 
     * @param $request menerima data
     * 
     * @return Classes
     */
    public function createNewClass($request)
    {
        return Classes::create(
            [
                'category_id' => $request->category_id,
                'name' => $request->name,
                'speaker_id' => $request->speakers,
                'description' => $request->description,
                'cover' => $request->cover_name,
                'terms' => $request->terms,
                'type' => $request->type,
                'prices' => $request->prices,
                'modul_url' => $request->modul_url,
                'is_draft' => $request->is_draft,
                'group_discussion' => $request->group_url,
            ]
        );
    }

    /**
     * Sunting data
     * 
     * @param $request menerima data
     * 
     * @return Classes
     */
    public function updateClass($request)
    {
        return Classes::find($request->id)->update(
            [
                'category_id' => $request->category_id,
                'name' => $request->name,
                'speaker_id' => $request->speakers,
                'description' => $request->description,
                'cover' => $request->cover_name,
                'terms' => $request->terms,
                'type' => $request->type,
                'prices' => $request->prices,
                'modul_url' => $request->modul_url,
                'is_draft' => $request->is_draft,
                'group_discussion' => $request->group_url,
            ]
        );
    }

    /**
     * Menghapus data
     * 
     * @param $request menerima data
     * 
     * @return Classes
     */
    public function deleteClass($request)
    {
        return Classes::find($request->id)->delete();
    }
}
