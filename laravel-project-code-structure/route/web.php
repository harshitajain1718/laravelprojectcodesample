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
Route::get('/cache-clear', function() {

   Artisan::call('cache:clear');
   Artisan::call('config:clear');
   Artisan::call('config:cache');
   Artisan::call('view:clear');

   return "Cleared!";

});
Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', function () {
    return view('admin.login');
})->name('admin.login');

Route::get('/', function () {
    return view('user.login');
})->name('user.login');

Route::get('admin/logout', 'LoginController@logout')->name("admin.logout");

Route::get('user/logout', 'LoginController@logout')->name("user.logout");

Route::post('admin/login', 'LoginController@adminCheckLogin')->name('admin.checkLogin'); 

Route::post('login', 'LoginController@userCheckLogin')->name('user.checkLogin'); 

//user panel routes
Route::group(['prefix'=> '', 'middleware' => ['user']], function()
{ 
	// Industry question-answer
	Route::get('/industry_knowledge/{id?}', 'User\\IndustryQuesAnsController@index')->name('user.category.industry.question_answer');
	Route::post('/industry_knowledge/question/add', 'User\\IndustryQuesAnsController@store')->name('user.category.industry.question_answer.add');

	Route::post('/industry_knowledge/question/update/{id?}', 'User\\IndustryQuesAnsController@update')->name('user.category.industry.question_answer.update');

	Route::post('/industry_knowledge/question/delete/{id?}', 'User\\IndustryQuesAnsController@destroy')->name('user.category.industry.question_answer.delete');

	//Routes for Industry Final test
	Route::get('/industry/dotest','User\\IndustryFinalTestController@index')->name('industry.user.dotest');
	Route::post('/industry/getcategory/{id?}','User\\IndustryFinalTestController@getcategory')->name('industry.user.dotest.getcategory');
	Route::post('/industry/dotest/dotest','User\\IndustryFinalTestController@dotest')->name('industry.user.dotest.dotest');
	Route::post('/industry/dotest/test_details','User\\IndustryFinalTestController@test_details')->name('industry.user.dotest.test_details');
	Route::post('/industry/dotest/result','User\\IndustryFinalTestController@result')->name('industry.user.dotest.result');
	Route::get('/industry/dotest/displayresult/{type?}','User\\IndustryFinalTestController@displayresult')->name('industry.user.dotest.displayresult');
	Route::get('/industry/dotest/resultdetails','User\\IndustryFinalTestController@resultdetails')->name('industry.user.dotest.resultdetails');

});