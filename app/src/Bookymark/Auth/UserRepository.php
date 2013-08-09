<?php
/**
 * @package Bookymark
 * @license MIT License <http://opensource.org/licenses/mit-license.html>
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
     * findByRegisterToken
     *
     * @param string $token
     * @return UserModel|null
     */
    public function findByRegisterToken($token)
    {
        return UserModel::where('register_token', '=', $token)->first();
    }

    /**
     * findByEmail
     *
     * @param string $email
     * @return UserModel|null
     */
    public function findByEmail($email)
    {
        return UserModel::where('email', '=', $email)->first();
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

    /**
     * create
     *
     * @param array $values
     * @return Eloquent
     */
    public function create(array $values)
    {
        return UserModel::create($values);
    }
}
