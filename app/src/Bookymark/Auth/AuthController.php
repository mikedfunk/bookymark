<?php
/**
 * @package Bookymark
 * @copyright 2013 Xulon Press, Inc. All Rights Reserved.
 */
namespace Bookymark\Auth;

use Bookymark\Common\BaseController;
use View;
use Auth;
use Notification;
use Redirect;
use Input;
use Password;
use Validator;
use Lang;
use Mail;
use Hash;
use Session;

/**
 * AuthController
 *
 * @author Michael Funk <mfunk@christianpublishing.com>
 */
class AuthController extends BaseController
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct(UserRepository $user_repository)
    {
        parent::__construct();
        $this->user_repository = $user_repository;
    }

    /**
     * login
     *
     * @return View
     */
    public function login()
    {
        return View::make('auth.login');
    }

    /**
     * doLogin
     *
     * @return Redirect
     */
    public function doLogin()
    {
        // if login successful, notify and redirect
        $input = Input::only(array('email', 'password'));
        if (Auth::attempt($input)) {
            Notification::success(Lang::get('notifications.logged_in'));
            return Redirect::route('bookmarks.index');
        }

        // if it fails, notify and redirect
        Notification::error(Lang::get('notifications.login_error'));
        return Redirect::route('auth.login');
    }

    /**
     * logout
     *
     * @return Redirect
     */
    public function logout()
    {
        // logout, notify, redirect
        Auth::logout();
        Notification::success(Lang::get('notifications.logged_out'));
        return Redirect::route('auth.login');
    }

    /**
     * resetPassword
     *
     * @param string $token
     * @return View
     */
    public function resetPassword($token)
    {
        return View::make('auth.reset_password', compact('token'));
    }

    /**
     * doResetPassword
     *
     * @param string $token automatically checked by the password class
     * @return Redirect
     */
    public function doResetPassword($token)
    {
        // set rules, make validator
        $rules = array(
            'email'    => 'required|email',
            'password' => 'confirmed'
        );
        $input = Input::all();
        $validation = Validator::make($input, $rules);

        // notify and redirect on fail
        if ($validation->fails()) {
            Notification::error(Lang::get('notifications.form_error'));
            return Redirect::route('auth.reset_password', $token)->withErrors($validation);
        }
        // get credentials, reset password
        $credentials = Input::only('email');
        return Password::reset(
            $credentials,
            // @TODO figure out the best way to test this... or just skip it.
            function ($user, $password) {

                // set new password, save user, redirect
                $user->password = Hash::make($password);
                $user->save();

                // notify and redirect
                Notification::success(Lang::get('notifications.password_reset_success'));
                return Redirect::route('auth.login');
            }
        );
    }

    /**
     * remind
     *
     * @return View
     */
    public function remind()
    {
        return View::make('auth.remind');
    }

    /**
     * doRemind
     *
     * @return Redirect
     */
    public function doRemind()
    {
        // set rules, make validator
        $rules = array(
            'email' => 'required|email',
        );
        $input = Input::only('email');
        $validation = Validator::make($input, $rules);

        if ($validation->fails()) {
            Notification::error(Lang::get('notifications.form_error'));
            return Redirect::route('auth.remind')->withErrors($validation);
        }

        // notify success and let laravel do it's thing.
        Notification::success(Lang::get('notifications.remind_success'));
        return Password::remind(
            $input,
            function ($message, $user) {
                $message->subject(Lang::get('emails.reminder_subject'));
            }
        );
    }

    /**
     * register
     *
     * @return View
     */
    public function register()
    {
        return View::make('auth.register');
    }

    /**
     * doRegister
     *
     * @return Redirect
     */
    public function doRegister()
    {
        // set rules, make validator
        $rules = array(
            'email'    => 'required|email|unique:users',
            'password' => 'required|confirmed'
        );
        $input = Input::all();
        $validation = Validator::make($input, $rules);

        if ($validation->fails()) {

            // Send the $validation object to the redirected page
            Notification::error('Please correct the highlighted errors.');
            return Redirect::route('auth.register')->withErrors($validation);
        }

        // set register_token
        $input['register_token'] = uniqid();
        $input['password'] = Hash::make($input['password']);
        $user = $this->user_repository->create($input);

        // send confirm registration email
        Mail::send(
            'emails.auth.confirm_registration',
            compact('user'),
            function ($message) use ($input) {
                $message
                    ->to($input['email'], $input['email'])
                    ->subject(Lang::get('emails.register_subject'));
            }
        );

        // notify and redirect
        Notification::success(Lang::get('notifications.register_success'));
        return Redirect::route('auth.login');
    }

    /**
     * confirmRegistration
     *
     * @param string $token
     * @return View|Redirect
     */
    public function confirmRegistration($token)
    {
        // look for user
        $user = $this->user_repository->findByRegisterToken($token);

        // if no user is found with that token
        if (!$user) {
            Notification::error(Lang::get('notifications.confirm_registration_error'));
            return Redirect::route('auth.register');
        }

        // else notify and redirect to login
        $user->register_token = '';
        $user->save();
        Notification::success(Lang::get('notifications.confirm_registration_success'));
        return Redirect::route('auth.login');
    }

    /**
     * profile
     *
     * @return View
     */
    public function profile()
    {
        // get user, load view
        $user = $this->user_repository->find(Auth::user()->id);
        return View::make('auth.profile', compact('user'));
    }

    /**
     * updateProfile
     *
     * @return Redirect
     */
    public function updateProfile()
    {
        // validation rules
        $id = Auth::user()->id;
        $rules = array(
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'confirmed',
        );

        // setup and check validator, set notification, redirect
        $input = Input::all();
        $validation = Validator::make($input, $rules);

        if ($validation->fails()) {
            Notification::error(Lang::get('notifications.form_error'));
        } else {

            // tweak the input a bit for the repository
            $input['id'] = Auth::user()->id;
            if ($input['password'] == '') {
                unset($input['password']);
            } else {
                // otherwise hash it
                $input['password'] = Hash::make($input['password']);
            }
            unset($input['password_confirmation']);

            // update , notify, and redirect
            $this->user_repository->update($input);
            Notification::success(Lang::get('notifications.profile_updated'));
        }
        return Redirect::route('auth.profile')->withErrors($validation);
    }
}
