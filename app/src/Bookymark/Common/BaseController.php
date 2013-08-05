<?php
/**
 * @package Bookymark
 * @copyright 2013 Xulon Press, Inc. All Rights Reserved.
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
        View::share('is_logged_in', Auth::check());
    }
}
