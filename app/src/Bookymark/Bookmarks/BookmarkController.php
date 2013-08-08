<?php
/**
 * @package Bookymark
 * @copyright 2013 Xulon Press, Inc. All Rights Reserved.
 */
namespace Bookymark\Bookmarks;

use Bookymark\Common\BaseController;
use View;
use Input;
use Redirect;
use Notification;
use Validator;
use Lang;
use Auth;

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
        parent::__construct();
        $this->bookmark_repository = $bookmark_repository;
    }

    /**
     * index
     *
     * @return View
     */
    public function index()
    {
        $bookmarks = $this->bookmark_repository->getByUserId(Auth::user()->id);
        return View::make('bookmarks.bookmarks_index', compact('bookmarks'));
    }

    /**
     * create
     *
     * @return View
     */
    public function create()
    {
        // load the view
        $bookmark = new BookmarkModel;
        $edit = false;
        return View::make('bookmarks.bookmarks_form', compact('edit', 'bookmark'));
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
            Notification::error(Lang::get('notifications.form_error'));
            return Redirect::route('bookmarks.create')->withErrors($validator);
        }

        // set user_id to the logged in user
        $input = Input::all();
        $input['user_id'] = Auth::user()->id;

        // update, notify, and redirect
        $bookmark = $this->bookmark_repository->store($input);
        Notification::success(Lang::get('notifications.form_success'));
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
            Notification::error(Lang::get('notifications.form_error'));
            return Redirect::route('bookmarks.edit', $id)->withErrors($validator);
        }

        // set user_id to the logged in user
        $input = Input::all();
        $input['user_id'] = Auth::user()->id;

        // update, notify, and redirect
        $bookmark = $this->bookmark_repository->update(Input::all());
        Notification::success(Lang::get('notifications.form_success'));
        return Redirect::route('bookmarks.edit', $id);
    }

    /**
     * delete
     *
     * @param int $id
     * @return Redirect
     */
    public function delete($id)
    {
        Notification::success(Lang::get('notifications.form_delete'));
        $this->bookmark_repository->delete($id);
        return Redirect::route('bookmarks.index');
    }
}
