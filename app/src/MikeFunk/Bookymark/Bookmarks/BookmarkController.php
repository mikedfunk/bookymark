<?php
/**
 * @package Bookymark
 * @license MIT License <http://opensource.org/licenses/mit-license.html>
 */
namespace MikeFunk\Bookymark\Bookmarks;

use MikeFunk\Bookymark\Common\BaseController;
use MikeFunk\Bookymark\Interfaces\BookmarkModelInterface;
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
     * @param BookmarkModelInterface $bookmark_model
     */
    public function __construct(
        BookmarkModelInterface $bookmark_model
    ) {
        parent::__construct();
        $this->bookmark_model = $bookmark_model;
    }

    /**
     * index
     *
     * @return View
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $bookmarks = $this->bookmark_model->getByUserId($user_id);
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
        $bookmark = $this->bookmark_model;
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
        $bookmark = $this->bookmark_model->getByIdOrFail($id);

        // ensure the auth user id is the same as the bookmark user_id
        // if not, notify and redirect to the list
        if ($bookmark->user_id != Auth::user()->id) {
            Notification::error(Lang::get('notifications.not_my_bookmark'));
            return Redirect::route('bookmarks.index');
        }

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
        $validator = Validator::make(Input::all(), $this->bookmark_model->rules);
        if ($validator->fails()) {
            Notification::error(Lang::get('notifications.form_error'));
            return Redirect::route('bookmarks.create')->withErrors($validator);
        }

        // set user_id to the logged in user
        $input = Input::all();
        $input['user_id'] = Auth::user()->id;

        // update, notify, and redirect
        $bookmark = $this->bookmark_model->doStore($input);
        Notification::success(Lang::get('notifications.form_success'));
        return Redirect::route('bookmarks.index');
    }
    /**
     * update
     *
     * @param int $id
     * @return Redirect
     */
    public function update($id)
    {
        // get the bookmark for this id
        $bookmark = $this->bookmark_model->getByIdOrFail($id);

        // ensure the auth user id is the same as the bookmark user_id
        // if not, notify and redirect to the list
        if ($bookmark->user_id != Auth::user()->id) {
            Notification::error(Lang::get('notifications.not_my_bookmark'));
            return Redirect::route('bookmarks.index');
        }

        // if validation fails, set notification and redirect
        $validator = Validator::make(Input::all(), $this->bookmark_model->rules);
        if ($validator->fails()) {
            Notification::error(Lang::get('notifications.form_error'));
            return Redirect::route('bookmarks.edit', $id)->withErrors($validator);
        }

        // set user_id to the logged in user
        $input            = Input::all();
        $input['id']      = $id;
        $input['user_id'] = Auth::user()->id;

        // update, notify, and redirect
        $bookmark = $this->bookmark_model->doUpdate($input);
        Notification::success(Lang::get('notifications.form_success'));
        return Redirect::route('bookmarks.index');
    }

    /**
     * delete
     *
     * @param int $id
     * @return Redirect
     */
    public function delete($id)
    {
        // get the bookmark for this id
        $bookmark = $this->bookmark_model->getByIdOrFail($id);

        // ensure the auth user id is the same as the bookmark user_id
        // if not, notify and redirect to the list
        if ($bookmark->user_id != Auth::user()->id) {
            Notification::error(Lang::get('notifications.not_my_bookmark'));
            return Redirect::route('bookmarks.index');
        }

        Notification::success(Lang::get('notifications.form_delete'));
        $this->bookmark_model->doDelete($id);
        return Redirect::route('bookmarks.index');
    }
}
