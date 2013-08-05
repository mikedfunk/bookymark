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

/**
 * AuthController
 *
 * @author Michael Funk <mfunk@christianpublishing.com>
 */
class AuthController extends BaseController
{
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
        if (Auth::attempt(Input::all())) {
            Notification::success('You have been logged in.');
            return Redirect::route('bookmarks.index');
        }

        // if it fails, notify and redirect
        Notification::error('Login failed.');
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
        return View::make('auth.reset', compact('token'));
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
                Notification::success('Password Reset.');
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
        Notification::success('Registration successful. Please log in.');
        return Redirect::route('auth.login');
    }
}
