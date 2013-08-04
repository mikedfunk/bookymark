<?php
/**
 * @package Bookymark
 * @copyright 2013 Xulon Press, Inc. All Rights Reserved.
 */
namespace Bookymark\Tests\Unit\Home;

use Mockery;
use Bookymark\Tests\BookymarkTest;
use View;

/**
 * HomeControllerTest
 *
 * @author Michael Funk <mfunk@christianpublishing.com>
 */
class HomeControllerTest extends BookymarkTest
{
    /**
     * testHomeCIndexOk
     *
     * @return void
     */
    public function testHomeIndexOk()
    {
        View::shouldReceive('make')->once()->with('home.home_index');
        $this->call('GET', '/');
        $this->assertResponseOk();
    }
}
