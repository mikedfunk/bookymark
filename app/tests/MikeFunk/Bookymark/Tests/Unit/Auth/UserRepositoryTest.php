<?php
/**
 * @package Bookymark
 * @license MIT License <http://opensource.org/licenses/mit-license.html>
 */
namespace MikeFunk\Bookymark\Tests\Unit;

use Artisan;
use MikeFunk\Bookymark\Tests\BookymarkTest;
use MikeFunk\Bookymark\Auth\UserModel;
use MikeFunk\Bookymark\Auth\UserRepository;
use Mockery;

/**
 * UserRepositoryTest
 *
 * @author Michael Funk <mfunk@christianpublishing.com>
 */
class UserRepositoryTest extends BookymarkTest
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
        $this->user_repository = new UserRepository;
    }

    /**
     * testAll
     *
     * @return void
     */
    public function testUserAll()
    {
        // set up test records
        $records = array(
            array('email' => 'test1@test.com'),
            array('email' => 'test1@test.com'),
            array('email' => 'test1@test.com'),
        );

        // insert into db
        foreach ($records as $record) {
            UserModel::create($record);
        }

        // get all records, check count
        $expected_count = count($records);
        $actual_count   = $this->user_repository->all()->count();
        $this->assertEquals($expected_count, $actual_count);
    }

    /**
     * testUserFind
     *
     * @return void
     */
    public function testUserFind()
    {
        // create record
        $values = array('email' => 'test1@test.com');
        $user   = UserModel::create($values);

        // find record, ensure it exists
        $found = $this->user_repository->find($user->id);
        $this->assertNotNull($found);
    }

    /**
     * testUserFindOrFail
     *
     * @return void
     */
    public function testUserFindOrFail()
    {
        // create record
        $values = array('email' => 'test1@test.com');
        $user   = UserModel::create($values);

        // find record, ensure it exists
        $found = $this->user_repository->findOrFail($user->id);
        $this->assertNotNull($found);
    }

    /**
     * testUserStore
     *
     * @return void
     */
    public function testUserStore()
    {
        // create record, ensure it got saved
        $values = array('email' => 'test1@test.com');
        $user   = $this->user_repository->store($values);
        $this->assertNotNull($user);
    }

    /**
     * testUserUpdate
     *
     * @return void
     */
    public function testUserUpdate()
    {
        // create record
        $old_values = array(
            'id'    => 1,
            'email' => 'test_old@test.com',
        );
        $user = UserModel::create($old_values);

        // update, ensure successful
        $new_values     = array('id' => 1, 'email' => 'test_new@test.com');
        $new_user       = $this->user_repository->update($new_values);
        $expected_email = $new_values['email'];
        $actual_email   = $new_user->email;
        $this->assertEquals($expected_email, $actual_email);
    }

    /**
     * testUserDelete
     *
     * @return void
     */
    public function testUserDelete()
    {
        // set up test records
        $records = array(
            array('email' => 'test1@test.com'),
            array('email' => 'test1@test.com'),
        );

        // insert into db
        foreach ($records as $record) {
            $user = UserModel::create($record);
        }

        // delete one, check count of all records
        $this->user_repository->delete($user->id);
        $current_count = UserModel::all()->count();
        $old_count     = count($records);
        $this->assertEquals($current_count, $old_count - 1);
    }

    /**
     * testUserFindByRegisterToken
     *
     * @return void
     */
    public function testUserFindByRegisterToken()
    {
        // set up test record
        $values = array(
            'email'          => 'test@test.com',
            'register_token' => 'asd',
        );

        // insert into db
        $user = UserModel::create($values);

        // find by token, ensure 1 result
        $user = $this->user_repository->findByRegisterToken($values['register_token']);
        $this->assertNotNull($user);
    }

    /**
     * testUserFindByEmail
     *
     * @return void
     */
    public function testUserFindByEmail()
    {
        // set up test record, insert into db
        $values = array('email' => 'lfdfd@test.com');
        $user = UserModel::create($values);

        // find by email ensure one result
        $user = $this->user_repository->findByEmail($values['email']);
        $this->assertNotNull($user);
    }

    /**
     * testUserCreate
     *
     * @return void
     */
    public function testUserCreate()
    {
        // set values
        $values = array(
            'email' => 'test@test.com',
        );

        // call create
        $this->user_repository->create($values);

        // ensure 1 row in db
        $actual_count = UserModel::all()->count();
        $this->assertEquals(1, $actual_count);
    }
}
