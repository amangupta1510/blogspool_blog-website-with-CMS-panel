<?php

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
// route to login and logout


     Route::get('/', 'homecontroller@index')->name('index');
     Route::get('/detail_blog', 'homecontroller@detail_blog')->name('detail_blog');
     Route::get('/category', 'homecontroller@category')->name('category');
     Route::get('/contact', 'homecontroller@contact')->name('contact');
     Route::get('/about', 'homecontroller@about')->name('about');
     Route::get('/events', 'homecontroller@events')->name('events');
     Route::post('/archive','homecontroller@archive')->name('archive');
     


       Route::prefix('/admin')->group(function() {
       Route::get('/', 'Auth\AdminLoginController@showLoginForm');
       Route::get('login', 'Auth\AdminLoginController@showLoginForm')->name('admin-form');
       Route::post('login', 'Auth\AdminLoginController@attemptlogin')->name('admin-login');
       Route::get('logout', 'Auth\AdminLoginController@logout')->name('admin-logout');

       Route::get('/dashboard', 'admincontroller@index')->name('admin-dashboard');

       Route::get('/profile', 'admincontroller@profile')->name('admin-profile');
       Route::POST('/edit_profile_submit', 'admincontroller@edit_profile_submit')->name('admin-edit_profile_submit');
       Route::get('/change_password', 'admincontroller@change_password')->name('admin-change_password');
       Route::POST('/change_password_submit', 'admincontroller@change_password_submit')->name('admin-change_password_submit');
       Route::get('/profile', 'admincontroller@profile')->name('admin-profile');
       Route::POST('/edit_profile_submit', 'admincontroller@edit_profile_submit')->name('admin-edit_profile_submit');

       Route::get('/author', 'admincontroller@author')->name('author_list');
       Route::get('/add_author', 'admincontroller@add_author')->name('admin-add_author');
       Route::POST('/add_author_submit', 'admincontroller@add_author_submit')->name('admin-add_author_submit');
       Route::get('/delete_author', 'admincontroller@delete_author')->name('admin-delete_author');
       Route::get('/edit_author', 'admincontroller@edit_author')->name('admin-edit_author');
       Route::POST('/edit_author_submit', 'admincontroller@edit_author_submit')->name('admin-edit_author_submit');
       Route::get('/author_details', 'admincontroller@author_details')->name('admin-author_details');
       Route::get('/author_details_load', 'admincontroller@author_details_load')->name('admin-author_details_load');


       Route::get('/category', 'admincontroller@category')->name('category_list');
       Route::get('/add_category', 'admincontroller@add_category')->name('admin-add_category');
       Route::POST('/add_category_submit', 'admincontroller@add_category_submit')->name('admin-add_category_submit');
       Route::get('/delete_category', 'admincontroller@delete_category')->name('admin-delete_category');
       Route::get('/edit_category', 'admincontroller@edit_category')->name('admin-edit_category');
       Route::POST('/edit_category_submit', 'admincontroller@edit_category_submit')->name('admin-edit_category_submit');
       

       Route::get('/tag', 'admincontroller@tag')->name('tag_list');
       Route::get('/add_tag', 'admincontroller@add_tag')->name('admin-add_tag');
       Route::POST('/add_tag_submit', 'admincontroller@add_tag_submit')->name('admin-add_tag_submit');
       Route::get('/delete_tag', 'admincontroller@delete_tag')->name('admin-delete_tag');
       Route::get('/edit_tag', 'admincontroller@edit_tag')->name('admin-edit_tag');
       Route::POST('/edit_tag_submit', 'admincontroller@edit_tag_submit')->name('admin-edit_tag_submit');


       Route::get('/image', 'admincontroller@image')->name('image_list');
       Route::get('/add_image', 'admincontroller@add_image')->name('admin-add_image');
       Route::POST('/add_image_submit', 'admincontroller@add_image_submit')->name('admin-add_image_submit');
       Route::get('/delete_image', 'admincontroller@delete_image')->name('admin-delete_image');
       Route::get('/image_copy_address', 'admincontroller@image_copy_address')->name('admin-copy_address');
       


       Route::get('/article', 'admincontroller@article')->name('article');
       Route::get('/add_article', 'admincontroller@add_article')->name('admin-add_article');
       Route::POST('/add_article_submit', 'admincontroller@add_article_submit')->name('admin-add_article_submit');
       Route::get('/delete_article', 'admincontroller@delete_article')->name('admin-delete_article');
       Route::get('/edit_article', 'admincontroller@edit_article')->name('admin-edit_article');
       Route::POST('/edit_article_submit', 'admincontroller@edit_article_submit')->name('admin-edit_article_submit');
       Route::get('/article_details', 'admincontroller@article_details')->name('admin-article_details');
       Route::get('/article_details_load', 'admincontroller@article_details_load')->name('admin-article_details_load');
       Route::get('/upload_image_list', 'admincontroller@upload_image_list')->name('admin-upload_image_list');
       Route::POST('/ckeditor_upload', 'admincontroller@ckeditor_upload')->name('admin-ckeditor_upload');
       Route::POST('/upload_image_submit', 'admincontroller@upload_image_submit')->name('admin-upload_image_submit');
       
       
       
       


       
       
       

       

       
       
















       Route::get('/lot_details', 'admincontroller@lot_details')->name('admin-lot_details');
       Route::get('/lot_details_load', 'admincontroller@lot_details_load')->name('admin-lot_details_load');
       Route::POST('/add_lot_submit', 'admincontroller@add_lot_submit')->name('admin-add_lot_submit');
       Route::get('/edit_lot', 'admincontroller@edit_lot')->name('admin-edit_lot');
       Route::POST('/edit_lot_submit', 'admincontroller@edit_lot_submit')->name('admin-edit_lot_submit');
       Route::get('/delete_lot', 'admincontroller@delete_lot')->name('admin-delete_lot');
       Route::get('/distributer_details', 'admincontroller@distributer_details')->name('admin-distributer_details');
       Route::get('/distributer_details_load', 'admincontroller@distributer_details_load')->name('admin-distributer_details_load');
       Route::get('/article', 'admincontroller@article')->name('article');
       Route::get('/balance_sheet_load', 'admincontroller@balance_sheet_load')->name('admin-balance_sheet_load');
       Route::get('/export_balance_sheet', 'admincontroller@export_balance_sheet')->name('admin-export_balance_sheet');
       Route::get('/export_product_details', 'admincontroller@export_product_details')->name('admin-export_product_details');
       Route::get('/export_distributer_details', 'admincontroller@export_distributer_details')->name('admin-export_distributer_details');
       Route::get('/export_lot_details', 'admincontroller@export_lot_details')->name('admin-export_lot_details');
       Route::get('/post', 'admincontroller@post')->name('post');
       Route::get('/edit_enquiry', 'admincontroller@edit_enquiry')->name('admin-edit_enquiry');
       Route::get('/delete_enquiry', 'admincontroller@delete_enquiry')->name('admin-delete_enquiry');
       Route::get('/order', 'admincontroller@order')->name('admin-order');
       Route::get('/order_invoice', 'admincontroller@order_invoice')->name('admin-order_invoice');
       Route::get('/get_lot', 'admincontroller@get_lot')->name('admin-get_lot');
       Route::get('/order_details', 'admincontroller@order_details')->name('admin-order_details');
       Route::get('/add_order', 'admincontroller@add_order')->name('admin-add_order');
       Route::POST('/add_order_submit', 'admincontroller@add_order_submit')->name('admin-add_order_submit');
       Route::get('/edit_order', 'admincontroller@edit_order')->name('admin-edit_order');
       Route::POST('/edit_order_submit', 'admincontroller@edit_order_submit')->name('admin-edit_order_submit');
       Route::get('/delete_order', 'admincontroller@delete_order')->name('admin-delete_order');
     });

     Route::prefix('/author')->group(function() {
      Route::get('/', 'Auth\AuthorLoginController@showLoginForm');
      Route::get('login', 'Auth\AuthorLoginController@showLoginForm')->name('author-form');
      Route::post('login', 'Auth\AuthorLoginController@attemptlogin')->name('author-login');
      Route::get('logout', 'Auth\AuthorLoginController@logout')->name('author-logout');

      Route::get('/dashboard', 'authorcontroller@index')->name('author-dashboard');

      Route::get('/profile', 'authorcontroller@profile')->name('author-profile');
      Route::POST('/edit_profile_submit', 'authorcontroller@edit_profile_submit')->name('author-edit_profile_submit');
      Route::get('/change_password', 'authorcontroller@change_password')->name('author-change_password');
      Route::POST('/change_password_submit', 'authorcontroller@change_password_submit')->name('author-change_password_submit');
      Route::get('/profile', 'authorcontroller@profile')->name('author-profile');
      Route::POST('/edit_profile_submit', 'authorcontroller@edit_profile_submit')->name('author-edit_profile_submit');

      Route::get('/image', 'authorcontroller@image')->name('image_list');
      Route::get('/add_image', 'authorcontroller@add_image')->name('author-add_image');
      Route::POST('/add_image_submit', 'authorcontroller@add_image_submit')->name('author-add_image_submit');
      Route::get('/delete_image', 'authorcontroller@delete_image')->name('author-delete_image');
      Route::get('/image_copy_address', 'authorcontroller@image_copy_address')->name('author-copy_address');
      


      Route::get('/article', 'authorcontroller@article')->name('article');
      Route::get('/add_article', 'authorcontroller@add_article')->name('author-add_article');
      Route::POST('/add_article_submit', 'authorcontroller@add_article_submit')->name('author-add_article_submit');
      Route::get('/delete_article', 'authorcontroller@delete_article')->name('author-delete_article');
      Route::get('/edit_article', 'authorcontroller@edit_article')->name('author-edit_article');
      Route::POST('/edit_article_submit', 'authorcontroller@edit_article_submit')->name('author-edit_article_submit');
      Route::get('/article_details', 'authorcontroller@article_details')->name('author-article_details');
      Route::get('/article_details_load', 'authorcontroller@article_details_load')->name('author-article_details_load');
      Route::get('/upload_image_list', 'authorcontroller@upload_image_list')->name('author-upload_image_list');
      Route::POST('/ckeditor_upload', 'authorcontroller@ckeditor_upload')->name('author-ckeditor_upload');
      Route::POST('/upload_image_submit', 'authorcontroller@upload_image_submit')->name('author-upload_image_submit');  
    });
  
