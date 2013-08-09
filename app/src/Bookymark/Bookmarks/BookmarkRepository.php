<?php
/**
 * @package Bookymark
 * @license MIT License <http://opensource.org/licenses/mit-license.html>
 */
namespace Bookymark\Bookmarks;

use Config;

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
        return $this->save($bookmark, $values);
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
        return $this->save($bookmark, $values);
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
        return BookmarkModel::find($id)->delete();
    }

    /**
     * getByUserId
     *
     * @return BookmarkModel
     */
    public function getByUserId($id)
    {
        return BookmarkModel::where('user_id', '=', $id)
            ->paginate(Config::get('bookymark.per_page'));
    }
}
