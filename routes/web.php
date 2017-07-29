<?php
Route::group(['middleware' => ['web']], function() {
    Route::get('/admin/login', function () {
        return view('admin.login');
    })->name('admin/login');

    Route::post('/admin/sign_in', [
        'uses' => 'UserController@SignIn'
    ])->name('admin/sign_in');

    Route::get('/admin/exit', [
        'uses' => 'UserController@SignOut',
    ])->middleware('auth');
});

Route::group(['middleware' => ['only-administration']], function() {
    Route::get('/admin/main', function () {
        return view('admin.main');
    })->name('admin/main');

    Route::get('/admin/categories', [
        'uses' => 'admin\CategoryController@Page'
    ])->name('admin/categories');

    // // //category
    Route::get('/admin/categories/add', [
        'uses' => 'admin\CategoryController@PageAdd'
    ])->name('admin/categories/add');
    Route::get('/admin/categories/update/{id}', [
        'uses' => 'admin\CategoryController@PageUpdate'
    ])->name('categories/update');

    Route::post('/admin/category/add', [
        'uses' => 'admin\CategoryController@Add'
    ])->name('admin/category/add');
    Route::post('/admin/category/update', [
        'uses' => 'admin\CategoryController@Update'
    ])->name('category/update');
    Route::get('/admin/category/delete/{id}', [
        'uses' => 'admin\CategoryController@Delete'
    ])->name('category/delete');

    Route::post('/admin/active_localization/get', [
        'uses' => 'admin\ActiveLocalizationController@Get'
    ])->name('active_localization/update');
    Route::post('/admin/active_localization/update', [
        'uses' => 'admin\ActiveLocalizationController@Update'
    ])->name('active_localization/update');
});

Auth::routes();