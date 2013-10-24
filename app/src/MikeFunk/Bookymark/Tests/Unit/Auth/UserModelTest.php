<?php
/**
 * @package Bookymark
 * @license MIT License <http://opensource.org/licenses/mit-license.html>
 */
namespace MikeFunk\Bookymark\Tests\Unit\Auth;

use Artisan;
use MikeFunk\Bookymark\Tests\BookymarkTest;
use MikeFunk\Bookymark\Auth\User as UserModel;
use Mockery;

/**
 * UserModelTest
 *
 * @author Michael Funk <mfunk@christianpublishing.com>
 */
class UserModelTest extends BookymarkTest
{

    /**
     * setUp
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        Artisan::call('migrate');
        $this->user_model = new UserModel;
    }

    /**
     * testUserModelGetAll
     *
     * @return void
     */
    public function testUserModelGetAll()
    {
        // set up test records
        $records = [
            ['email' => 'a@a.a', 'password' => 'a'],
            ['email' => 'a@a.a', 'password' => 'a'],
            ['email' => 'a@a.a', 'password' => 'a'],
        ];

        // insert into db
        foreach ($records as $record) {
            UserModel::create($record);
        }

        // get all records, check count
        $expected_count = count($records);
        $actual_count   = $this->user_model->getAll()->count();
        $this->assertEquals($expected_count, $actual_count);
    }

    /**
     * testUserModelGetById
     *
     * @return void
     */
    public function testUserModelGetById()
    {
        // create record
        $values = ['email' => 'a@a.a', 'password' => 'a'];
        $user   = UserModel::create($values);

        // find record, ensure it exists
        $found = $this->user_model->getById($user->id);
        $this->assertNotNull($found);
    }

    /**
     * testUserModelGetByIdOrFail
     *
     * @return void
     */
    public function testUserModelGetByIdOrFail()
    {
        // create record
        $values = ['email' => 'a@a.a', 'password' => 'a'];
        $user   = UserModel::create($values);

        // find record, ensure it exists
        $found = $this->user_model->getByIdOrFail($user->id);
        $this->assertNotNull($found);
    }

    /**
     * testUserModelDoStore
     *
     * @return void
     */
    public function testUserModelDoStore()
    {
        // create record, ensure it got saved
        $values = ['email' => 'a@a.a', 'password' => 'a'];
        $user   = $this->user_model->doStore($values);
        $this->assertNotNull($user);
    }

    /**
     * testUserModelDoUpdate
     *
     * @return void
     */
    public function testUserModelDoUpdate()
    {
        // create record
        $old_values = ['id' => 1, 'email' => 'a@a.a', 'password' => 'a'];
        $user = UserModel::create($old_values);

        // update, ensure successful
        $new_values = ['id' => 1, 'email' => 'b@b.b', 'password' => 'a'];
        $this->user_model->doUpdate($new_values);

        $new_user       = UserModel::find(1);
        $expected_email = $new_values['email'];
        $actual_email   = $new_user->email;
        $this->assertEquals($expected_email, $actual_email);
    }

    /**
     * testUserModelDoUpdateFailNoId
     *
     * @expectedException UnexpectedValueException
     * @return void
     */
    public function testUserModelDoUpdateFailNoId()
    {
        // create test user
        $old_values = ['id' => 1, 'email' => 'a@a.a', 'password' => 'a'];
        $user = UserModel::create($old_values);

        // update, expect exception
        $new_values = ['email' => 'a@a.a', 'password' => 'a'];
        $this->user_model->doUpdate($new_values);
    }

    /**
     * testUserModelDoUpdateFailNotFound
     *
     * @expectedException Exception
     * @return void
     */
    public function testUserModelDoUpdateFailNotFound()
    {
        // update, ensure successful
        $new_values = ['id' => 3053, 'email' => 'a@a.a', 'password' => 'a'];
        $this->user_model->doUpdate($new_values);
    }

    /**
     * testUserModelDoDelete
     *
     * @return void
     */
    public function testUserModelDoDelete()
    {
        // set up test records
        $records = array(
            ['email' => 'a@a.a', 'password' => 'a'],
            ['email' => 'a@a.a', 'password' => 'a'],
        );


        // insert into db
        foreach ($records as $record) {
            $user = UserModel::create($record);
        }

        // delete one, check count of all records
        $this->user_model->doDelete($user->id);
        $current_count = UserModel::all()->count();
        $old_count     = count($records);
        $this->assertEquals($current_count, $old_count - 1);
    }

    /**
     * testUserModelGetByRegisterToken
     *
     * @return void
     */
    public function testUserModelGetByRegisterToken()
    {
        // set up test record
        $values = ['email' => 'a@a.a', 'password' => 'a', 'register_token' => 'asd'];

        // insert into db
        $user = UserModel::create($values);

        // find by token, ensure 1 result
        $user = $this->user_model->getByRegisterToken($values['register_token']);
        $this->assertNotNull($user);
    }

    /**
     * testUserModelGetByEmail
     *
     * @return void
     */
    public function testUserModelGetByEmail()
    {
        // set up test record, insert into db
        $values = ['email' => 'za@a.a', 'password' => 'a'];
        $user = UserModel::create($values);

        // find by email ensure one result
        $user = $this->user_model->getByEmail($values['email']);
        $this->assertNotNull($user);
    }
}
