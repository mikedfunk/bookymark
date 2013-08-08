<?php
/**
 * @package Bookymark
 * @copyright 2013 Xulon Press, Inc. All Rights Reserved.
 */
namespace Tests\Bookymark;

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
