<?php
/**
 * @package Bookymark
 * @license MIT License <http://opensource.org/licenses/mit-license.html>
 */
namespace MikeFunk\Bookymark\Tests\Unit\Bookmarks;

use Auth;
use Cache;
use Event;
use MikeFunk\Bookymark\Tests\BookymarkTest;
use MikeFunk\Bookymark\Auth\UserModel;
use Mockery;

/**
 * BookmarkEventTest
 *
 * @author Michael Funk <mike@mikefunk.com>
 */
class BookmarkEventTest extends BookymarkTest
{

    /**
     * testBookmarkChangeEventListener
     *
     * @return void
     */
    public function testBookmarkChangeEventListener()
    {
        // fake login
        $user = Mockery::mock('Illuminate\Auth\UserInterface');
        $user->id = 1;
        $user->email = 'test@test.com';
        $this->be($user);

        // assert methods called
        $cache = Mockery::mock();
        $cache->shouldReceive('flush')->once();
        Cache::shouldReceive('section')
            ->once()
            ->with(Auth::user()->id)
            ->andReturn($cache);

        // fire event, ensure the listener does stuff
        Event::fire('bookmarks.change');
    }
}
