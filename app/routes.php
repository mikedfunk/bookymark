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

Route::get(
    'bookmarks',
    array(
        'as'     => 'bookmarks.index',
        'uses'   => 'Bookymark\Bookmarks\BookmarkController@index',
        'before' => 'auth',
    )
);

Route::get(
    'bookmarks/create',
    array(
        'as'     => 'bookmarks.create',
        'uses'   => 'Bookymark\Bookmarks\BookmarkController@create',
        'before' => 'auth',
    )
);

Route::get(
    'bookmarks/{id}/edit',
    array(
        'as'     => 'bookmarks.edit',
        'uses'   => 'Bookymark\Bookmarks\BookmarkController@edit',
        'before' => 'auth',
    )
);

Route::get(
    'bookmarks/{id}/destroy',
    array(
        'as'     => 'bookmarks.destroy',
        'uses'   => 'Bookymark\Bookmarks\BookmarkController@destroy',
        'before' => 'auth',
    )
);

Route::put(
    'bookmarks/{id}',
    array(
        'as'     => 'bookmarks.update',
        'uses'   => 'Bookymark\Bookmarks\BookmarkController@update',
        'before' => 'auth',
    )
);

Route::post(
    'bookmarks',
    array(
        'as'     => 'bookmarks.store',
        'uses'   => 'Bookymark\Bookmarks\BookmarkController@store',
        'before' => 'auth',
    )
);

// ----------------------------------------------------------------

Route::get(
    'auth/login',
    array(
        'as' => 'auth.login',
        'uses' => 'Bookymark\Auth\AuthController@login',
    )
);

Route::post(
    'auth/login',
    array(
        'as'     => 'auth.do_login',
        'uses'   => 'Bookymark\Auth\AuthController@doLogin',
        'before' => 'registration_confirmed',
    )
);

Route::get(
    'auth/logout',
    array(
        'as'   => 'auth.logout',
        'uses' => 'Bookymark\Auth\AuthController@logout',
    )
);

Route::get(
    'auth/remind',
    array(
        'as'   => 'auth.remind',
        'uses' => 'Bookymark\Auth\AuthController@remind',
    )
);

Route::post(
    'auth/remind',
    array(
        'as'   => 'auth.do_remind',
        'uses' => 'Bookymark\Auth\AuthController@doRemind',
    )
);

Route::get(
    'auth/reset/{token}',
    array(
        'as'   => 'auth.reset',
        'uses' => 'Bookymark\Auth\AuthController@reset',
    )
);

Route::post(
    'auth/reset/{token}',
    array(
        'as'   => 'auth.do_reset',
        'uses' => 'Bookymark\Auth\AuthController@doReset',
    )
);

Route::get(
    'auth/register',
    array(
        'as'   => 'auth.register',
        'uses' => 'Bookymark\Auth\AuthController@register',
    )
);

Route::post(
    'auth/register',
    array(
        'as'     => 'auth.do_register',
        'uses'   => 'Bookymark\Auth\AuthController@doRegister',
        'before' => 'csrf',
    )
);

Route::get(
    'auth/{token}/confirm-registration',
    array(
        'as'     => 'auth.confirm_registration',
        'uses'   => 'Bookymark\Auth\AuthController@confirmRegistration',
    )
);

Route::get(
    'auth/{id}/profile',
    array(
        'as'   => 'auth.profile',
        'uses' => 'Bookymark\Auth\AuthController@profile',
    )
);

Route::post(
    'auth/{id}/profile',
    array(
        'as'     => 'auth.do_profile',
        'uses'   => 'Bookymark\Auth\AuthController@updateProfile',
        'before' => 'csrf',
    )
);

// ----------------------------------------------------------------

Route::get(
    '/',
    array(
        'as'   => 'home',
        'uses' => 'Bookymark\Home\HomeController@index',
    )
);
