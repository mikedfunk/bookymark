<?php
/**
 * @package Bookymark
 * @license MIT License <http://opensource.org/licenses/mit-license.html>
 */
namespace MikeFunk\Bookymark\Interfaces;

/**
 * BookmarkModelInterface
 *
 * @author Michael Funk <mike@mikefunk.com>
 */
interface BookmarkModelInterface
{

    /**
     * doDelete
     *
     * @param int $id
     * @return Bookmark
     */
    public function doDelete($id);

    /**
     * doStore
     *
     * @param array $values
     * @return Bookmark
     */
    public function doStore(array $values);

    /**
     * doUpdate
     *
     * @param array $values
     * @return Bookmark
     */
    public function doUpdate(array $values);

    /**
     * getAll
     *
     * @return Collection
     */
    public function getAll();

    /**
     * getById
     *
     * @param int $id
     * @return Bookmark
     */
    public function getById($id);

    /**
     * getByIdOrFail
     *
     * @param int $id
     * @return Bookmark|Response
     */
    public function getByIdOrFail($id);

    /**
     * getByUserId
     *
     * @param int $user_id
     * @return Bookmark
     */
    public function getByUserId($user_id);
}
