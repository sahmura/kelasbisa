<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Classes;
use App\Categories;
use App\Chapters;
use App\LogClasses;
use App\SubChapters;
use App\Transactions;
use App\Repositories\SubChapterRepository;
use App\Repositories\ChapterRepository;
use App\Repositories\ClassRepository;
use File;
use DB;
use Auth;
use App\User;

class ClassController extends Controller
{
    /**
     * Menampilkan index
     * 
     * @return view
     */
    public function index()
    {
        return view('pages.admin.classes_view');
    }

    /**
     * Menampilkan halaman pembuatan kelas
     * 
     * @return view
     */
    public function newClass()
    {
        $listCategories = Categories::where('deleted_at', '=', null)->orderBy('name', 'asc')->get();
        return view('pages.admin.class.addClass', compact('listCategories'));
    }

    /**
     * Get list kelas
     * 
     * @param $request         menerima data
     * @param $classRepository mengolah data
     * 
     * @return Datatable
     */
    public function getListClass(Request $request)
    {
        if ($request->json()) {
            $listClass = Classes::where('deleted_at', '=', null)->with('category')->get();
            return DataTables::of($listClass)
                ->addColumn(
                    'type_class',
                    function ($listClass) {
                        return ucfirst($listClass->type);
                    }
                )
                ->addColumn(
                    'action',
                    function ($listClass) {
                        return '<div class="btn-group">
                                    <a class="btn btn-sm btn-primary text-white" href="' . url('admin/class/' . $listClass->id . '/detail') . '"><i class="fas fa-search"></i></a>
                                    <button class="btn btn-sm btn-edit btn-warning"
                                        data-id="' . $listClass->id . '"
                                    ><i class="fas fa-pencil-alt"></i></button>
                                    <button class="btn btn-sm btn-delete btn-danger"
                                        data-id="' . $listClass->id . '"
                                    ><i class="fas fa-trash-alt"></i></button>
                                </div>';
                    }
                )
                ->rawColumns(['action', 'type_class'])
                ->addIndexColumn()
                ->make(true);
        }
    }

    /**
     * Menambahkan kelas
     * 
     * @param $request menerima data
     * 
     * @return mixed
     */
    public function addClass(Request $request, ClassRepository $classRepository)
    {
        $uploadPath = 'cover';
        $cover = $request->file('cover');
        $cover_name = md5($cover->getClientOriginalName() . $request->name) . '.' . $cover->getClientOriginalExtension();
        $request->cover_name = $cover_name;
        try {
            $uploadCover = $cover->move($uploadPath, $cover_name);
            if ($uploadCover) {
                $classRepository->createNewClass($request);
                $response = [
                    'status' => true,
                    'message' => 'Kelas baru berhasil ditambahkan',
                    'notes' => ''
                ];
            } else {
                $response = [
                    'status' => false,
                    'message' => 'Kelas baru gagal ditambahkan',
                    'notes' => ''
                ];
            }
        } catch (\Exception $e) {
            throw $e;
            $response = [
                'status' => false,
                'message' => 'Kelas baru gagal ditambahkan',
                'notes' => ''
            ];
        }

        if ($response['status']) {
            return redirect('admin/class')->with('success', $response['message']);
        } else {
            return redirect('admin/class')->with('error', $response['message']);
        }
    }

    /**
     * Detail Class
     * 
     * @param $id              id kelas
     * @param $subchapterclass mengelola data
     * 
     * @return view
     */
    public function detailClass($id, SubChapterRepository $subChapterRepository, ChapterRepository $chapterRepository)
    {
        $data = Classes::where('id', '=', $id)->with('category')->with('chapters')->first();
        $listSubChapters = $subChapterRepository->getWhere('class_id', '=', $id)->get();
        $listChapters = $chapterRepository->getWhere('class_id', '=', $id)->get();
        return view('pages.admin.class.class_detail', compact('data', 'listSubChapters', 'listChapters'));
    }


    /**
     * Edit kelas
     * 
     * @param $id              menerima id kelas
     * @param $classRepository mengolah data
     * 
     * @return mixed
     */
    public function editClass($id, ClassRepository $classRepository)
    {
        $class = $classRepository->getWhere('id', '=', $id)->first();
        $listCategories = Categories::where('deleted_at', '=', null)->orderBy('name', 'asc')->get();
        return view('pages.admin.class.editClass', compact('class', 'listCategories'));
    }

    /**
     * Update Class
     * 
     * @param $request         menerima request
     * @param $classRepository mengolah data
     * 
     * @return mixed
     */
    public function updateClass(Request $request, ClassRepository $classRepository)
    {
        $classData = $classRepository->getWhere('id', '=', $request->id)->first();
        if (empty($request->file('cover'))) {
            $request->cover_name = $classData->cover;
        } else {
            $cover = $request->file('cover');
            $deleteFile = File::delete('cover/' . $classData->cover);
            $request->cover_name = md5($cover->getClientOriginalName() . $request->name) . '.' . $cover->getClientOriginalExtension();
            $cover->move('cover', $request->cover_name);
        }
        $updateClass = $classRepository->updateClass($request);
        if ($updateClass) {
            $response = [
                'status' => true,
                'message' => 'Kelas berhasil disunting',
                'notes' => ''
            ];
        } else {
            $response = [
                'status' => false,
                'message' => 'Kelas gagal disunting',
                'notes' => ''
            ];
        }
        if ($response['status']) {
            return redirect('admin/class/' . $request->id . '/detail')->with('success', $response['message']);
        } else {
            return redirect('admin/class/' . $request->id . '/detail')->with('error', $response['message']);
        }
    }

    /**
     * Hapus class
     * 
     * @param $request         menerima request
     * @param $classRepository mengolah data
     * 
     * @return mixed
     */
    public function deleteClass(Request $request, ClassRepository $classRepository)
    {
        try {
            DB::beginTransaction();
            $class = Classes::find($request->id);
            File::delete('cover', $class->cover);
            $class->delete();
            SubChapters::where('class_id', '=', $request->id)->delete();
            Chapters::where('class_id', '=', $request->id)->delete();
            DB::commit();

            $response = [
                'status' => true,
                'message' => 'Kelas berhasil dihapus',
                'notes' => ''
            ];
        } catch (\Exception $e) {
            DB::rollback();
            $response = [
                'status' => false,
                'message' => 'Kelas gagal dihapus',
                'notes' => ''
            ];
            return response()->json($response);
            throw $e;
        }

        return response()->json($response);
    }

    /**
     * List all class in user mode
     * 
     * @param $category menerima data kategori
     * 
     * @return view
     */
    public function listClassUser($category = null)
    {
        $listCategories = Categories::where('deleted_at', '=', null)->get();

        if ($category != null) {
            $listClasses = Classes::where('deleted_at', '=', null)->where('category_id', '=', $category)->with('category')->orderBy('id', 'desc')->paginate(12);
        } else {
            $listClasses = Classes::where('deleted_at', '=', null)->with('category')->orderBy('id', 'desc')->paginate(12);
        }
        return view('pages.user.class.index_class', ['listClasses' => $listClasses, 'listCategories' => $listCategories, 'category_id' => $category]);
    }

    /**
     * List all class in user mode
     * 
     * @param $category menerima data kategori
     * 
     * @return view
     */
    public function listMyClassUser($category = null)
    {
        $listCategories = Categories::where('deleted_at', '=', null)->get();
        $ownClasses = LogClasses::where('user_id', '=', Auth()->user()->id)->where('deleted_at', '=', null)->get('class_id');
        if ($category != null) {
            $listClasses = Classes::whereIn('id', $ownClasses)->where('deleted_at', '=', null)->where('category_id', '=', $category)->with('category')->orderBy('id', 'desc')->paginate(12);
        } else {
            $listClasses = Classes::whereIn('id', $ownClasses)->where('deleted_at', '=', null)->with('category')->orderBy('id', 'desc')->paginate(12);
        }
        return view('pages.user.class.myclass', ['listClasses' => $listClasses, 'listCategories' => $listCategories, 'category_id' => $category]);
    }

    /**
     * Detail kelas
     * 
     * @param $id                   menerima id kelas
     * @param $chapterRepository    mengolah data chapter
     * @param $subChapterRepository mengolah data sub chapter
     * 
     * @return view
     */
    public function detailClassUser($id, ChapterRepository $chapterRepository, SubChapterRepository $subChapterRepository)
    {
        $data = Classes::where('id', '=', $id)->with('category')->with('chapters')->first();
        $listSubChapters = $subChapterRepository->getWhere('class_id', '=', $id)->get();
        $listChapters = $chapterRepository->getWhere('class_id', '=', $id)->get();
        return view('pages.user.class.class_detail', compact('data', 'listSubChapters', 'listChapters'));
    }

    /**
     * Join class
     * 
     * @param $request menerima request
     * 
     * @return json
     */
    public function joinClass(Request $request)
    {
        $dataClass = Classes::where('id', '=', $request->class_id)->where('deleted_at', '=', null)->first();
        $dataUser = User::where('id', '=', $request->user_id)->first();

        try {
            DB::beginTransaction();
            $newTransaction = Transactions::create(
                [
                    'user_id' => $dataUser->id,
                    'class_id' => $dataClass->id,
                    'transaction_code' => md5($dataClass->name . $dataUser->name),
                    'status' => $request->status,
                    'total_prices' => $dataClass->prices
                ]
            );
            $newLog = LogClasses::create(
                [
                    'transaction_id' => $newTransaction->id,
                    'user_id' => $dataUser->id,
                    'class_id' => $dataClass->id,
                    'transaction_code' => md5($dataClass->name . $dataUser->name),
                ]
            );
            DB::commit();
            $response = [
                'status' => true,
                'message' => 'Berhasil masuk kelas',
                'notes' => ''
            ];
        } catch (\Exception $e) {
            throw $e;
            DB::rollback();
            $response = [
                'status' => false,
                'message' => 'Gagal masuk kelas',
                'notes' => ''
            ];
        }

        return response()->json($response);
    }
}
