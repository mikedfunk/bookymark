<?php
/**
 * @package Bookymark
 * @license MIT License <http://opensource.org/licenses/mit-license.html>
 */
namespace MikeFunk\Bookymark\Bookmarks;

use Auth;
use Cache;
use Config;
use Event;

/**
 * BookmarkRepository
 *
 * @author Michael Funk <mfunk@christianpublishing.com>
 */
class BookmarkRepository
{
    /**
     * all
     *
     * @return BookmarkModel
     */
    public function all()
    {
        return BookmarkModel::all();
    }

    /**
     * find
     *
     * @param int $id
     * @return BookmarkModel|null
     */
    public function find($id)
    {
        return BookmarkModel::find($id);
    }

    /**
     * findOrFail
     *
     * @param int $id
     * @return BookmarkModel|Response
     */
    public function findOrFail($id)
    {
        return BookmarkModel::findOrFail($id);
    }

    /**
     * store
     *
     * @return BookmarkModel
     */
    public function store(array $values)
    {
        // instantiate a new bookmark model, insert the passed values, save and
        // return the new model
        $bookmark = new BookmarkModel;
        $bookmark = $this->save($bookmark, $values);
        Event::fire('bookmarks.change');
        return $bookmark;
    }

    /**
     * update
     *
     * @param array $values
     * @return BookmarkModel
     */
    public function update(array $values)
    {
        // instantiate a bookmark model, insert the passed values, save and
        // return the model
        $bookmark = BookmarkModel::find($values['id']);
        $bookmark = $this->save($bookmark, $values);
        Event::fire('bookmarks.change');
        return $bookmark;
    }

    /**
     * save
     *
     * @param BookmarkModel $model
     * @param array $values
     * @return BookmarkModel
     */
    protected function save($model, $values)
    {
        // instantiate a bookmark model, insert the passed values, save and
        // return the model
        $model->fill($values);
        $model->save();
        return $model;
    }

    /**
     * delete
     *
     * @param int $id
     * @return null
     */
    public function delete($id)
    {
        $bookmark = BookmarkModel::find($id)->delete();
        Event::fire('bookmarks.change');
        return $bookmark;
    }

    /**
     * getByUserId
     *
     * @return BookmarkModel
     */
    public function getByUserId($id)
    {
        // get either the cached version or the db version
        return Cache::section($id)
            ->get(
                'bookmarks',
                function () use ($id) {
                    // get the record, put it in the cache, return it
                    $bookmarks = BookmarkModel::where('user_id', '=', $id)
                        ->paginate(Config::get('bookymark.per_page'));
                    Cache::section($id)->put('bookmarks', $bookmarks, 999);
                    return $bookmarks;
                }
            );
    }
}
