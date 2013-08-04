<?php
/**
 * @package Bookymark
 * @copyright 2013 Xulon Press, Inc. All Rights Reserved.
 */
namespace Bookymark\Tests;

use TestCase;
use Mockery;

/**
 * Base Bookymark TestCase
 *
 * @author Michael Funk <mfunk@christianpublishing.com>
 */
class BookymarkTest extends TestCase
{
    /**
     * tearDown
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }
}
