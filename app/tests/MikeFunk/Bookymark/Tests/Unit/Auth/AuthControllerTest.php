<?php
/**
 * @package Bookymark
 * @license MIT License <http://opensource.org/licenses/mit-license.html>
 */
namespace MikeFunk\Bookymark;

use MikeFunk\Bookymark\Tests\BookymarkTest;
use View;
use Notification;
use Auth;
use Password;
use Mockery;
use Validator;
use Lang;
use Mail;
use Session;
use Hash;

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

        // user for logging in
        $this->user = Mockery::mock('MikeFunk\Bookymark\Auth\UserModel');
        $this->user->shouldDeferMissing();
        $this->user->id = 1;
    }

    /**
     * login
     *
     * @return void
     */
    private function login()
    {
        // fake login as user
        $this->be($this->user);
    }

    /**
     * testAuthLoginOk
     *
     * @return void
     */
    public function testAuthLoginOk()
    {
        // mock view and call
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
        Auth::shouldReceive('user')->once()->andReturn($this->user);

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
        Auth::shouldReceive('user')->once()->andReturn($this->user);

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
    public function testAuthResetPasswordOk()
    {
        // mock view and call
        $token = $this->token;
        $this->call('GET', 'auth/' . $this->token . '/reset-password');
        $this->assertResponseOk();
    }

    /**
     * testAuthDoResetPasswordOk
     *
     * @return void
     */
    public function testAuthDoResetPasswordOk()
    {
        // mock validator to succeed
        $validator = Mockery::mock();
        $validator->shouldReceive('fails')->once()->andReturn(false);
        Validator::shouldReceive('make')->once()->andReturn($validator);

        // mock password call and check response
        // password reset prevents the closure from executing, hence no redirect
        // or notification
        $this->mockAuthDriver();
        Password::shouldReceive('reset')->once();
        $this->call('POST', 'auth/' . $this->token . '/reset-password', $this->credentials);
        $this->assertResponseOk();
    }

    /**
     * testAuthDoResetPasswordFail
     *
     * @return void
     */
    public function testAuthDoResetPasswordFail()
    {
        $token = '123';

        // mock validator to fail
        $validator = Mockery::mock();
        $validator->shouldReceive('fails')->once()->andReturn(true);
        Validator::shouldReceive('make')->once()->andReturn($validator);

        // mock notification and assert redirect
        Notification::shouldReceive('error')
            ->once()
            ->with(Lang::get('notifications.form_error'));
        $this->call('POST', 'auth/' . $token . '/reset-password', array());
        $this->assertRedirectedToRoute('auth.reset_password', $token);
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
        Auth::shouldReceive('user')->once()->andReturn($this->user);
    }

    /**
     * testAuthRemindOk
     *
     * @return void
     */
    public function testAuthRemindOk()
    {
        // mock view and call
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
        $credentials = array('email' => $this->credentials['email']);
        // mock validator to succeed
        $validator = Mockery::mock();
        $validator->shouldReceive('fails')->once()->andReturn(false);
        Validator::shouldReceive('make')->once()->andReturn($validator);

        // mock password
        $this->mockAuthDriver();
        Password::shouldReceive('remind')->once();
        Password::shouldDeferMissing();

        // mock notification
        Notification::shouldReceive('success')
            ->once()
            ->with(Lang::get('notifications.remind_success'));

        // call and check response
        $this->call('POST', 'auth/remind', $credentials);
        $this->assertResponseOk();
    }

    /**
     * testAuthDoRemindFailValidation
     *
     * @return void
     */
    public function testAuthDoRemindFailValidation()
    {
        $input = array('email' => '');

        // mock notification
        Notification::shouldReceive('error')
            ->once()
            ->with(Lang::get('notifications.form_error'));

        // call and check response
        $this->call('POST', 'auth/remind', $input);
        $this->assertRedirectedToRoute('auth.remind');
    }

    /**
     * testAuthRegisterOk
     *
     * @return void
     */
    public function testAuthRegisterOk()
    {
        // call, assert ok
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
        $user = Mockery::mock('MikeFunk\Bookymark\Auth\UserModel');
        $user->shouldDeferMissing();
        unset($values['password_confirmation']);
        $values['register_token'] = 'a';
        $user->fill($values);

        // mock user repository
        $user_repository = Mockery::mock('MikeFunk\Bookymark\Auth\UserRepository');
        $user_repository->shouldReceive('create')
            ->once()
            // @TODO this includes a uniqid()... find a better way
            // ->with($values)
            ->andReturn($user);
        $this->app->instance('MikeFunk\Bookymark\Auth\UserRepository', $user_repository);

        // mock mail send
        Mail::shouldReceive('send')
            ->once();

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

        // mock validator to fail. If it's not mocked it will check
        // for a unique user in the db.
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
        $this->login();

        // mock user repository
        $user_repository = Mockery::mock('MikeFunk\Bookymark\Auth\UserRepository');
        $user_repository->shouldReceive('find')
            ->once()
            ->with($this->user->id)
            ->andReturn($this->user);
        $this->app->instance('MikeFunk\Bookymark\Auth\UserRepository', $user_repository);

        // call, assert ok
        $this->call('GET', 'auth/profile');
        $this->assertResponseOk();
    }

    /**
     * testAuthUpdateProfileOk
     *
     * @return void
     */
    public function testAuthUpdateProfileOk()
    {
        $this->login();

        // mock input
        $input = array(
            'email'                 => 'test@test.com',
            'password'              => 'abcsfsdf',
            'password_confirmation' => 'abcsfsdf',
        );

        // mock hash so it always returns the same thing
        Hash::shouldReceive('make')->andReturn('lala');

        // tweak the input that gets sent to the repository
        $my_input = $input;
        $my_input['id'] = $this->user->id;
        $my_input['password'] = 'lala';
        unset($my_input['password_confirmation']);

        // mock user repository
        $user_repository = Mockery::mock('MikeFunk\Bookymark\Auth\UserRepository');
        $user_repository->shouldReceive('update')
            ->once()
            ->with($my_input);
        $this->app->instance('MikeFunk\Bookymark\Auth\UserRepository', $user_repository);

        // mock validator to succeed
        $validator = Mockery::mock();
        $validator->shouldReceive('fails')->once()->andReturn(false);
        Validator::shouldReceive('make')->once()->andReturn($validator);

        // mock notification success
        Notification::shouldReceive('success')
            ->once()
            ->with(Lang::get('notifications.profile_updated'));

        // call, ensure success
        $this->call('PUT', 'auth/profile', $input);
        $this->assertRedirectedToRoute('auth.profile');
    }

    /**
     * userDataProvider
     *
     * @return array
     */
    public function userDataProvider()
    {
        return array(
            array(

                // missing email
                array(
                    'email'                 => '',
                    'password'              => 'abcsfsdf',
                    'password_confirmation' => 'abcsfsdf',
                ),

                // missing password
                array(
                    'email'                 => 'test@test.com',
                    'password'              => '',
                    'password_confirmation' => '',
                ),

                // missing password confirmation
                array(
                    'email'                 => 'test@test.com',
                    'password'              => 'abcsfsdf',
                    'password_confirmation' => '',
                ),

                // email not in email format
                array(
                    'email'                 => 'dfdf',
                    'password'              => 'abcsfsdf',
                    'password_confirmation' => '',
                ),

                // passwords don't match
                array(
                    'email'                 => 'test@test.com',
                    'password'              => 'abcsfsdf',
                    'password_confirmation' => 'rrrgfl',
                ),
            ),
        );
    }

    /**
     * testAuthUpdateProfileFailValidation
     *
     * @dataProvider userDataProvider
     * @return void
     */
    public function testAuthUpdateProfileFailValidation($input)
    {
        $this->login();

        // mock notification error
        Notification::shouldReceive('error')
            ->once()
            ->with(Lang::get('notifications.form_error'));

        // call, ensure error and redirected
        $this->call('PUT', 'auth/profile', $input);
        $this->assertRedirectedToRoute('auth.profile');
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
        Auth::shouldReceive('user')->once();

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
        $user_repository = Mockery::mock('MikeFunk\Bookymark\Auth\UserRepository');
        $user_repository->shouldReceive('findByRegisterToken')
            ->once()
            ->with($register_token);
        $this->app->instance('MikeFunk\Bookymark\Auth\UserRepository', $user_repository);

        // ensure notification error with notifications.confirm_registration_error
        Notification::shouldReceive('error')
            ->once()
            ->with(Lang::get('notifications.confirm_registration_error'));

        // it loads a view but don't mock it
        $this->call('GET', 'auth/' . $register_token . '/confirm-registration');
        $this->assertRedirectedToRoute('auth.register');
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
        $this->user->shouldReceive('save')->once();

        // mock user repo
        $user_repository = Mockery::mock('MikeFunk\Bookymark\Auth\UserRepository');
        $user_repository->shouldReceive('findByRegisterToken')
            ->once()
            ->with($register_token)
            ->andReturn($this->user);
        $this->app->instance('MikeFunk\Bookymark\Auth\UserRepository', $user_repository);

        // ensure notification error with notifications.confirm_registration_error
        Notification::shouldReceive('success')
            ->once()
            ->with(Lang::get('notifications.confirm_registration_success'));

        // it loads a view but don't mock it
        $this->call('GET', 'auth/' . $register_token . '/confirm-registration');
        $this->assertRedirectedToRoute('auth.login');

    }
}
