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
use Mockery;
use Validator;

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

        // mock common View::share call in base controller
        Auth::shouldReceive('check');
        View::shouldReceive('share')
            ->once()
            ->with('is_logged_in', Auth::check());
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
        $this->mockAuthDriver();
        Password::shouldReceive('reset')->once();
        $this->call('POST', 'auth/reset/' . $this->token, $this->credentials);
        $this->assertResponseOk();
    }

    /**
     * mockAuthDriver
     *
     * @return void
     */
    private function mockAuthDriver()
    {
        $auth_provider = Mockery::mock('Illuminate\Auth\UserProviderInterface');
        $auth_driver = Mockery::mock();
        $auth_driver->shouldReceive('getProvider')->once()->andReturn($auth_provider);
        Auth::shouldReceive('driver')->once()->andReturn($auth_driver);
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
        $this->mockAuthDriver();
        Password::shouldReceive('remind')->once()->with($this->credentials);

        // call and check response
        $this->call('POST', 'auth/remind', $this->credentials);
        $this->assertResponseOk();
    }

    /**
     * testAuthRegisterOk
     *
     * @return void
     */
    public function testAuthRegisterOk()
    {
        // mock view, call, ensure ok
        View::shouldReceive('make')
            ->once()
            ->with('auth.register');
        $this->call('GET', 'auth/register');
        $this->assertResponseOk();
    }

    /**
     * testAuthDoRegisterOk
     *
     * @return void
     */
    public function testAuthDoRegisterOk()
    {
        // form values
        $values = array(
            'email'                 => 'testeioruwer@test.com',
            'password'              => 'kgroew',
            'password_confirmation' => 'kgroew',
        );

        // mock validator to succeed
        $validator = Mockery::mock();
        $validator->shouldReceive('fails')->once()->andReturn(false);
        Validator::shouldReceive('make')->once()->andReturn($validator);

        // mock notification
        Notification::shouldReceive('success')
            ->once()
            ->with('Registration successful. Please log in.');

        // call and check
        $this->call('POST', 'auth/register', $values);
        $this->assertRedirectedToRoute('auth.login');
    }

    /**
     * testAuthDoRegisterFailValidation
     *
     * @return void
     */
    public function testAuthDoRegisterFailValidation()
    {
        // form values
        $values = array(
            'email'                 => 'testeioruwer@test.com',
            'password'              => 'kgroew',
            'password_confirmation' => 'kgroew',
        );

        // mock validator to fail
        $validator = Mockery::mock();
        $validator->shouldReceive('fails')->once()->andReturn(true);
        Validator::shouldReceive('make')->once()->andReturn($validator);

        // mock notification
        Notification::shouldReceive('error')
            ->once()
            ->with('Please correct the highlighted errors.');

        // call and check
        $this->call('POST', 'auth/register', $values);
        $this->assertRedirectedToRoute('auth.register');
    }
}
