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
        'uses'   => 'MikeFunk\Bookymark\Bookmarks\BookmarkController@index',
        'before' => 'auth',
    )
);

Route::get(
    'bookmarks/create',
    array(
        'as'     => 'bookmarks.create',
        'uses'   => 'MikeFunk\Bookymark\Bookmarks\BookmarkController@create',
        'before' => 'auth',
    )
);

Route::get(
    'bookmarks/{id}/edit',
    array(
        'as'     => 'bookmarks.edit',
        'uses'   => 'MikeFunk\Bookymark\Bookmarks\BookmarkController@edit',
        'before' => 'auth',
    )
);

Route::get(
    'bookmarks/{id}/delete',
    array(
        'as'     => 'bookmarks.delete',
        'uses'   => 'MikeFunk\Bookymark\Bookmarks\BookmarkController@delete',
        'before' => 'auth',
    )
);

Route::put(
    'bookmarks/{id}',
    array(
        'as'     => 'bookmarks.update',
        'uses'   => 'MikeFunk\Bookymark\Bookmarks\BookmarkController@update',
        'before' => 'csrf|auth',
    )
);

Route::post(
    'bookmarks',
    array(
        'as'     => 'bookmarks.store',
        'uses'   => 'MikeFunk\Bookymark\Bookmarks\BookmarkController@store',
        'before' => 'csrf|auth',
    )
);

// ----------------------------------------------------------------

Route::get(
    'auth/login',
    array(
        'as' => 'auth.login',
        'uses' => 'MikeFunk\Bookymark\Auth\AuthController@login',
    )
);

Route::post(
    'auth/login',
    array(
        'as'     => 'auth.do_login',
        'uses'   => 'MikeFunk\Bookymark\Auth\AuthController@doLogin',
        'before' => 'csrf|registration_confirmed',
    )
);

Route::get(
    'auth/logout',
    array(
        'as'   => 'auth.logout',
        'uses' => 'MikeFunk\Bookymark\Auth\AuthController@logout',
    )
);

Route::get(
    'auth/remind',
    array(
        'as'   => 'auth.remind',
        'uses' => 'MikeFunk\Bookymark\Auth\AuthController@remind',
    )
);

Route::post(
    'auth/remind',
    array(
        'as'     => 'auth.do_remind',
        'uses'   => 'MikeFunk\Bookymark\Auth\AuthController@doRemind',
        'before' => 'csrf',
    )
);

Route::get(
    'auth/{token}/reset-password',
    array(
        'as'   => 'auth.reset_password',
        'uses' => 'MikeFunk\Bookymark\Auth\AuthController@resetPassword',
    )
);

Route::post(
    'auth/{token}/reset-password',
    array(
        'as'     => 'auth.do_reset_password',
        'uses'   => 'MikeFunk\Bookymark\Auth\AuthController@doResetPassword',
        'before' => 'csrf',
    )
);

Route::get(
    'auth/register',
    array(
        'as'   => 'auth.register',
        'uses' => 'MikeFunk\Bookymark\Auth\AuthController@register',
    )
);

Route::post(
    'auth/register',
    array(
        'as'     => 'auth.do_register',
        'uses'   => 'MikeFunk\Bookymark\Auth\AuthController@doRegister',
        'before' => 'csrf',
    )
);

Route::get(
    'auth/{token}/confirm-registration',
    array(
        'as'     => 'auth.confirm_registration',
        'uses'   => 'MikeFunk\Bookymark\Auth\AuthController@confirmRegistration',
    )
);

Route::get(
    'auth/profile',
    array(
        'as'   => 'auth.profile',
        'uses' => 'MikeFunk\Bookymark\Auth\AuthController@profile',
    )
);

Route::put(
    'auth/profile',
    array(
        'as'     => 'auth.do_profile',
        'uses'   => 'MikeFunk\Bookymark\Auth\AuthController@updateProfile',
        'before' => 'csrf',
    )
);

// ------------------------------------------------------------------------

Route::get(
    'errors/404',
    array(
        'as'   => 'errors.404',
        'uses' => 'MikeFunk\Bookymark\Errors\ErrorController@error404',
    )
);

Route::get(
    'errors/500',
    array(
        'as'   => 'errors.500',
        'uses' => 'MikeFunk\Bookymark\Errors\ErrorController@error500',
    )
);

// ------------------------------------------------------------------------

Route::get(
    '/',
    array(
        'as'   => 'home',
        'uses' => 'MikeFunk\Bookymark\Home\HomeController@index',
    )
);
