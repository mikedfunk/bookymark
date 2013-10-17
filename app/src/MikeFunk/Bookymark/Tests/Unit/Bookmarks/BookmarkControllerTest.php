<?php
/**
 * @package Bookymark
 * @license MIT License <http://opensource.org/licenses/mit-license.html>
 */
namespace MikeFunk\Bookymark\Tests\Unit\Bookmarks;

use MikeFunk\Bookymark\Tests\BookymarkTest;
use View;
use Mockery;
use Input;
use Notification;
use Validator;
use MikeFunk\Bookymark\Bookmarks\BookmarkModel;
use Auth;
use Lang;
use Illuminate\Support\Collection;

/**
 * test all bookmark controller methods
 *
 * @author Michael Funk <mfunk@christianpublishing.com>
 */
class BookmarkControllerTest extends BookymarkTest
{
    /**
     * setUp
     *
     * @return void
     */
    public function setUp()
    {
        // reuse these mocks for tests below
        parent::setUp();
        $this->bookmark_repository = Mockery::mock('MikeFunk\Bookymark\Bookmarks\BookmarkRepository');
        $this->bookmark_model      = Mockery::mock('Eloquent', 'MikeFunk\Bookymark\Bookmarks\BookmarkModel');
        $this->bookmark_model->shouldDeferMissing();

        // fill model to make views happy
        $values = array(
            'id'          => 1,
            'title'       => 'adf',
            'url'         => 'http://sdfd.dsf',
            'description' => 'asdfdf',
        );
        $this->bookmark_model->fill($values);

        // mock collection
        $this->bookmark_collection = Mockery::mock('Illuminate\Support\Collection');
        $this->bookmark_collection->shouldDeferMissing();
        $this->bookmark_collection->shouldReceive('links');
        for ($i = 1; $i < 20; $i++) {
            $this->bookmark_collection[] = $this->bookmark_model;
        }

        // fake login as user
        $this->user = Mockery::mock('MikeFunk\Bookymark\Auth\UserModel');
        $this->user->shouldDeferMissing();
        $this->user->id = 1;
        $this->be($this->user);
    }

    /**
     * testBookmarkIndexOk
     *
     * @return void
     */
    public function testBookmarkIndexOk()
    {
        $this->bookmark_repository
            ->shouldReceive('getByUserId')
            ->once()
            ->with($this->user->id)
            ->andReturn($this->bookmark_collection);

        // bind instance to class
        $namespace = 'MikeFunk\Bookymark\Bookmarks\BookmarkRepository';
        $this->app->instance($namespace, $this->bookmark_repository);

        $this->call('GET', 'bookmarks');
        $this->assertResponseOk();
    }

    /**
     * testBookmarkCreateOk
     *
     * @return void
     */
    public function testBookmarkCreateOk()
    {
        // call view make on index with the right params
        $edit = false;
        $this->call('GET', 'bookmarks/create');
        $this->assertResponseOk();
    }

    /**
     * This is called in the filter for edit and update. By default it should
     * return the same user_id as the auth user. But we need to ensure it fails
     * when it should too.
     *
     * @param int $user_id
     * @param int $id (default: 1)
     * @return void
     */
    private function mockMyBookmarkFilter($user_id = 1, $id = 1)
    {
        $this->bookmark_model['user_id'] = $user_id;
        $this->bookmark_repository
            ->shouldReceive('findOrFail')
            ->once()
            ->with($id)
            ->andReturn($this->bookmark_model);
    }

    /**
     * testBookmarkEditOk
     *
     * findOrFail should not be tested here, it's a repository responsibility.
     *
     * @return void
     */
    public function testBookmarkEditOk()
    {
        $this->mockMyBookmarkFilter();

        // bind instance to class
        $namespace = 'MikeFunk\Bookymark\Bookmarks\BookmarkRepository';
        $this->app->instance($namespace, $this->bookmark_repository);

        // call the route
        $bookmark = $this->bookmark_model;
        $edit = true;
        $this->call('GET', 'bookmarks/1/edit');
        $this->assertResponseOk();
    }

    /**
     * testBookmarkEditFailMyBookmarkFilter
     *
     * @return void
     */
    public function testBookmarkEditFailMyBookmarkFilter()
    {
        // uh oh, the bookmark user id is different from the logged in user
        $this->mockMyBookmarkFilter('99');

        // bind instance to class
        $namespace = 'MikeFunk\Bookymark\Bookmarks\BookmarkRepository';
        $this->app->instance($namespace, $this->bookmark_repository);

        // mock notification
        Notification::shouldReceive('error')
            ->once()
            ->with(Lang::get('notifications.not_my_bookmark'));

        // call and check redirect
        $this->call('GET', 'bookmarks/1/edit');
        $this->assertRedirectedToRoute('bookmarks.index');
    }

    /**
     * testBookmarkStoreOk
     *
     * @return void
     */
    public function testBookmarkStoreOk()
    {
        // set values, mock model
        $values = array(
            'title'   => 'test123',
            'url'     => 'http://whatever.com',
            'user_id' => $this->user->id,
        );
        $this->bookmark_model->id = 99;

        // mock repo store
        $this->bookmark_repository
            ->shouldReceive('store')
            ->once()
            ->with($values)
            ->andReturn($this->bookmark_model);

        // mock notification
        Notification::shouldReceive('success')
            ->once()
            ->with(Lang::get('notifications.form_success'));

        // bind instance to class
        $namespace = 'MikeFunk\Bookymark\Bookmarks\BookmarkRepository';
        $this->app->instance($namespace, $this->bookmark_repository);

        // call store
        $this->call('POST', 'bookmarks', $values);
        $this->assertRedirectedToRoute('bookmarks.index');
    }

    /**
     * testBookmarkStoreNoTitle
     *
     * @return void
     */
    public function testBookmarkStoreNoTitle()
    {
        // set bad values
        $values = array();
        $rules  = BookmarkModel::$rules;

        // mock validator instance
        $validator = Mockery::mock();
        $validator
            ->shouldReceive('fails')
            ->once()
            ->andReturn(true);

        // mock validation
        Validator::shouldReceive('make')
            ->once()
            ->with($values, $rules)
            ->andReturn($validator);

        // mock notification
        Notification::shouldReceive('error')
            ->once()
            ->andReturn(Lang::get('notifications.form_error'));

        // call
        $this->call('POST', 'bookmarks', $values);

        // ensure redirected with errors
        $this->assertRedirectedToRoute('bookmarks.create');
    }

    /**
     * bookmarkDataProvider
     *
     * @return array
     */
    public function bookmarkDataProvider()
    {
        $id = 1;
        return array(
            array(
                // no title
                array(
                    'id'      => $id,
                    'title'   => '',
                    'url'     => 'http://whatever.com',
                ),

                // no url
                array(
                    'id'      => $id,
                    'title'   => 'test123',
                    'url'     => '',
                ),

                // not a url
                array(
                    'id'      => $id,
                    'title'   => 'test123',
                    'url'     => 'sdf',
                ),
            ),
        );
    }

    /**
     * testBookmarkUpdateOk
     *
     * @return void
     */
    public function testBookmarkUpdateOk()
    {
        $this->mockMyBookmarkFilter();

        // set values, mock model
        $values = array(
            'id'      => 1,
            'title'   => 'test123',
            'url'     => 'http://whatever.com',
            'user_id' => $this->user->id,
        );
        $this->bookmark_model->id = $values['id'];

        // mock repo store
        $this->bookmark_repository
            ->shouldReceive('update')
            ->once()
            ->with($values)
            ->andReturn($this->bookmark_model);

        // bind instance to class
        $namespace = 'MikeFunk\Bookymark\Bookmarks\BookmarkRepository';
        $this->app->instance($namespace, $this->bookmark_repository);

        // mock notification
        Notification::shouldReceive('success')
            ->once()
            ->with(Lang::get('notifications.form_success'));

        // bind instance to class
        $namespace = 'MikeFunk\Bookymark\Bookmarks\BookmarkRepository';
        $this->app->instance($namespace, $this->bookmark_repository);

        // call update
        $this->call('PUT', 'bookmarks/' . $values['id'], $values);
        $this->assertRedirectedToRoute('bookmarks.index');
    }

    /**
     * testBookmarkUpdateFailMyBookmarkFilter
     *
     * @return void
     */
    public function testBookmarkUpdateFailMyBookmarkFilter()
    {
        // uh oh, the bookmark user id is different from the logged in user
        $this->mockMyBookmarkFilter(99);

        // bind instance to class
        $namespace = 'MikeFunk\Bookymark\Bookmarks\BookmarkRepository';
        $this->app->instance($namespace, $this->bookmark_repository);

        // mock notification
        Notification::shouldReceive('error')
            ->once()
            ->with(Lang::get('notifications.not_my_bookmark'));

        $bookmark = $this->bookmark_model;

        // call and check redirect
        $this->call('PUT', 'bookmarks/1', compact('bookmark'));
        $this->assertRedirectedToRoute('bookmarks.index');
    }

    /**
     * testBookmarkUpdateFailValidation
     *
     * @dataProvider bookmarkDataProvider
     * @param array $values comes from the data provider
     * @return void
     */
    public function testBookmarkUpdateFailValidation($values)
    {
        $this->mockMyBookmarkFilter();

        // bind instance to class
        $namespace = 'MikeFunk\Bookymark\Bookmarks\BookmarkRepository';
        $this->app->instance($namespace, $this->bookmark_repository);

        // set bad values
        $rules = BookmarkModel::$rules;

        // mock validator instance
        $validator = Mockery::mock();
        $validator
            ->shouldReceive('fails')
            ->once()
            ->andReturn(true);

        // mock validation
        Validator::shouldReceive('make')
            ->once()
            ->with($values, $rules)
            ->andReturn($validator);

        // mock notification
        Notification::shouldReceive('error')
            ->once()
            ->with(Lang::get('notifications.form_error'));

        // call
        $this->call('PUT', 'bookmarks/' . $values['id'], $values);

        // ensure redirected with errors
        $this->assertRedirectedToRoute('bookmarks.edit', $values['id']);
    }

    /**
     * testBookmarkDelete
     *
     * @return void
     */
    public function testBookmarkDelete()
    {
        $this->mockMyBookmarkFilter();

        // mock repository method
        $this->bookmark_repository
            ->shouldReceive('delete')
            ->once()
            ->with($this->user->id);

        // bind instance to class
        $namespace = 'MikeFunk\Bookymark\Bookmarks\BookmarkRepository';
        $this->app->instance($namespace, $this->bookmark_repository);

        // mock notification
        Notification::shouldReceive('success')
            ->once()
            ->with(Lang::get('notifications.form_delete'));

        // call and verify
        $this->call('GET', 'bookmarks/1/delete');
        $this->assertRedirectedToRoute('bookmarks.index');
    }

    /**
     * testBookmarkDeleteFailMyBookmarkFilter
     *
     * @return void
     */
    public function testBookmarkDeleteFailMyBookmarkFilter()
    {
        // uh oh, the bookmark user id is different from the logged in user
        $this->mockMyBookmarkFilter(8878);

        // bind instance to class
        $namespace = 'MikeFunk\Bookymark\Bookmarks\BookmarkRepository';
        $this->app->instance($namespace, $this->bookmark_repository);

        // mock notification
        Notification::shouldReceive('error')
            ->once()
            ->with(Lang::get('notifications.not_my_bookmark'));

        $bookmark = $this->bookmark_model;

        // call and check redirect
        $this->call('GET', 'bookmarks/1/delete');
        $this->assertRedirectedToRoute('bookmarks.index');
    }
}
