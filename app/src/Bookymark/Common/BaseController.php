<?php
/**
 * @package Bookymark
 * @license MIT License <http://opensource.org/licenses/mit-license.html>
 */
namespace Bookymark\Common;

use BaseController as LaravelBaseController;
use View;
use Auth;

/**
 * BaseController
 *
 * @author Michael Funk <mfunk@christianpublishing.com>
 */
class BaseController extends LaravelBaseController
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        View::share('logged_in_user', Auth::user());
    }
}
