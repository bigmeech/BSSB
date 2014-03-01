<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('index');
});

Route::post('auth/login','AuthController@login');
Route::post('auth/signup','AuthController@signup');
Route::post('auth/logout','AuthController@logout');
Route::post('auth/changePassword','AuthController@changePassword');

Route::post('main/upload','FileController@uploadFile');
Route::post('main/startapp','ApplicantController@saveStartApp');
Route::post('main/biodata','ApplicantController@addBioData');
Route::post('main/qualifications','ApplicantController@addQualificationDetails');
Route::post('main/higher-inst','ApplicantController@addHigherInstDetails');
Route::post('main/professional-qualifications','ApplicantController@addProfQuali');

Route::get('main/application','ApplicantController@fetchApplication');
Route::get('main/fetchbio','ApplicantController@fetchBioData');
Route::get('main/test','FileController@doSomething');
Route::get('main/getBasicQualifications','ApplicantController@fetchBasicQualifications');
Route::get('main/higher-institution','ApplicantController@fetchHigherInst');
Route::get('main/getProfQuali','ApplicantController@fetchProfQuali');
Route::get('main/getPreview','ApplicantController@fetchPreview');
Route::get('main/getAppData','ApplicantController@fetchAppData');
Route::get('main/getFormCompleteData','ApplicantController@fetchFormCompleteData');

Route::get('main/submit','ApplicantController@submitApplication');

//routes for admin
Route::get('admin','AdminController@index');
Route::post('admin/auth','AdminAuthController@authenticate');
Route::get('admin/logout','AdminAuthController@logout');
Route::get('admin/main','AdminController@dashboard');
Route::get('admin/applicants','AdminApplicationController@getApplicants');
Route::get('admin/search','AdminApplicationController@findApplicant');

//routes for approves and declines
Route::get('admin/get-approved','AdminApplicationController@getApproved');
Route::post('admin/set-approved','AdminApplicationController@setApproved');
Route::get('admin/get-declined','AdminApplicationController@getDeclined');
Route::post('admin/set-declined','AdminApplicationController@setDeclined');
Route::resource('admin/applicant','AdminApplicantController');
Route::resource('admin/users','AdminUsersController');
Route::resource('admin/overview','OverviewController');