<?php
/**
 * @package Bookymark
 * @copyright 2013 Xulon Press, Inc. All Rights Reserved.
 */
namespace Bookymark\Errors;

use Bookymark\Common\BaseController;
use View;

/**
 * ErrorController
 *
 * @author Michael Funk <mfunk@christianpublishing.com>
 */
class ErrorController extends BaseController
{

    /**
     * error404
     *
     * @return View
     */
    public function error404()
    {
        return View::make('errors.404');
    }

    /**
     * error500
     *
     * @return View
     */
    public function error500()
    {
        return View::make('errors.500');
    }
}
