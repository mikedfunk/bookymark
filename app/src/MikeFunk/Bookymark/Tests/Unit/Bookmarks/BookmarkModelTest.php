<?php
/**
 * @package Bookymark
 * @license MIT License <http://opensource.org/licenses/mit-license.html>
 */
namespace MikeFunk\Bookymark\Tests\Unit\Bookmarks;

use App;
use Artisan;
use Auth;
use Event;
use MikeFunk\Bookymark\Auth\UserModel;
use MikeFunk\Bookymark\Bookmarks\Bookmark as BookmarkModel;
use MikeFunk\Bookymark\Tests\BookymarkTest;
use Mockery;

/**
 * BookmarkModelTest
 *
 * @author Michael Funk <mfunk@christianpublishing.com>
 */
class BookmarkModelTest extends BookymarkTest
{

    /**
     * setUp
     *
     * @return void
     */
    public function setUp()
    {
        // migrate and set repo
        parent::setUp();
        Artisan::call('migrate');
        $this->bookmark_model = $this->getBookmarkModel();

        // fake login
        $user = App::make('MikeFunk\Bookymark\Interfaces\UserModelInterface');
        $user->id = 1;
        $user->email = 'test@test.com';
        $this->be($user);
    }

    /**
     * getBookmarkModel
     *
     * @return BookmarkModelInterface
     */
    public function getBookmarkModel()
    {
        return App::make('MikeFunk\Bookymark\Interfaces\BookmarkModelInterface');
    }

    /**
     * testBookmarkModelGetAll
     *
     * @return void
     */
    public function testBookmarkModelGetAll()
    {
        // set up test records
        $records = [
            ['title' => 'a', 'url' => 'http://a.com', 'user_id' => 1],
            ['title' => 'a', 'url' => 'http://a.com', 'user_id' => 1],
            ['title' => 'a', 'url' => 'http://a.com', 'user_id' => 1],
        ];

        // insert into db
        foreach ($records as $record) {
            $this->bookmark_model->create($record);
        }

        // get all records, check count
        $expected_count = count($records);
        $actual_count   = $this->bookmark_model->getAll()->count();
        $this->assertEquals($expected_count, $actual_count);
    }

    /**
     * testBookmarkModelGetById
     *
     * @return void
     */
    public function testBookmarkModelGetById()
    {
        // create record
        $values = ['title' => 'a', 'url' => 'http://a.com', 'user_id' => 1];
        $bookmark = $this->bookmark_model->create($values);

        // find record, ensure it exists
        $found = $this->bookmark_model->getById($bookmark->id);
        $this->assertNotNull($found);
    }

    /**
     * testBookmarkGetByIdOrFail
     *
     * @return void
     */
    public function testBookmarkGetByIdOrFail()
    {
        // create record
        $values = ['title' => 'a', 'url' => 'http://a.com', 'user_id' => 1];
        $bookmark = BookmarkModel::create($values);

        // get_by_id record, ensure it exists
        $found = $this->bookmark_model->getByIdOrFail($bookmark->id);
        $this->assertNotNull($found);
    }

    /**
     * testBookmarkModelDoStoreSuccess
     *
     * @return void
     */
    public function testBookmarkModelDoStoreSuccess()
    {
        // mock event firing, create record, ensure it got saved
        Event::shouldReceive('fire')->once();
        $values = ['title' => 'a', 'url' => 'http://a.com', 'user_id' => 1];
        $bookmark = $this->bookmark_model->doStore($values);

        // check result
        $this->assertNotNull($this->bookmark_model->where('id', $bookmark->id));
    }

    /**
     * testBookmarkModelDoUpdateSuccess
     *
     * @return void
     */
    public function testBookmarkModelDoUpdateSuccess()
    {
        // mock event firing, create record
        Event::shouldReceive('fire')->once();
        $old_values = ['id' => 1, 'title' => 'test_old', 'url' => 'http://a.com', 'user_id' => 1];
        $bookmark = $this->bookmark_model->create($old_values);

        // update, ensure successful
        $new_values = ['id' => 1, 'title' => 'test_new', 'url' => 'http://a.com', 'user_id' => 1];
        $new_bookmark   = $this->bookmark_model->doUpdate($new_values);
        $expected_title = $new_values['title'];
        $actual_title   = $new_bookmark->title;
        $this->assertequals($expected_title, $actual_title);
    }

    /**
     * testBookmarkModelDoUpdateFailNoId
     *
     * @expectedException UnexpectedValueException
     * @return void
     */
    public function testBookmarkModelDoUpdateFailNoId()
    {
        // create test bookmark
        $old_values = ['id' => 1, 'title' => 'test_old', 'url' => 'http://a.com', 'user_id' => 1];
        $bookmark = $this->bookmark_model->create($old_values);

        // update, expect exception
        $new_values = ['title' => 'test_new', 'url' => 'http://a.com', 'user_id' => 1];
        $this->bookmark_model->doUpdate($new_values);
    }

    /**
     * testBookmarkModelDoUpdateFailNotFound
     *
     * @expectedException Exception
     * @return void
     */
    public function testBookmarkModelDoUpdateFailNotFound()
    {
        // update, ensure successful
        $new_values = ['id' => '48291', 'title' => 'test_new', 'url' => 'http://a.com', 'user_id' => 1];
        $this->bookmark_model->doUpdate($new_values);
    }

    /**
     * testBookmarkModelDoDelete
     *
     * @return void
     */
    public function testBookmarkModelDoDelete()
    {
        // mock event firing, set up test record
        Event::shouldReceive('fire')->once();
        $records = array(
            ['title' => 'a', 'url' => 'http://a.com', 'user_id' => 1],
            ['title' => 'a', 'url' => 'http://a.com', 'user_id' => 1],
        );

        // insert into db
        foreach ($records as $record) {
            $bookmark = $this->bookmark_model->create($record);
        }

        // delete one, check count of all records
        $this->bookmark_model->doDelete($bookmark->id);
        $current_count = $this->bookmark_model->all()->count();
        $old_count     = count($records);
        $this->assertEquals($current_count, $old_count - 1);
    }

    /**
     * testBookmarkModelGetByUserId
     *
     * @return void
     */
    public function testBookmarkModelGetByUserId()
    {
        // set up test records
        $records = array(
            ['title' => 'a', 'url' => 'http://a.com', 'user_id' => 1],
            ['title' => 'a', 'url' => 'http://a.com', 'user_id' => 2],
        );

        // insert into db
        foreach ($records as $record) {
            $this->bookmark_model->create($record);
        }

        // get by user id, ensure count is one
        $bookmarks = $this->bookmark_model->getByUserId('2');
        $this->assertEquals(1, $bookmarks->count());
    }
}
