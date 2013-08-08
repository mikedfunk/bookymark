<?php
/**
 * @package Bookymark
 * @copyright 2013 Xulon Press, Inc. All Rights Reserved.
 */
namespace Bookymark\Tests\Unit\Home;

use Mockery;
use Bookymark\Tests\BookymarkTest;
use View;
use Auth;

/**
 * HomeControllerTest
 *
 * @author Michael Funk <mfunk@christianpublishing.com>
 */
class HomeControllerTest extends BookymarkTest
{
    /**
     * setUp
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        Auth::shouldReceive('user');
    }

    /**
     * testHomeCIndexOk
     *
     * @return void
     */
    public function testHomeIndexOk()
    {
        $this->call('GET', '/');
        $this->assertResponseOk();
    }
}
