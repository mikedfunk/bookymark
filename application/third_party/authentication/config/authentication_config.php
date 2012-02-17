<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * authentication_config
 * 
 * Description
 * 
 * @license		Copyright Xulon Press, Inc. All Rights Reserved.
 * @author		Xulon Press
 * @link		http://xulonpress.com
 * @email		info@xulonpress.com
 * 
 * @file		authentication_config.php
 * @version		1.0
 * @date		02/17/2012
 * 
 * Copyright (c) 2012
 */

// --------------------------------------------------------------------------
/**
 * users_table
 *
 * the table to pull users from
 */
$config['users_table'] = 'users';

// --------------------------------------------------------------------------
/**
 * roles_table
 *
 * the table to pull roles from
 */
$config['roles_table'] = 'roles';

// --------------------------------------------------------------------------
/**
 * username_field
 *
 * the field in the db and session used for username
 */
$config['username_field'] = 'email_address';

// --------------------------------------------------------------------------
/**
 * password_field
 *
 * the field in the db and session used for password
 */
$config['password_field'] = 'password';

// --------------------------------------------------------------------------
/**
 * remember_me_field
 *
 * the field checked in post and used as a cookie name
 */
$config['remember_me_field'] = 'remember_me';

// --------------------------------------------------------------------------
/**
 * home_page_field
 *
 * the field in the db and session used for home_page (in the roles table)
 */
$config['home_page_field'] = 'home_page';

// --------------------------------------------------------------------------
/**
 * role_id_field
 *
 * the field used to join role_id (in the users table)
 */
$config['role_id_field'] = 'role_id';

// --------------------------------------------------------------------------
/**
 * remember_me_timeout
 *
 * the time, in seconds, that the remember_me cookie lasts
 */
$config['remember_me_timeout'] = 60 * 60 * 24 * 365;

// --------------------------------------------------------------------------
/**
 * salt_length
 *
 * the length of the salt string to be added to / parsed from the password
 */
$config['salt_length'] = 64;

// --------------------------------------------------------------------------
/**
 * logged_out_url
 *
 * where to redirect when login_check fails
 */
$config['logged_out_url'] = 'home/login?notification=logged_out';

// --------------------------------------------------------------------------
/**
 * logout_success_url
 *
 * where to redirect on logout
 */
$config['logout_success_url'] = 'home/login?notification=logout_success';

// --------------------------------------------------------------------------
/* End of file authentication_config.php */
/* Location: ./bookymark/application/third_party/authentication/config/authentication_config.php */