<?php
/**
 * @package Bookymark
 * @license MIT License <http://opensource.org/licenses/mit-license.html>
 */
namespace MikeFunk\Bookymark\Interfaces;

/**
 * UserModelInterface
 *
 * @author Michael Funk <mike@mikefunk.com>
 */
interface UserModelInterface
{

    /**
     * doDelete
     *
     * @param int $id
     * @return User
     */
    public function doDelete($id);

    /**
     * doStore
     *
     * @param array $values
     * @return User
     */
    public function doStore(array $values);

    /**
     * doUpdate
     *
     * @param array $values
     * @return User
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
     * @return User
     */
    public function getById($id);

    /**
     * getByIdOrFail
     *
     * @param int $id
     * @return User|Response
     */
    public function getByIdOrFail($id);
}
