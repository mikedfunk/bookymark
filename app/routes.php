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
        'as' => 'bookmarks.index',
        'uses' => 'Bookymark\Bookmarks\BookmarkController@index',
    )
);

Route::get(
    'bookmarks/create',
    array(
        'as' => 'bookmarks.create',
        'uses' => 'Bookymark\Bookmarks\BookmarkController@create',
    )
);

Route::get(
    'bookmarks/{id}/edit',
    array(
        'as' => 'bookmarks.edit',
        'uses' => 'Bookymark\Bookmarks\BookmarkController@edit',
    )
);

Route::get(
    'bookmarks/{id}/destroy',
    array(
        'as' => 'bookmarks.destroy',
        'uses' => 'Bookymark\Bookmarks\BookmarkController@destroy',
    )
);

Route::put(
    'bookmarks/{id}',
    array(
        'as' => 'bookmarks.update',
        'uses' => 'Bookymark\Bookmarks\BookmarkController@update',
    )
);

Route::post(
    'bookmarks',
    array(
        'as' => 'bookmarks.store',
        'uses' => 'Bookymark\Bookmarks\BookmarkController@store',
    )
);

Route::get(
    '/',
    array(
        'as' => 'home',
        'uses' => 'Bookymark\Home\HomeController@index',
    )
);
