<?php
/**
 * @package Bookymark
 * @copyright 2013 Xulon Press, Inc. All Rights Reserved.
 */
namespace Bookymark\Tests\Unit;

use Bookymark\Tests\BookymarkTest;
use View;
use Mockery;
use Input;
use Notification;
use Validator;
use Bookymark\Bookmarks\BookmarkModel;

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
    }

    /**
     * testBookmarkIndexOk
     *
     * @return void
     */
    public function testBookmarkIndexOk()
    {
        // call view make on index with the right params
        View::shouldReceive('make')
            ->once()
            ->with('bookmarks.bookmarks_index');

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
        View::shouldReceive('make')
            ->once()
            ->with('bookmarks.bookmarks_form', compact('edit'));

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
        $this->bookmark_model = Mockery::mock('Bookymark\Bookmarks\BookmarkModel');
        $this->bookmark_model->shouldDeferMissing();
        $this->bookmark_repository
            ->shouldReceive('findOrFail')
            ->once()
            ->with('1')
            ->andReturn($this->bookmark_model);

        // bind instance to class
        $namespace = 'Bookymark\Bookmarks\BookmarkRepository';
        $this->app->instance($namespace, $this->bookmark_repository);

        // mock view make
        $bookmark = $this->bookmark_model;
        $edit = true;
        View::shouldReceive('make')
            ->with('bookmarks.bookmarks_form', compact('bookmark', 'edit'))
            ->once();

        // call the route
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
        $values = array('title' => 'test123');
        $this->bookmark_model->id = 99;

        // mock repo store
        $this->bookmark_repository
            ->shouldReceive('store')
            ->once()
            ->with($values)
            ->andReturn($this->bookmark_model);

        // mock notification
        Notification::shouldReceive('success')->once()->with('Record saved.');

        // bind instance to class
        $namespace = 'Bookymark\Bookmarks\BookmarkRepository';
        $this->app->instance($namespace, $this->bookmark_repository);

        // call store
        $this->call('POST', 'bookmarks', $values);
        $this->assertRedirectedToRoute('bookmarks.edit', '99');
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
            ->andReturn('Errors were found.');

        // call
        $this->call('POST', 'bookmarks', $values);

        // ensure redirected with errors
        $this->assertRedirectedToRoute('bookmarks.create');
    }

    /**
     * testBookmarkUpdateOk
     *
     * @return void
     */
    public function testBookmarkUpdateOk()
    {
        // set values, mock model
        $id = '99';
        $values = array(
            'id'    => $id,
            'title' => 'test123',
        );
        $this->bookmark_model->id = $id;

        // mock repo store
        $this->bookmark_repository
            ->shouldReceive('update')
            ->once()
            ->with($values)
            ->andReturn($this->bookmark_model);

        // mock notification
        Notification::shouldReceive('success')->once()->with('Record saved.');

        // bind instance to class
        $namespace = 'Bookymark\Bookmarks\BookmarkRepository';
        $this->app->instance($namespace, $this->bookmark_repository);

        // call update
        $this->call('PUT', 'bookmarks/' . $id, $values);
        $this->assertRedirectedToRoute('bookmarks.edit', $id);

    }

    /**
     * testBookmarkUpdateNoTitle
     *
     * @return void
     */
    public function testBookmarkUpdateNoTitle()
    {
        // set bad values
        $id = '99';
        $values = array('id' => $id);
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
            ->andReturn('Errors were found.');

        // call
        $this->call('PUT', 'bookmarks/' . $id, $values);

        // ensure redirected with errors
        $this->assertRedirectedToRoute('bookmarks.edit', $id);
    }
}
