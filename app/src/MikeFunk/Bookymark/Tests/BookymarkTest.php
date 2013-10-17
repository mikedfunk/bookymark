<?php
/**
 * @package Bookymark
 * @license MIT License <http://opensource.org/licenses/mit-license.html>
 */
namespace MikeFunk\Bookymark\Tests;

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
