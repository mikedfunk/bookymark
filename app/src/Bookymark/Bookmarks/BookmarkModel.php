<?php
/**
 * @package Bookymark
 * @copyright 2013 Xulon Press, Inc. All Rights Reserved.
 */
namespace Bookymark\Bookmarks;

use Eloquent;

/**
 * BookmarkModel
 *
 * @author Michael Funk <mfunk@christianpublishing.com>
 */
class BookmarkModel extends Eloquent
{
    /**
     * table
     *
     * @var string
     */
    protected $table = 'bookmarks';

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = array(
        'id',
        'title',
        'description',
        'url',
        'user_id',
    );

    /**
     * validation rules
     *
     * @var array
     */
    public static $rules = array(
        'title' => 'required',
        'url'   => 'required|url',
    );
}
