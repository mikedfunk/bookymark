<?php
/**
 * @package Bookymark
 * @copyright 2013 Xulon Press, Inc. All Rights Reserved.
 */
namespace Bookymark\Home;

use Bookymark\Common\BaseController;
use View;

/**
 * HomeController
 *
 * @author Michael Funk <mfunk@christianpublishing.com>
 */
class HomeController extends BaseController
{
    /**
     * index
     *
     * @return View
     */
    public function index()
    {
        return View::make('home.home_index');
    }
}
