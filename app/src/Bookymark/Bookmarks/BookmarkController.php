<?php
/**
 * @package Bookymark
 * @copyright 2013 Xulon Press, Inc. All Rights Reserved.
 */
namespace Bookymark\Bookmarks;

use BaseController;
use View;
use Input;
use Redirect;
use Notification;
use Validator;

/**
 * test all bookmark controllers
 *
 * @author Michael Funk <mfunk@christianpublishing.com>
 */
class BookmarkController extends BaseController
{
    /**
     * dependency injection
     *
     * @param BookmarkRepository $bookmark_repository
     */
    public function __construct(
        BookmarkRepository $bookmark_repository
    ) {
        $this->bookmark_repository = $bookmark_repository;
    }

    /**
     * index
     *
     * @return View
     */
    public function index()
    {
        return View::make('bookmarks.bookmarks_index');
    }

    /**
     * create
     *
     * @return View
     */
    public function create()
    {
        // load the view
        $edit = false;
        return View::make('bookmarks.bookmarks_form', compact('edit'));
    }

    /**
     * edit
     *
     * @param int $id
     * @return View
     */
    public function edit($id)
    {
        // get the record, send it to the view
        $edit = true;
        $bookmark = $this->bookmark_repository->findOrFail($id);
        return View::make('bookmarks.bookmarks_form', compact('bookmark', 'edit'));
    }

    /**
     * store
     *
     * @return Redirect
     */
    public function store()
    {
        // if validation fails, set notification and redirect
        $validator = Validator::make(Input::all(), BookmarkModel::$rules);
        if ($validator->fails()) {
            Notification::error('Errors were found.');
            return Redirect::route('bookmarks.create');
        }

        // else update, notify, and redirect
        $bookmark = $this->bookmark_repository->store(Input::all());
        Notification::success('Record saved.');
        return Redirect::route('bookmarks.edit', $bookmark->id);
    }
    /**
     * update
     *
     * @param int $id
     * @return Redirect
     */
    public function update($id)
    {
        // if validation fails, set notification and redirect
        $validator = Validator::make(Input::all(), BookmarkModel::$rules);
        if ($validator->fails()) {
            Notification::error('Errors were found.');
            return Redirect::route('bookmarks.edit', $id);
        }

        // else update, notify, and redirect
        $bookmark = $this->bookmark_repository->update(Input::all());
        Notification::success('Record saved.');
        return Redirect::route('bookmarks.edit', $id);
    }
}
