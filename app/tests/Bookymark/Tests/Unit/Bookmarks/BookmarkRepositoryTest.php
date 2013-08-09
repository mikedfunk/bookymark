<?php
/**
 * @package Bookymark
 * @license MIT License <http://opensource.org/licenses/mit-license.html>
 */
namespace Bookymark\Tests\Unit;

use Bookymark\Tests\BookymarkTest;
use Bookymark\Bookmarks\BookmarkModel;
use Bookymark\Bookmarks\BookmarkRepository;
use Artisan;
use Mockery;

/**
 * BookmarkRepositoryTest
 *
 * @author Michael Funk <mfunk@christianpublishing.com>
 */
class BookmarkRepositoryTest extends BookymarkTest
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
        $this->bookmark_repository = new BookmarkRepository;
    }

    /**
     * testAll
     *
     * @return void
     */
    public function testBookmarkAll()
    {
        // set up test records
        $records = array(
            array('title' => 'test1'),
            array('title' => 'test1'),
            array('title' => 'test1'),
        );

        // insert into db
        foreach ($records as $record) {
            BookmarkModel::create($record);
        }

        // get all records, check count
        $expected_count = count($records);
        $actual_count   = $this->bookmark_repository->all()->count();
        $this->assertEquals($expected_count, $actual_count);
    }

    /**
     * testBookmarkFind
     *
     * @return void
     */
    public function testBookmarkFind()
    {
        // create record
        $values   = array('title' => 'test1');
        $bookmark = BookmarkModel::create($values);

        // find record, ensure it exists
        $found = $this->bookmark_repository->find($bookmark->id);
        $this->assertNotNull($found);
    }

    /**
     * testBookmarkFindOrFail
     *
     * @return void
     */
    public function testBookmarkFindOrFail()
    {
        // create record
        $values   = array('title' => 'test1');
        $bookmark = BookmarkModel::create($values);

        // find record, ensure it exists
        $found = $this->bookmark_repository->findOrFail($bookmark->id);
        $this->assertNotNull($found);
    }

    /**
     * testBookmarkStore
     *
     * @return void
     */
    public function testBookmarkStore()
    {
        // create record, ensure it got saved
        $values   = array('title' => 'test1');
        $bookmark = $this->bookmark_repository->store($values);
        $this->assertNotNull($bookmark);
    }

    /**
     * testBookmarkUpdate
     *
     * @return void
     */
    public function testBookmarkUpdate()
    {
        // create record
        $old_values = array(
            'id'    => 1,
            'title' => 'test_old',
        );
        $bookmark = BookmarkModel::create($old_values);

        // update, ensure successful
        $new_values     = array('id' => 1, 'title' => 'test_new');
        $new_bookmark   = $this->bookmark_repository->update($new_values);
        $expected_title = $new_values['title'];
        $actual_title   = $new_bookmark->title;
        $this->assertEquals($expected_title, $actual_title);
    }

    /**
     * testBookmarkDelete
     *
     * @return void
     */
    public function testBookmarkDelete()
    {
        // set up test records
        $records = array(
            array('title' => 'test1'),
            array('title' => 'test1'),
        );

        // insert into db
        foreach ($records as $record) {
            $bookmark = BookmarkModel::create($record);
        }

        // delete one, check count of all records
        $this->bookmark_repository->delete($bookmark->id);
        $current_count = BookmarkModel::all()->count();
        $old_count     = count($records);
        $this->assertEquals($current_count, $old_count - 1);
    }

    /**
     * testGetByUserId
     *
     * @return void
     */
    public function testGetByUserId()
    {
        // set up test records
        $records = array(
            array('user_id' => '1'),
            array('user_id' => '2'),
        );

        // insert into db
        foreach ($records as $record) {
            BookmarkModel::create($record);
        }

        // get by user id, ensure count is one
        $bookmarks = $this->bookmark_repository->getByUserId('2');
        $this->assertEquals(1, $bookmarks->count());
    }
}
