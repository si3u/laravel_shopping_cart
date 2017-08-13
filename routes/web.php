<?php
Route::group(['middleware' => ['web']], function() {
    Route::get('/', function () {
        echo "not auth";
    });

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
    Route::get('/', function () {
        echo "auth";
    });

    Route::get('/admin', function () {
        return view('admin.main');
    });
    Route::get('/admin/main', function () {
        return view('admin.main');
    })->name('admin/main');

    // // //category
    Route::get('/admin/categories', [
        'uses' => 'admin\CategoryController@Page'
    ])->name('admin/categories');
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

    // // //default size
    Route::get('/admin/default_sizes', [
        'uses' => 'admin\DefaultSizeController@Page'
    ])->name('admin/default_sizes');

    Route::post('/admin/default_size/add', [
        'uses' => 'admin\DefaultSizeController@Add'
    ])->name('admin/default_size/add');
    Route::post('/admin/default_size/delete', [
        'uses' => 'admin\DefaultSizeController@Delete'
    ])->name('admin/default_size/delete');


    //  // //filter by color
    Route::get('/admin/filter_colors', [
        'uses' => 'admin\FilterByColorController@Page'
    ])->name('admin/filter_colors');

    Route::post('/admin/filter_color/add', [
        'uses' => 'admin\FilterByColorController@Add'
    ])->name('admin/filter_color/add');
    Route::post('/admin/filter_color/delete', [
        'uses' => 'admin\FilterByColorController@Delete'
    ])->name('admin/filter_color/delete');


    // // //text page
    Route::get('/admin/text_page/{id}', [
        'uses' => 'admin\TextPageController@Get'
    ])->name('admin/text_page');

    Route::post('/admin/text_page/update', [
        'uses' => 'admin\TextPageController@Update'
    ])->name('admin/text_page/update');


    // // //news
    Route::get('/admin/news', [
        'uses' => 'admin\NewsController@Page'
    ])->name('admin/news');
    Route::get('/admin/news/add', [
        'uses' => 'admin\NewsController@PageAdd'
    ])->name('news/add_page');
    Route::get('/admin/news/update/{id}', [
        'uses' => 'admin\NewsController@PageUpdate'
    ])->name('news/update_page');

    Route::post('/admin/news/add', [
        'uses' => 'admin\NewsController@Add'
    ])->name('news/add');
    Route::post('/admin/news/update', [
        'uses' => 'admin\NewsController@Update'
    ])->name('news/update');
    Route::get('/admin/news/delete/{id}', [
        'uses' => 'admin\NewsController@Delete'
    ])->name('news/delete');
    Route::get('/admin/news/search', [
        'uses' => 'admin\NewsController@Search'
    ])->name('admin/news/search');


    // // //localization
    Route::post('/admin/active_localization/get', [
        'uses' => 'admin\ActiveLocalizationController@Get'
    ])->name('active_localization/update');
    Route::post('/admin/active_localization/update', [
        'uses' => 'admin\ActiveLocalizationController@Update'
    ])->name('active_localization/update');

    // // //price
    Route::get('/admin/prices', [
        'uses' => 'admin\PriceController@Page'
    ])->name('admin/prices');
    Route::post('/admin/prices/update', [
        'uses' => 'admin\PriceController@Update'
    ])->name('prices/update');

    // // //modular images
    Route::get('/admin/modular_images', [
        'uses' => 'admin\ModularImageController@Page'
    ])->name('admin/modular_images');
    Route::get('/admin/modular_images/add', [
        'uses' => 'admin\ModularImageController@PageAdd'
    ])->name('admin/modular_images/add');

    Route::post('/admin/modular_image/add', [
        'uses' => 'admin\ModularImageController@Add'
    ])->name('admin/modular_image/add');
    Route::get('/admin/modular_image/delete/{id}', [
        'uses' => 'admin\ModularImageController@Delete'
    ])->name('admin/modular_image/delete');


    // // //products
    Route::get('/admin/products', [
        'uses' => 'admin\ProductController@Page'
    ])->name('admin/products');
    Route::get('/admin/product/add', [
        'uses' => 'admin\ProductController@PageAdd'
    ])->name('admin/product/add_page');
    Route::get('/admin/product/update/{id}', [
        'uses' => 'admin\ProductController@PageUpdate'
    ])->name('admin/product/update_page');

    Route::post('/admin/product/add', [
        'uses' => 'admin\ProductController@Add'
    ])->name('product/add');
    Route::post('/admin/product/update', [
        'uses' => 'admin\ProductController@Update'
    ])->name('product/update');
    Route::get('/admin/product/delete/{id}', [
        'uses' => 'admin\ProductController@Delete'
    ])->name('product/delete');
    Route::get('/admin/product/search/', [
        'uses' => 'admin\ProductController@Search'
    ])->name('admin/product/search');

    // // //comments
    Route::get('/admin/comments', [
        'uses' => 'admin\ProductCommentController@Page'
    ])->name('admin/comments');
    Route::get('/admin/comment/{id}', [
        'uses' => 'admin\ProductCommentController@PageUpdate'
    ])->name('comment/page_update');

    Route::post('/admin/comment/update', [
        'uses' => 'admin\ProductCommentController@Update'
    ])->name('comment/update');
    Route::get('/admin/comment/delete/{id}', [
        'uses' => 'admin\ProductCommentController@Delete'
    ])->name('comment/delete');
    Route::get('/admin/comments/search/', [
        'uses' => 'admin\ProductCommentController@Search'
    ])->name('comments/search');

    // // //reviews
    Route::get('/admin/reviews/', [
        'uses' => 'admin\ProductReviewController@Page'
    ])->name('products/reviews');
    Route::get('/admin/review/update/{id}', [
        'uses' => 'admin\ProductReviewController@PageUpdate'
    ])->name('review/page_update');

    Route::post('/admin/review/update', [
        'uses' => 'admin\ProductReviewController@Update'
    ])->name('review/update');
    Route::get('/admin/review/delete/{id}', [
        'uses' => 'admin\ProductReviewController@Delete'
    ])->name('review/delete');
    Route::get('/admin/reviews/search', [
        'uses' => 'admin\ProductReviewController@Search'
    ])->name('reviews/search');
});

Auth::routes();