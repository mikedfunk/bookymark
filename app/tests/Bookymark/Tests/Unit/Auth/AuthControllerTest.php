<?php
/**
 * @package Bookymark
 * @copyright 2013 Xulon Press, Inc. All Rights Reserved.
 */
namespace Bookymark;

use Bookymark\Tests\BookymarkTest;
use View;
use Notification;
use Auth;
use Password;

/**
 * AuthControllerTest
 *
 * @author Michael Funk <mfunk@christianpublishing.com>
 */
class AuthControllerTest extends BookymarkTest
{
    /**
     * setUp
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        // set credentials
        $this->credentials = array(
            'email'    => 'test@test.com',
            'password' => 'dfdfd',
        );
        $this->token = 'abc234';
    }

    /**
     * testAuthLoginOk
     *
     * @return void
     */
    public function testAuthLoginOk()
    {
        // mock view and call
        View::shouldReceive('make')
            ->once()
            ->with('auth.login');
        $this->call('GET', 'auth/login');
        $this->assertResponseOk();
    }

    /**
     * testAuthDoLoginOk
     *
     * @return void
     */
    public function testAuthDoLoginOk()
    {
        // auth should receive attempt
        Auth::shouldReceive('attempt')
            ->once()
            ->with($this->credentials)
            ->andReturn(true);

        // notification should receive
        Notification::shouldReceive('success')
            ->once()
            ->with('You have been logged in.');

        // should redirect
        $this->call('POST', 'auth/login', $this->credentials);
        $this->assertRedirectedToRoute('bookmarks.index');
    }

    /**
     * testAuthDoLoginFail
     *
     * @return void
     */
    public function testAuthDoLoginFail()
    {
        // auth should receive attempt
        Auth::shouldReceive('attempt')
            ->once()
            ->with($this->credentials)
            ->andReturn(false);

        // notification should receive
        Notification::shouldReceive('error')
            ->once()
            ->with('Login failed.');

        // should redirect
        $this->call('POST', 'auth/login', $this->credentials);
        $this->assertRedirectedToRoute('auth.login');
    }

    /**
     * testAuthResetOk
     *
     * @return void
     */
    public function testAuthResetOk()
    {
        // mock view and call
        $token = $this->token;
        View::shouldReceive('make')
            ->once()
            ->with('auth.reset', compact('token'));
        $this->call('GET', 'auth/reset/' . $this->token);
        $this->assertResponseOk();
    }

    /**
     * testAuthDoResetOk
     *
     * @return void
     */
    public function testAuthDoResetOk()
    {
        // mock password call and check response
        Password::shouldReceive('reset')->once();
        $this->call('POST', 'auth/reset/' . $this->token, $this->credentials);
        $this->assertResponseOk();
    }

    /**
     * testAuthRemindOk
     *
     * @return void
     */
    public function testAuthRemindOk()
    {
        // mock view and call
        View::shouldReceive('make')
            ->once()
            ->with('auth.remind');
        $this->call('GET', 'auth/remind');
        $this->assertResponseOk();
    }

    /**
     * testAuthDoRemindOk
     *
     * @return void
     */
    public function testAuthDoRemindOk()
    {
        // mock password
        Password::shouldReceive('remind')
            ->once()
            ->with($this->credentials);

        // call and check response
        $this->call('POST', 'auth/remind', $this->credentials);
        $this->assertResponseOk();
    }
}
