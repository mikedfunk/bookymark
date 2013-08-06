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
use Lang;
use Mail;

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
        Auth::shouldReceive('user');
    }

    /**
     * testAuthLoginOk
     *
     * @return void
     */
    public function testAuthLoginOk()
    {
        // mock view and call
        // View::shouldReceive('make')
            // ->once()
            // ->with('auth.login');
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
            ->with(Lang::get('notifications.logged_in'));

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
            ->with(Lang::get('notifications.login_error'));

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
        // View::shouldReceive('make')
            // ->once()
            // ->with('auth.reset', compact('token'));
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
        // @NOTE this is not a complete test, I haven't tested the closure
        // in Password::reset() yet.
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
        // View::shouldReceive('make')
            // ->once()
            // ->with('auth.remind');
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
        // View::shouldReceive('make')
            // ->once()
            // ->with('auth.register');
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
            '_token'                => 'abc',
        );

        // mock validator to succeed
        $validator = Mockery::mock();
        $validator->shouldReceive('fails')->once()->andReturn(false);
        Validator::shouldReceive('make')->once()->andReturn($validator);

        // mock notification
        Notification::shouldReceive('success')
            ->once()
            ->with(Lang::get('notifications.register_success'));

        // mock user
        $user = Mockery::mock('Bookymark\Auth\UserModel');
        $user->shouldDeferMissing();
        unset($values['password_confirmation']);
        $values['register_token'] = 'a';
        $user->fill($values);

        // mock user repository
        $user_repository = Mockery::mock('Bookymark\Auth\UserRepository');
        $user_repository->shouldReceive('create')
            ->once()
            // @TODO this includes a uniqid()... find a better way
            // ->with($values)
            ->andReturn($user);
        $this->app->instance('Bookymark\Auth\UserRepository', $user_repository);

        // mock mail send
        Mail::shouldReceive('send')
            ->once();
            // @TODO test this closure
            // ->with(
                // 'emails.register',
                // compact('user'),
                // function () {
                // }
            // );

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

    /**
     * testAuthProfileOk
     *
     * @return void
     */
    public function testAuthProfileOk()
    {
        // mock user model
        $user = Mockery::mock();

        // mock user repository
        $user_repository = Mockery::mock('Bookymark\Auth\UserRepository');
        $user_repository->shouldReceive('find')
            ->once()
            ->with(1)
            ->andReturn($user);
        $this->app->instance('Bookymark\Auth\UserRepository', $user_repository);

        // mock view
        // View::shouldReceive('make')
            // ->once()
            // ->with('auth.profile', compact('user'));

        // call
        $this->call('GET', 'auth/1/profile');

        // assert ok
        $this->assertResponseOk();
    }

    /**
     * testAuthUpdateProfileOk
     *
     * @return void
     */
    public function testAuthUpdateProfileOk()
    {
        // mock input
        $input = array(
            'email'                 => 'test@test.com',
            'password'              => 'abcsfsdf',
            'password_confirmation' => 'abcsfsdf',
        );

        // mock user repository
        $user_repository = Mockery::mock('Bookymark\Auth\UserRepository');
        $user_repository->shouldReceive('update')
            ->once()
            ->with($input);
        $this->app->instance('Bookymark\Auth\UserRepository', $user_repository);

        // mock validator to succeed
        $validator = Mockery::mock();
        $validator->shouldReceive('fails')->once()->andReturn(false);
        Validator::shouldReceive('make')->once()->andReturn($validator);

        // mock notification success
        Notification::shouldReceive('success')
            ->once()
            ->with(Lang::get('notifications.profile_updated'));

        // call, ensure success
        $this->call('POST', 'auth/1/profile', $input);
        $this->assertRedirectedToRoute('auth.profile', '1');
    }

    /**
     * testAuthUpdateProfileFailValidation
     *
     * @return void
     */
    public function testAuthUpdateProfileFailValidation()
    {
        // mock input
        $input = array(
            'email'                 => 'test@test.com',
            'password'              => 'abcsfsdf',
            'password_confirmation' => 'abcsfsdf',
        );

        // mock validator to fail
        $validator = Mockery::mock();
        $validator->shouldReceive('fails')->once()->andReturn(true);
        Validator::shouldReceive('make')->once()->andReturn($validator);

        // mock notification success
        Notification::shouldReceive('error')
            ->once()
            ->with(Lang::get('notifications.form_error'));

        // call, ensure success
        $this->call('POST', 'auth/1/profile', $input);
        $this->assertRedirectedToRoute('auth.profile', '1');
    }

    /**
     * testAuthLogout
     *
     * @return void
     */
    public function testAuthLogout()
    {
        // auth should receive logout
        Auth::shouldReceive('logout')->once();

        // notification should receive
        Notification::shouldReceive('success')
            ->once()
            ->with(Lang::get('notifications.logged_out'));

        // assert redirected
        $this->call('GET', 'auth/logout');
        $this->assertRedirectedToRoute('auth.login');
    }

    /**
     * testConfirmRegistrationFail
     *
     * @return void
     */
    public function testConfirmRegistrationFail()
    {
        // mock user query by token to return null
        $register_token = 'abc123';
        $user_repository = Mockery::mock('Bookymark\Auth\UserRepository');
        $user_repository->shouldReceive('findByRegisterToken')
            ->once()
            ->with($register_token);
        $this->app->instance('Bookymark\Auth\UserRepository', $user_repository);

        // ensure notification error with notifications.confirm_registration_error
        Notification::shouldReceive('error')
            ->once()
            ->with(Lang::get('notifications.confirm_registration_error'));

        // it loads a view but don't mock it
        $this->call('GET', 'auth/' . $register_token . '/confirm-registration');
        $this->assertResponseOk();
    }

    /**
     * testConfirmRegistrationSuccess
     *
     * @return void
     */
    public function testConfirmRegistrationSuccess()
    {
        // mock user query by token
        $register_token = 'abc123';
        $user = Mockery::mock('Bookymark\Auth\UserModel');
        $user->shouldDeferMissing();
        $user->shouldReceive('save')->once();

        // mock user repo
        $user_repository = Mockery::mock('Bookymark\Auth\UserRepository');
        $user_repository->shouldReceive('findByRegisterToken')
            ->once()
            ->with($register_token)
            ->andReturn($user);
        $this->app->instance('Bookymark\Auth\UserRepository', $user_repository);

        // ensure notification error with notifications.confirm_registration_error
        Notification::shouldReceive('success')
            ->once()
            ->with(Lang::get('notifications.confirm_registration_success'));

        // it loads a view but don't mock it
        $this->call('GET', 'auth/' . $register_token . '/confirm-registration');
        $this->assertRedirectedToRoute('auth.login');

    }
}
