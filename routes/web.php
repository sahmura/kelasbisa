<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(
    ['prefix' => 'admin', 'middleware' => 'App\Http\Middleware\Admin'],
    function () {
        Route::get('/', 'AdminController@index');

        Route::group(
            ['prefix' => 'category'],
            function () {
                Route::get('/', 'CategoryController@index');
                Route::post('getListData', 'CategoryController@getListCategory');
                Route::post('add', 'CategoryController@addCategory');
                Route::post('edit', 'CategoryController@updateCategory');
                Route::delete('delete', 'CategoryController@deleteCategory');
            }
        );

        Route::group(
            ['prefix' => 'class'],
            function () {
                Route::get('/', 'ClassController@index');
                Route::post('getListData', 'ClassController@getListClass');
                Route::post('create', 'ClassController@addClass');
                Route::post('edit', 'ClassController@updateClass');
                Route::delete('delete', 'ClassController@deleteClass');
                Route::get('new', 'ClassController@newClass');
                Route::get('{id}/detail', 'ClassController@detailClass');
                Route::get('{id}/edit', 'ClassController@editClass');

                Route::group(
                    ['prefix' => 'chapter'],
                    function () {
                        Route::post('new', 'ChapterController@addChapter');
                        Route::post('edit', 'ChapterController@editChapter');
                        Route::delete('delete', 'ChapterController@deleteChapter');
                    }
                );

                Route::group(
                    ['prefix' => 'subchapter'],
                    function () {
                        Route::post('new', 'SubChapterController@addSubChapter');
                        Route::delete('delete', 'SubChapterController@deleteSubChapter');
                        Route::post('edit', 'SubChapterController@editSubChapter');
                    }
                );
            }
        );

        Route::group(
            ['prefix' => 'coupon'],
            function () {
                Route::get('/', 'CouponController@index');
                Route::post('add', 'CouponController@createCoupon');
                Route::post('getListData', 'CouponController@getListCoupon');
                Route::post('edit', 'CouponController@updateCoupon');
                Route::delete('delete', 'CouponController@deleteCoupon');
            }
        );
    }
);

Route::group(
    ['prefix' => 'user', 'middleware' => 'App\Http\Middleware\User'],
    function () {
        Route::get('class/{category?}', 'ClassController@listClassUser');
        Route::get('myclass/{category?}', 'ClassController@listMyClassUser');
        Route::get('class/{id}/detail', 'ClassController@detailClassUser');
        Route::post('joinclass', 'ClassController@joinClass');

        Route::get('/', 'DashboardController@indexuser');
    }
);
