<?php
/**
 * @package Bookymark
 * @license MIT License <http://opensource.org/licenses/mit-license.html>
 */
namespace MikeFunk\Bookymark\Tests\Unit\Errors;

use MikeFunk\Bookymark\Tests\BookymarkTest;

/**
 * ErrorControllerTest
 *
 * @author Michael Funk <mfunk@christianpublishing.com>
 */
class ErrorControllerTest extends BookymarkTest
{
    /**
     * testError404
     *
     * @return void
     */
    public function testError404()
    {
        $this->call('GET', 'errors/404');
        $this->assertResponseOk();
    }

    /**
     * testError500
     *
     * @return void
     */
    public function testError500()
    {
        $this->call('GET', 'errors/500');
        $this->assertResponseOk();
    }
}
