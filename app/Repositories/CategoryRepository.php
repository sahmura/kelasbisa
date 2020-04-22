<?php

namespace App\Repositories;

use App\Categories;

class CategoryRepository
{

    /**
     * Get Where data
     * 
     * @param $column column
     * @param $sign   sign
     * @param $value  value
     * 
     * @return Categories
     */
    public function getWhere($column, $sign, $value)
    {
        return Categories::where($column, $sign, $value);
    }

    /**
     * Membuat file baru
     * 
     * @param $request menerima data
     * 
     * @return Categories
     */
    public function createNewCategory($request)
    {
        return Categories::create(
            [
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
     * @return Categories
     */
    public function updateCategory($request)
    {
        return Categories::find($request->id)->update(
            [
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
     * @return Categories
     */
    public function deleteCategory($request)
    {
        return Categories::find($request->id)->delete();
    }
}
