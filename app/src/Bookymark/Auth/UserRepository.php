<?php
/**
 * @package Bookymark
 * @copyright 2013 Xulon Press, Inc. All Rights Reserved.
 */
namespace Bookymark\Auth;

/**
 * UserRepository
 *
 * @author Michael Funk <mfunk@christianpublishing.com>
 */
class UserRepository
{
    /**
     * all
     *
     * @return UserModel
     */
    public function all()
    {
        return UserModel::all();
    }

    /**
     * find
     *
     * @param int $id
     * @return UserModel|null
     */
    public function find($id)
    {
        return UserModel::find($id);
    }

    /**
     * findOrFail
     *
     * @param int $id
     * @return UserModel|Response
     */
    public function findOrFail($id)
    {
        return UserModel::findOrFail($id);
    }

    /**
     * store
     *
     * @return UserModel
     */
    public function store(array $values)
    {
        // instantiate a new user model, insert the passed values, save and
        // return the new model
        $user = new UserModel;
        return $this->save($user, $values);
    }

    /**
     * update
     *
     * @param array $values
     * @return UserModel
     */
    public function update(array $values)
    {
        // instantiate a user model, insert the passed values, save and
        // return the model
        $user = UserModel::find($values['id']);
        return $this->save($user, $values);
    }

    /**
     * save
     *
     * @param UserModel $model
     * @param array $values
     * @return UserModel
     */
    protected function save($model, $values)
    {
        // instantiate a user model, insert the passed values, save and
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
        return UserModel::find($id)->delete();
    }
}
