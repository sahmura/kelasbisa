<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categories;
use Yajra\DataTables\DataTables;
use App\Repositories\CategoryRepository;

class CategoryController extends Controller
{
    /**
     * Index kategori
     * 
     * @return view
     */
    public function index()
    {
        return view('pages.admin.category_view');
    }

    /**
     * Get list data 
     * 
     * @param $request menerima request
     * 
     * @return json
     */
    public function getListCategory(Request $request, CategoryRepository $categoryRepository)
    {
        if ($request->json()) {
            $listCategory = $categoryRepository->getWhere('deleted_at', '=', null)->get();
            return DataTables::of($listCategory)
                ->addColumn(
                    'action',
                    function ($listCategory) {
                        return '<div class="btn-group">
                                    <button class="btn btn-sm btn-edit btn-warning"
                                        data-id="' . $listCategory->id . '"
                                        data-name="' . $listCategory->name . '"
                                        data-description="' . $listCategory->description . '"
                                    ><i class="fas fa-pencil-alt"></i></button>
                                    <button class="btn btn-sm btn-delete btn-danger"
                                        data-id="' . $listCategory->id . '"
                                    ><i class="fas fa-trash-alt"></i></button>
                                </div>';
                    }
                )
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
    }

    /**
     * Insert data to category
     * 
     * @param $request            menerima data
     * @param $categoryRepository mengirim data untuk diolah
     * 
     * @return json
     */
    public function addCategory(Request $request, CategoryRepository $categoryRepository)
    {
        if ($categoryRepository->getWhere('name', '=', $request->name)->count() != 0) {
            $response = [
                'status' => false,
                'message' => 'Gagal menambahkan data',
                'notes' => 'Kategori sudah ada'
            ];
        } else {
            $createData = $categoryRepository->createNewCategory($request);
            if ($createData) {
                $response = [
                    'status' => true,
                    'message' => 'Berhasil menambahkan data',
                    'notes' => ''
                ];
            } else {
                $response = [
                    'status' => false,
                    'message' => 'Gagal menambahkan data',
                    'notes' => ''
                ];
            }
        }
        return response()->json($response);
    }

    /**
     * Update category
     * 
     * @param $request            menerima data
     * @param $categoryRepository mengirim data untuk diolah
     * 
     * @return json
     */
    public function updateCategory(Request $request, CategoryRepository $categoryRepository)
    {
        if (Categories::where('name', '=', $request->name)->whereNotIn('id', [$request->id])->count() != 0) {
            $response = [
                'status' => false,
                'message' => 'Gagal menyunting data',
                'notes' => 'Kategori sudah ada'
            ];
        } else {
            $createData = $categoryRepository->updateCategory($request);
            if ($createData) {
                $response = [
                    'status' => true,
                    'message' => 'Berhasil menyunting data',
                    'notes' => ''
                ];
            } else {
                $response = [
                    'status' => false,
                    'message' => 'Gagal menyunting data',
                    'notes' => ''
                ];
            }
        }
        return response()->json($response);
    }

    /**
     * Hapus category
     * 
     * @param $request            menerima data
     * @param $categoryRepository mengirim data untuk diolah
     * 
     * @return json
     */
    public function deleteCategory(Request $request, CategoryRepository $categoryRepository)
    {
        if ($categoryRepository->deleteCategory($request)) {
            $response = [
                'status' => true,
                'message' => 'Berhasil menghapus data',
                'notes' => ''
            ];
        } else {
            $response = [
                'status' => false,
                'message' => 'Gagal menghapus data',
                'notes' => ''
            ];
        }

        return response()->json($response);
    }
}
