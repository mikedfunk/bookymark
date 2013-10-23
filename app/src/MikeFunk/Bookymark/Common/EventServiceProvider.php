<?php
/**
 * @package Bookymark
 * @license MIT License <http://opensource.org/licenses/mit-license.html>
 */
namespace MikeFunk\Bookymark\Common;

use App;
use Auth;
use Cache;
use Event;
use Illuminate\Support\ServiceProvider;

/**
 * EventServiceProvider registers event listeners
 *
 * @author Michael Funk <mike@mikefunk.com>
 */
class EventServiceProvider extends ServiceProvider
{

    /**
     * register
     *
     * @return void
     */
    public function register()
    {
        Event::listen(
            'bookmarks.change',
            function ($bookmark) {
                // on adding or editing a bookmark, delete the cache section
                // for this user
                Cache::section(Auth::user()->id)->flush();
            }
        );
    }
}
