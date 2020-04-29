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
use App\Coupons;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmTransaction;
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
        $totalChapters = $chapterRepository->getWhere('class_id', '=', $id)->count();
        return view('pages.admin.class.class_detail', compact('data', 'listSubChapters', 'listChapters', 'totalChapters'));
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
     * @param $type     menerima data kategori
     * 
     * @return view
     */
    public function listClassUser($category = null, $type = null)
    {
        $listCategories = Categories::where('deleted_at', '=', null)->get();
        if ($category == 'search') {
            $listClasses = Classes::where('name', 'like', '%' . $type . '%')->where('deleted_at', '=', null)->orderBy('id', 'desc')->paginate(12);
        } else if ($category == null || $type == null) {
            $listClasses = Classes::where('deleted_at', '=', null)->orderBy('id', 'desc')->paginate(12);
        } else {
            if ($category == 'all' && $type != null) {
                $listClasses = Classes::where('type', '=', $type)->where('deleted_at', '=', null)->orderBy('id', 'desc')->paginate(12);
            } else if ($type == 'all' && $category != null) {
                $listClasses = Classes::where('category_id', '=', $category)->where('deleted_at', '=', null)->orderBy('id', 'desc')->paginate(12);
            } else if ($category == 'all' && $type == 'all') {
                $listClasses = Classes::where('deleted_at', '=', null)->orderBy('id', 'desc')->paginate(12);
            } else {
                $listClasses = Classes::where('category_id', '=', $category)->where('type', '=', $type)->where('deleted_at', '=', null)->orderBy('id', 'desc')->paginate(12);
            }
        }

        return view('pages.user.class.index_class', ['listClasses' => $listClasses, 'listCategories' => $listCategories, 'category_id' => $category, 'type' => $type]);
    }

    /**
     * List all class in user mode
     * 
     * @return view
     */
    public function listMyClassUser()
    {
        $listClasses = LogClasses::where('user_id', '=', Auth()->user()->id)->where('deleted_at', '=', null)->with('class.category')->orderBy('created_at', 'desc')->paginate(12);
        return view('pages.user.class.myclass', ['listClasses' => $listClasses]);
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
        $totalChapters = $chapterRepository->getWhere('class_id', '=', $id)->count();
        $isOnList = LogClasses::where('class_id', '=', $id)->where('user_id', '=', Auth()->user()->id)->count();
        return view('pages.user.class.class_detail', compact('data', 'listSubChapters', 'listChapters', 'totalChapters', 'isOnList'));
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
                    'status' => 'Done',
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

    /**
     * Proses pembelian kelas
     * 
     * @param $request menerima data
     * 
     * @return mixed
     */
    public function buyClass(Request $request)
    {
        $dataClass = Classes::where('id', '=', $request->class_id)->where('deleted_at', '=', null)->first();
        $dataUser = User::where('id', '=', $request->user_id)->first();
        $code = Coupons::where('coupon', '=', $request->code)->where('class_id', '=', $dataClass->id);

        if ($request->code != '') {
            if ($dataClass->prices - $code->first()->discount == 0) {
                $this->joinClass($request);
                $response = [
                    'status' => true,
                    'message' => 'Berhasil masuk kelas',
                    'notes' => ''
                ];
            }
        } else {
            try {
                DB::beginTransaction();
                if ($code->count() == 0) {
                    $newTransaction = Transactions::create(
                        [
                            'user_id' => $dataUser->id,
                            'class_id' => $dataClass->id,
                            'transaction_code' => md5($dataClass->name . $dataUser->name),
                            'status' => 'pending',
                            'total_prices' => $dataClass->prices
                        ]
                    );
                } else {
                    $newTransaction = Transactions::create(
                        [
                            'user_id' => $dataUser->id,
                            'class_id' => $dataClass->id,
                            'transaction_code' => md5($dataClass->name . $dataUser->name),
                            'status' => 'pending',
                            'total_prices' => $dataClass->prices - $code->first()->discount
                        ]
                    );
                }


                DB::commit();

                $sendMail = Mail::to($dataUser->email)->send(
                    new ConfirmTransaction($dataUser, $dataClass, $newTransaction->total_prices)
                );

                $response = [
                    'status' => true,
                    'message' => 'Berhasil membeli kelas',
                    'notes' => 'Kelas masih pending, selesaikan pembayaran'
                ];
            } catch (\Exception $e) {
                throw $e;
                DB::rollback();
                $response = [
                    'status' => false,
                    'message' => 'Gagal membeli kelas',
                    'notes' => ''
                ];
            }
        }

        return response()->json($response);
    }
}
