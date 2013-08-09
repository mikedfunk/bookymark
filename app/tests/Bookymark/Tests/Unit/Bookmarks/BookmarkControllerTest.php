<?php
/**
 * @package Bookymark
 * @license MIT License <http://opensource.org/licenses/mit-license.html>
 */
namespace Bookymark\Tests\Unit;

use Bookymark\Tests\BookymarkTest;
use View;
use Mockery;
use Input;
use Notification;
use Validator;
use Bookymark\Bookmarks\BookmarkModel;
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
        $this->bookmark_repository = Mockery::mock('Bookymark\Bookmarks\BookmarkRepository');
        $this->bookmark_model      = Mockery::mock('Eloquent', 'Bookymark\Bookmarks\BookmarkModel');
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
        $this->user = Mockery::mock('Bookymark\Auth\UserModel');
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
        $namespace = 'Bookymark\Bookmarks\BookmarkRepository';
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
     * testBookmarkEditOk
     *
     * findOrFail should not be tested here, it's a repository responsibility.
     *
     * @return void
     */
    public function testBookmarkEditOk()
    {
        // mock the repo call
        $this->bookmark_repository
            ->shouldReceive('findOrFail')
            ->once()
            ->with('1')
            ->andReturn($this->bookmark_model);

        // bind instance to class
        $namespace = 'Bookymark\Bookmarks\BookmarkRepository';
        $this->app->instance($namespace, $this->bookmark_repository);

        // call the route
        $bookmark = $this->bookmark_model;
        $edit = true;
        $this->call('GET', 'bookmarks/1/edit');
        $this->assertResponseOk();
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
        $namespace = 'Bookymark\Bookmarks\BookmarkRepository';
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
        $id = 99;
        $user_id = 1;
        return array(
            array(
                // no title
                array(
                    'id'      => $id,
                    'title'   => '',
                    'url'     => 'http://whatever.com',
                    'user_id' => $user_id,
                ),

                // no url
                array(
                    'id'      => $id,
                    'title'   => 'test123',
                    'url'     => '',
                    'user_id' => $user_id,
                ),

                // not a url
                array(
                    'id'      => $id,
                    'title'   => 'test123',
                    'url'     => 'sdf',
                    'user_id' => $user_id,
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
        // set values, mock model
        $values = array(
            'id'      => 99,
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

        // mock notification
        Notification::shouldReceive('success')
            ->once()
            ->with(Lang::get('notifications.form_success'));

        // bind instance to class
        $namespace = 'Bookymark\Bookmarks\BookmarkRepository';
        $this->app->instance($namespace, $this->bookmark_repository);

        // call update
        $this->call('PUT', 'bookmarks/' . $values['id'], $values);
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
        // mock repository method
        $this->bookmark_repository
            ->shouldReceive('delete')
            ->once()
            ->with($this->user->id);

        // bind instance to class
        $namespace = 'Bookymark\Bookmarks\BookmarkRepository';
        $this->app->instance($namespace, $this->bookmark_repository);

        // mock notification
        Notification::shouldReceive('success')
            ->once()
            ->with(Lang::get('notifications.form_delete'));

        // call and verify
        $this->call('GET', 'bookmarks/1/delete');
        $this->assertRedirectedToRoute('bookmarks.index');
    }
}
