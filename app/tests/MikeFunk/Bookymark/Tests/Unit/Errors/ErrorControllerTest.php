<?php
/**
 * @package Bookymark
 * @license MIT License <http://opensource.org/licenses/mit-license.html>
 */
namespace MikeFunk\Bookymark\Tests;

/**
 * ErrorControllerTest
 *
 * @author Michael Funk <mfunk@christianpublishing.com>
 */
class ErrorControllerTest
{
    /**
     * testError404
     *
     * @return void
     */
    public function testError404()
    {
        $this->call('errors/404');
        $this->assertResponseOk();
    }

    /**
     * testError500
     *
     * @return void
     */
    public function testError500()
    {
        $this->call('errors/404');
        $this->assertResponseOk();
    }
}
