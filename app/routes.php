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
Route::post('main/upload','ApplicantController@handleEssayFileUpload');
Route::post('main/startapp','ApplicantController@saveStartApp');
Route::get('main/application','ApplicantController@fetchApplication');
Route::get('pdf',function(){
    Fpdf::AddPage();
    Fpdf::SetFont('Arial','B',16);
    Fpdf::Cell(40,10,'Hello World!');
    Fpdf::Output();
    exit;
});
