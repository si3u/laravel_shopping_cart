<?php
Route::group([
    'middleware' => ['web'],
    'prefix' => Config::get('route_lang')
], function() {
    Route::get('/', function () {
        return view('index');
    })->name('public.index');

    Route::get('/news', 'NewsController@Page')->name('public.news');
    Route::get('/news/{id}', 'NewsController@Show')->name('public.show_news');
    Route::post('/news/comment/create', 'NewsCommentController@Create')->name('public.news.comment.create');

    Route::get('/payment', 'TextPageController@Page')->name('public.text_page.payment');
    Route::get('/delivery', 'TextPageController@Page')->name('public.text_page.delivery');
    Route::get('/cooperation', 'TextPageController@Page')->name('public.text_page.cooperation');

    Route::get('/price', 'PriceController@Page')->name('public.price');
    Route::post('/calculate_price', 'PriceController@PublicCalculatePrice')->name('public.calculate_price');

    Route::get('/contacts', function() {
        return view('contacts');
    })->name('public.contatcs');

    Route::get('/print', function() {
        return view('print');
    })->name('public.print');
    Route::post('/print/create', 'OrderPrintPictureController@Create')->name('public.print.create');

    // // //orders
    Route::post('/order/create', [
        'uses' => 'OrderController@Create'
    ]);

    // // //support
    Route::post('/support/send_mail', [
        'uses' => 'MailController@SendEmail'
    ])->name('public.support.send_mail');

    Route::get('/admin/login', function () {
        return view('admin.login');
    })->name('admin/login');

    Route::post('/admin/sign_in', [
        'uses' => 'UserController@SignIn'
    ])->name('admin/sign_in');
});

Route::group(['middleware' => ['only-administration']], function() {

    Route::get('/admin', function () {
        return view('admin.main');
    });
    Route::get('/admin/main', function () {
        return view('admin.main');
    })->name('admin/main');

    // // //user
    Route::post('/admin/user/edit_password', [
        'uses' => 'UserController@ChangePass'
    ]);
    Route::post('/admin/user/change_email', [
        'uses' => 'UserController@ChangeEmail'
    ]);


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

    Route::get('/admin/news/comments', [
        'uses' => 'admin\NewsCommentController@Page'
    ])->name('admin/news/comments');
    Route::get('/admin/news/comments/update/{id}', [
        'uses' => 'admin\NewsCommentController@PageUpdate'
    ])->name('admin/news/comment/update_page');

    Route::post('/admin/news/comment/update', [
        'uses' => 'admin\NewsCommentController@Update'
    ])->name('admin/news/comment/update');
    Route::get('/admin/news/comment/delete/{id}', [
        'uses' => 'admin\NewsCommentController@Delete'
    ])->name('admin/news/comment/delete');
    Route::get('/admin/news/comments/search/', [
        'uses' => 'admin\NewsCommentController@Search'
    ])->name('admin/news/comments/search');

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

    // // //text section
    Route::get('/admin/text_section/{section}', [
        'uses' => 'admin\TextSectionController@Get'
    ])->name('admin/text_section/update_page');
    Route::post('/admin/text_section/update', [
        'uses' => 'admin\TextSectionController@Update'
    ])->name('admin/text_section/update');


    // // //localization
    Route::post('/admin/active_localization/get', [
        'uses' => 'admin\ActiveLocalizationController@Get'
    ])->name('active_localization/get');
    Route::post('/admin/active_localization/get_active', [
        'uses' => 'admin\ActiveLocalizationController@GetActive'
    ])->name('active_localization/get_active');
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
    Route::get('/admin/modular_image/update/{id}', [
        'uses' => 'admin\ModularImageController@PageUpdate'
    ])->name('modular_image/update');

    Route::post('/admin/modular_image/add', [
        'uses' => 'admin\ModularImageController@Add'
    ])->name('admin/modular_image/add');
    Route::get('/admin/modular_image/delete/{id}', [
        'uses' => 'admin\ModularImageController@Delete'
    ])->name('admin/modular_image/delete');

    // // // size modular images
    Route::post('/admin/size_modular_image/add', [
        'uses' => 'admin\SizeModularImageController@Add'
    ])->name('size_modular_image/add');
    Route::post('/admin/size_modular_image/delete', [
        'uses' => 'admin\SizeModularImageController@Delete'
    ])->name('size_modular_image/delete');

    // // //paintings
    Route::get('/admin/paintings', [
        'uses' => 'admin\ProductController@Page'
    ])->name('admin/paintings');
    Route::get('/admin/painting/add', [
        'uses' => 'admin\ProductController@PageAdd'
    ])->name('admin/painting/add_page');
    Route::get('/admin/painting/update/{id}', [
        'uses' => 'admin\ProductController@PageUpdate'
    ])->name('admin/painting/update_page');

    Route::post('/admin/painting/add', [
        'uses' => 'admin\ProductController@Add'
    ])->name('painting/add');
    Route::post('/admin/painting/update', [
        'uses' => 'admin\ProductController@Update'
    ])->name('painting/update');
    Route::get('/admin/painting/delete/{id}', [
        'uses' => 'admin\ProductController@Delete'
    ])->name('painting/delete');
    Route::get('/admin/paintings/search/', [
        'uses' => 'admin\ProductController@Search'
    ])->name('admin/paintings/search');

    // // //recommend paintings
    Route::get('/admin/recommend_paintings', [
        'uses' => 'admin\RecommendProductController@Page'
    ])->name('admin/recommend_paintings');

    Route::post('/admin/recommend_painting/add', [
        'uses' => 'admin\RecommendProductController@Add'
    ])->name('recommend_painting/add');
    Route::post('/admin/recommend_product/delete', [
        'uses' => 'admin\RecommendProductController@Delete'
    ])->name('recommend_painting/delete');

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

    // // //setting order statuses
    Route::get('/admin/setting/order_statuses', [
        'uses' => 'admin\SettingOrderStatusController@Page'
    ])->name('setting/order_statuses');

    Route::post('/admin/setting/order_status/add', [
        'uses' => 'admin\SettingOrderStatusController@Add'
    ])->name('setting/order_status/add');
    Route::get('/admin/setting/order_status/delete/{id}', [
        'uses' => 'admin\SettingOrderStatusController@Delete'
    ])->name('setting/order_status/delete');
    Route::get('/admin/setting/order_status/upon_receipt/{id}', [
        'uses' => 'admin\SettingOrderStatusController@ChangeUponReceipt'
    ])->name('setting/order_status/upon_receipt');

    // // //payment methods
    Route::get('/admin/payment_methods', [
        'uses' => 'admin\PaymentMethodController@Page'
    ])->name('admin/payment_methods');
    Route::get('/admin/payment_methods/add', [
        'uses' => 'admin\PaymentMethodController@PageAdd'
    ])->name('payment_methods/add');
    Route::get('/admin/payment_methods/update/{id}', [
        'uses' => 'admin\PaymentMethodController@PageUpdate'
    ])->name('payment_methods/update');

    Route::post('/admin/payment_method/add', [
        'uses' => 'admin\PaymentMethodController@Add'
    ])->name('payment_method/add');
    Route::post('/admin/payment_method/update', [
        'uses' => 'admin\PaymentMethodController@Update'
    ])->name('payment_method/update');
    Route::get('/admin/payment_method/delete/{id}', [
        'uses' => 'admin\PaymentMethodController@Delete'
    ])->name('payment_method/delete');

    // // //delivery methods
    Route::get('/admin/delivery_methods', [
        'uses' => 'admin\DeliveryMethodController@Page'
    ])->name('admin/delivery_methods');
    Route::get('/admin/delivery_methods/add', [
        'uses' => 'admin\DeliveryMethodController@PageAdd'
    ])->name('delivery_methods/page_add');
    Route::get('/admin/delivery_method/update/{id}', [
        'uses' => 'admin\DeliveryMethodController@PageUpdate'
    ])->name('delivery_methods/page_update');

    Route::post('/admin/delivery_method/add', [
        'uses' => 'admin\DeliveryMethodController@Add'
    ])->name('delivery_method/add');
    Route::post('/admin/delivery_method/update', [
        'uses' => 'admin\DeliveryMethodController@Update'
    ])->name('delivery_method/update');
    Route::get('/admin/delivery_method/delete/{id}', [
        'uses' => 'admin\DeliveryMethodController@Delete'
    ])->name('delivery_method/delete');

    // // //contacts
    Route::get('/admin/contacts', [
        'uses' => 'admin\ContactController@PageUpdate'
    ])->name('admin/contacts');
    Route::post('/admin/contacts/update', [
        'uses' => 'admin\ContactController@Update'
    ])->name('admin/contacts/update');

    // // //order
    Route::get('/admin/orders', [
        'uses' => 'admin\OrderController@Page'
    ])->name('admin/orders');

    // // //upload files
    Route::post('/admin/upload_file/', [
        'uses' => 'admin\UploadFileController@Upload'
    ])->name('upload_file');

    // // //order print pictures
    Route::get('/admin/orders/print_pictures', [
        'uses' => 'admin\OrderPrintPictureController@Page',
    ])->name('admin/orders/print_pictures');
    Route::get('/admin/order/print_picture/update/{id}', [
        'uses' => 'admin\OrderPrintPictureController@PageUpdate',
    ])->name('admin/order/print_picture/page_update');
    Route::get('/admin/orders/print_pictures/search', [
        'uses' => 'admin\OrderPrintPictureController@Search',
    ])->name('admin/orders/print_pictures/search');
    Route::get('/admin/order/print_picture/delete/{id}', [
        'uses' => 'admin\OrderPrintPictureController@Delete',
    ])->name('admin/order/print_picture/delete');

    Route::post('/admin/order/print_picture/update', [
        'uses' => 'admin\OrderPrintPictureController@Update',
    ])->name('admin/order/print_picture/update');

    // // //wallpaper categories
    Route::get('/admin/wallpaper_categories', [
        'uses' => 'admin\WallpaperCategoryController@Page'
    ])->name('admin/wallpaper_categories');
    Route::get('/admin/wallpaper_categories/add', [
        'uses' => 'admin\WallpaperCategoryController@PageAdd'
    ])->name('admin/wallpaper_categories/add');
    Route::get('/admin/wallpaper_categories/update/{id}', [
        'uses' => 'admin\WallpaperCategoryController@PageUpdate'
    ])->name('wallpaper_categories/update');

    Route::post('/admin/wallpaper_category/add', [
        'uses' => 'admin\WallpaperCategoryController@Add'
    ])->name('admin/wallpaper_category/add');
    Route::post('/admin/wallpaper_category/update', [
        'uses' => 'admin\WallpaperCategoryController@Update'
    ])->name('wallpaper_category/update');
    Route::get('/admin/wallpaper_category/delete/{id}', [
        'uses' => 'admin\WallpaperCategoryController@Delete'
    ])->name('wallpaper_category/delete');

    // // //wallpaper
    Route::get('/admin/wallpapers', [
        'uses' => 'admin\WallpaperController@Page'
    ])->name('admin/wallpapers');
    Route::get('/admin/wallpaper/add', [
        'uses' => 'admin\WallpaperController@PageAdd'
    ])->name('admin/wallpaper/add_page');
    Route::get('/admin/wallpaper/update/{id}', [
        'uses' => 'admin\WallpaperController@PageUpdate'
    ])->name('admin/wallpaper/update_page');

    Route::post('/admin/wallpaper/add', [
        'uses' => 'admin\WallpaperController@Add'
    ])->name('wallpaper/add');
    Route::post('/admin/wallpaper/update', [
        'uses' => 'admin\WallpaperController@Update'
    ])->name('wallpaper/update');
    Route::get('/admin/wallpaper/delete/{id}', [
        'uses' => 'admin\WallpaperController@Delete'
    ])->name('wallpaper/delete');
    Route::get('/admin/wallpapers/search/', [
        'uses' => 'admin\WallpaperController@Search'
    ])->name('admin/wallpapers/search');

    // // //wallpaper comments
    Route::get('/admin/wallpaper/comments', [
        'uses' => 'admin\WallpaperCommentController@Page'
    ])->name('admin/wallpaper/comments');
    Route::get('/admin/wallpaper/comment/{id}', [
        'uses' => 'admin\WallpaperCommentController@PageUpdate'
    ])->name('wallpaper/comment/page_update');

    Route::post('/admin/wallpaper/comment/update', [
        'uses' => 'admin\WallpaperCommentController@Update'
    ])->name('wallpaper/comment/update');
    Route::get('/admin/wallpaper/comment/delete/{id}', [
        'uses' => 'admin\WallpaperCommentController@Delete'
    ])->name('wallpaper/comment/delete');
    Route::get('/admin/wallpaper/comments/search/', [
        'uses' => 'admin\WallpaperCommentController@Search'
    ])->name('wallpaper/comments/search');

    // // //wallpaper eviews
    Route::get('/admin/wallpaper/reviews/', [
        'uses' => 'admin\WallpaperReviewController@Page'
    ])->name('wallpaper/reviews');
    Route::get('/admin/wallpaper/review/update/{id}', [
        'uses' => 'admin\WallpaperReviewController@PageUpdate'
    ])->name('wallpaper/review/page_update');

    Route::post('/admin/wallpaper/review/update', [
        'uses' => 'admin\WallpaperReviewController@Update'
    ])->name('wallpaper/review/update');
    Route::get('/admin/wallpaper/review/delete/{id}', [
        'uses' => 'admin\WallpaperReviewController@Delete'
    ])->name('wallpaper/review/delete');
    Route::get('/admin/wallpaper/reviews/search', [
        'uses' => 'admin\WallpaperReviewController@Search'
    ])->name('wallpaper/reviews/search');

    // // //download files
    Route::get('/admin/download/{model}/{file_name}', [
        'uses' => 'admin\FileDownloadController@Run',
    ])->name('admin/download');

    // // //exit
    Route::get('/admin/exit', [
        'uses' => 'UserController@SignOut',
    ])->middleware('auth');

    // // //google analytics
    Route::get('/admin/analytics', [
        'uses' => 'admin\AnalyticsController@Page'
    ])->name('admin/analytics');
});

Auth::routes();
