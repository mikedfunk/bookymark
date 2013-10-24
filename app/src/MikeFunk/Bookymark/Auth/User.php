<?php
/**
 * @package Bookymark
 * @license MIT License <http://opensource.org/licenses/mit-license.html>
 */
namespace MikeFunk\Bookymark\Auth;

use MikeFunk\Bookymark\Interfaces\UserModelInterface;
use User as LaravelUser;
use Illuminate\Auth\UserInterface as LaravelUserInterface;

/**
 * UserModel
 *
 * @author Michael Funk <mfunk@christianpublishing.com>
 */
class User extends LaravelUser implements UserModelInterface, LaravelUserInterface
{

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'password',
        'register_token',
    ];

    /**
     * doDelete
     *
     * @param int $id
     * @return User
     */
    public function doDelete($id)
    {
        // delete and return deleted user
        // @TODO throw exception on user not found
        $user = self::find($id)->delete();
        return $user;
    }

    /**
     * doStore
     *
     * @param array $values
     * @return User
     */
    public function doStore(array $values)
    {
        // instantiate a new user model, insert the passed values, save and
        // return the new model
        return self::create($values);
    }

    /**
     * doUpdate
     *
     * @param array $values
     * @return User
     */
    public function doUpdate(array $values)
    {
        // ensure the id is set
        if (!isset($values['id'])) {
            throw new \UnexpectedValueException('"id" not set in values array.');
        }
        // instantiate a user model, insert the passed values, save and
        // return the model
        $user = self::find($values['id']);

        // check for existence of user
        if (!$user) {
            throw new \Exception('Item not found. Update not possible.');
        }
        // fill model, save it, and return the filled model
        $user = $user->fill($values);
        $user->save();
        return $user;
    }

    /**
     * getAll
     *
     * @return Collection
     */
    public function getAll()
    {
        return self::all();
    }

    /**
     * getById
     *
     * @param int $id
     * @return User
     */
    public function getById($id)
    {
        return self::find($id);
    }

    /**
     * getByIdOrFail
     *
     * @param int $id
     * @return User|Response
     */
    public function getByIdOrFail($id)
    {
        return self::findOrFail($id);
    }

    /**
     * getByRegisterToken
     *
     * @param string $token
     * @return User|null
     */
    public function getByRegisterToken($token)
    {
        return self::where('register_token', '=', $token)->first();
    }

    /**
     * getByEmail
     *
     * @param string $email
     * @return UserModel|null
     */
    public function getByEmail($email)
    {
        return self::where('email', '=', $email)->first();
    }
}
