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
     * reset
     *
     * @param string $token
     * @return View
     */
    public function reset($token)
    {
        return View::make('auth.reset_password', compact('token'));
    }

    /**
     * doReset
     *
     * @param string $token automatically checked by the password class
     * @return Redirect
     */
    public function doReset($token)
    {
        // get credentials, reset password
        $credentials = Input::all();
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
        return Password::remind(Input::all());
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
            'password' => 'confirmed'
        );
        $validation = Validator::make(Input::all(), $rules);

        if ($validation->fails()) {

            // Send the $validation object to the redirected page
            Notification::error('Please correct the highlighted errors.');
            return Redirect::route('auth.register')->withErrors($validation);
        }

        // otherwise success
        Notification::success(Lang::get('notifications.register_success'));
        return Redirect::route('auth.login');
    }

    /**
     * profile
     *
     * @param int $id
     * @return View
     */
    public function profile($id)
    {
        // get user, load view
        $user = $this->user_repository->find($id);
        return View::make('auth.profile', compact('user'));
    }

    /**
     * updateProfile
     *
     * @param int $id
     * @return Redirect
     */
    public function updateProfile($id)
    {
        // validation rules
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
            $this->user_repository->update($input);
            Notification::success(Lang::get('notifications.profile_updated'));
        }
        return Redirect::route('auth.profile', $id);

    }
}
