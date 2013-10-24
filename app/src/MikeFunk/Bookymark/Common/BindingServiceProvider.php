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
 * BindingServiceProvider registers event listeners
 *
 * @author Michael Funk <mike@mikefunk.com>
 */
class BindingServiceProvider extends ServiceProvider
{

    /**
     * register
     *
     * @return void
     */
    public function register()
    {
        App::bind(
            'MikeFunk\Bookymark\Interfaces\BookmarkModelInterface',
            'MikeFunk\Bookymark\Bookmarks\Bookmark'
        );
        App::bind(
            'MikeFunk\Bookymark\Interfaces\UserModelInterface',
            'MikeFunk\Bookymark\Auth\User'
        );
    }
}
