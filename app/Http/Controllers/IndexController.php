<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes;
use App\Categories;
use App\LogClasses;
use App\Repositories\SubChapterRepository;
use App\Repositories\ChapterRepository;

class IndexController extends Controller
{
    /**
     * List Class
     * 
     * @param $category menerima data kategori
     * @param $type     menerima data tipe
     * 
     * @return View
     */
    public function class($category = null, $type = null)
    {
        $categories = Categories::where('deleted_at', '=', null)->get();
        if ($category == 'search') {
            $classes = Classes::where('name', 'like', '%' . $type . '%')->where('is_draft', '=', 0)->where('deleted_at', '=', null)->orderBy('id', 'desc')->paginate(12);
        } else if ($category == null || $type == null) {
            $classes = Classes::where('deleted_at', '=', null)->where('is_draft', '=', 0)->orderBy('id', 'desc')->paginate(12);
        } else {
            if ($category == 'all' && $type != null) {
                $classes = Classes::where('type', '=', $type)->where('is_draft', '=', 0)->where('deleted_at', '=', null)->orderBy('id', 'desc')->paginate(12);
            } else if ($type == 'all' && $category != null) {
                $classes = Classes::where('category_id', '=', $category)->where('is_draft', '=', 0)->where('deleted_at', '=', null)->orderBy('id', 'desc')->paginate(12);
            } else if ($category == 'all' && $type == 'all') {
                $classes = Classes::where('deleted_at', '=', null)->where('is_draft', '=', 0)->orderBy('id', 'desc')->paginate(12);
            } else {
                $classes = Classes::where('category_id', '=', $category)->where('is_draft', '=', 0)->where('type', '=', $type)->where('deleted_at', '=', null)->orderBy('id', 'desc')->paginate(12);
            }
        }

        return view('pages.index.class', compact('classes', 'categories', 'category', 'type'));
    }

    /**
     * Detail kelas
     * 
     * @param $id                   id kelas
     * @param $subchapterRepository mengolah data subchapter
     * @param $chapterRepository    mengolah data chapter
     * 
     * @return View
     */
    public function detailClass($id, SubChapterRepository $subChapterRepository, ChapterRepository $chapterRepository)
    {
        $data = Classes::where('id', '=', $id)->where('is_draft', '=', 0)->where('deleted_at', '=', null)->first();
        $listSubChapters = $subChapterRepository->getWhere('class_id', '=', $id)->get();
        $listChapters = $chapterRepository->getWhere('class_id', '=', $id)->get();
        $totalChapters = $chapterRepository->getWhere('class_id', '=', $id)->count();
        if (Auth()->user()) {
            $isOnList = LogClasses::where('class_id', '=', $id)->where('user_id', '=', Auth()->user()->id)->count();
        } else {
            $isOnList = 0;
        }

        return view('pages.index.class_detail', compact('data', 'listSubChapters', 'listChapters', 'totalChapters', 'isOnList'));
    }

    /**
     * Halaman privasi policy
     * 
     * @return view
     */
    public function privacy()
    {
        return view('privacy');
    }

    /**
     * Halaman how to
     * 
     * @return view
     */
    public function howto()
    {
        return view('howto');
    }

    /**
     * Halaman about
     * 
     * @return view
     */
    public function about()
    {
        return view('about');
    }

    /**
     * Halaman contact
     * 
     * @return view
     */
    public function contact()
    {
        return view('contact');
    }
}
