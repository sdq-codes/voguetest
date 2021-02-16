<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'api'],function (){
    Route::group(['prefix' => 'v1'],function (){
        Route::get('',function (){
            return 'Welcome to Vogue Pay test';
        });

        Route::group(['prefix' => 'auth'],function (){
            Route::post('/login','Auth\AuthController@login');
            Route::post('/register','Auth\AuthController@register');
            Route::post('/password/reset/mail','Auth\AuthController@resetPasswordMail');
            Route::post('/mail/resend','Auth\AuthController@resendVerification');
        });

        Route::group(['middleware' => ['auth:api']],function (){
            Route::put('/verify','Auth\AuthController@userVerification');
            Route::put('/password/reset','Auth\AuthController@passwordReset');
            Route::group(['prefix' => 'accounts'],function (){
                Route::post('','UserController@create');
            });
            Route::group(['prefix' => 'permissions'],function (){
                Route::post('','UserPermissionController@create');
                Route::get('','UserPermissionController@all');
                Route::get('{userId}','UserPermissionController@user');
                Route::delete('{userPermissionId}','UserPermissionController@revoke');
            });
            Route::group(['prefix' => 'transfers'],function (){
                Route::get('','PaymentController@create');
                Route::get('{userId}','PaymentController@user');
                Route::post('','PaymentController@all');
            });
        });
    });
});
