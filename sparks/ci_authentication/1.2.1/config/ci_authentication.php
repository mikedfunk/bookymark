<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * ci_authentication config
 * 
 * All configurable values for the ci_authentication spark
 * 
 * @license		http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @author		Mike Funk
 * @link		http://mikefunk.com
 * @email		mike@mikefunk.com
 * 
 * @file		ci_authentication.php
 * @version		1.2.1
 * @date		03/09/2012
 */

// --------------------------------------------------------------------------
/**
 * users_table
 *
 * The table to pull users from.
 */
$config['users_table'] = 'users';

// --------------------------------------------------------------------------
/**
 * roles_table
 *
 * The table to pull roles from. If you don't have a separate roles table, 
 * leave this blank and it won't be joined in.
 */
$config['roles_table'] = '';

// --------------------------------------------------------------------------
/**
 * user_id_field
 *
 * The field used in the session and users table for id.
 */
$config['user_id_field'] = 'id';

// --------------------------------------------------------------------------
/**
 * username_field
 *
 * The field in the db and session used for username.
 */
$config['username_field'] = 'email_address';

// --------------------------------------------------------------------------
/**
 * password_field
 *
 * The field in the db and session used for password.
 */
$config['password_field'] = 'password';

// --------------------------------------------------------------------------
/**
 * user_status_field
 *
 * The field in the db and session used for user status.
 */
$config['user_status_field'] = 'status';

// --------------------------------------------------------------------------
/**
 * remember_me_field
 *
 * The field checked in post and used as a cookie name.
 */
$config['remember_me_field'] = 'remember_me';

// --------------------------------------------------------------------------
/**
 * login_with_encryption_key
 * 
 * If true, password string is mixed with the configured encryption key.
 * Leave this true for security!
 */
$config['login_with_encryption_key'] = TRUE;

// --------------------------------------------------------------------------
/**
 * login_success_url
 *
 * If you don't have a login_success field in the db, use this to redirect
 * successful logins to this page.
 */
$config['login_success_url'] = 'dashboard';

// --------------------------------------------------------------------------
/**
 * login_success_url_field
 *
 * Ihe field in the db and session used for redirecting to after successful
 * login (in the roles or users table) leave blank if you don't have this in
 * the db.
 */
$config['login_success_url_field'] = '';

// --------------------------------------------------------------------------
/**
 * confirm_string_field
 *
 * The field in the db assigned to a user that has not yet confirmed 
 * their registration via email.
 */
$config['confirm_string_field'] = 'confirm_string';

// --------------------------------------------------------------------------
/**
 * role_id_field
 *
 * The field used to join role_id (in the users table).
 */
$config['role_id_field'] = 'role_id';

// --------------------------------------------------------------------------
/**
 * user_role_id (int)
 *
 * The role id for users to be assigned.
 */
$config['user_role_id'] = 1;

// --------------------------------------------------------------------------
/**
 * remember_me_timeout (int)
 *
 * The time, in seconds, that the remember_me cookie lasts.
 */
$config['remember_me_timeout'] = 60 * 60 * 24 * 365;

// --------------------------------------------------------------------------
/**
 * salt_length (int)
 *
 * The length of the salt string to be added to / parsed from the password.
 */
$config['salt_length'] = 64;

// --------------------------------------------------------------------------
/**
 * email from addresses
 *
 * The reply-to email address for registration emails and others.
 */
$config['register_email_from'] =
$config['request_reset_email_from'] =
$config['confirm_reset_email_from'] =
 'admin@test.com';

// --------------------------------------------------------------------------
/**
 * email from names (optional)
 *
 * The reply-to email address name for registration emails and others.
 */
$config['register_email_from_name'] = 
$config['request_reset_email_from_name'] =
$config['confirm_reset_email_from_name'] =
'Admin';

// --------------------------------------------------------------------------
/**
 * register_email_subject
 *
 * The reply-to email address for registration emails.
 */
$config['register_email_subject'] = 'Registration';

// --------------------------------------------------------------------------
/**
 * request_reset_email_subject
 *
 * The reply-to email address for request reset password email.
 */
$config['request_reset_email_subject'] = 'Request for password reset';

// --------------------------------------------------------------------------
/**
 * confirm_reset_email_subject
 *
 * The reply-to email address for confirm reset password email.
 */
$config['confirm_reset_email_subject'] = 'New password';

// --------------------------------------------------------------------------
/**
 * email_register_view
 *
 * The inner view used for sending registration emails.
 */
$config['email_register_view'] = 'email/email_register_view';

// --------------------------------------------------------------------------
/**
 * email_request_reset_view
 *
 * The inner view used for sending registration emails.
 */
$config['email_request_reset_view'] = 'email/email_request_reset_view';

// --------------------------------------------------------------------------
/**
 * email_confirm_reset_view
 *
 * The inner view used for sending registration emails.
 */
$config['email_confirm_reset_view'] = 'email/email_confirm_reset_view';

// --------------------------------------------------------------------------
/**
 * email_template_view
 *
 * The outer view used for sending registration emails.
 */
$config['email_template_view'] = 'email/email_template_view';

// --------------------------------------------------------------------------
/**
 * logged_out_url
 *
 * There to redirect when login_check fails.
 */
$config['logged_out_url'] = 'home/login';

// --------------------------------------------------------------------------
/**
 * logout_success_url
 *
 * There to redirect on logout.
 */
$config['logout_success_url'] = 'home/login';

// --------------------------------------------------------------------------
/**
 * register_success_url
 *
 * There to redirect on register success.
 */
$config['register_success_url'] = 'alert';

// --------------------------------------------------------------------------
/**
 * confirm_register_url
 *
 * The url of the controller method that checks the confirmation email link.
 * without the trailing slash.
 */
$config['confirm_register_url'] = 'home/confirm_register';

// --------------------------------------------------------------------------
/**
 * confirm_register_success_url
 *
 * Where to redirect on confirm success.
 */
$config['confirm_register_success_url'] = 'home/login';

// --------------------------------------------------------------------------
/**
 * confirm_register_fail_url
 *
 * Where to redirect on confirm fail.
 */
$config['confirm_register_fail_url'] = 'home/login';

// --------------------------------------------------------------------------
/**
 * confirm_reset_url
 *
 * The url for the reset password link. Without the trailing slash.
 */
$config['confirm_reset_url'] = 'home/confirm_reset_password';

// --------------------------------------------------------------------------
/**
 * request_reset_success_url
 *
 * Where to redirect on request reset password.
 */
$config['request_reset_success_url'] = 'alert';

// --------------------------------------------------------------------------
/**
 * confirm_reset_success_url
 *
 * Where to redirect on confirm reset password.
 */
$config['confirm_reset_success_url'] = 'home/login_new_password';

// --------------------------------------------------------------------------
/**
 * access_denied_url
 *
 * Where to redirect when a user reaches a page they do not have access to.
 */
$config['access_denied_url'] = 'alert';

// --------------------------------------------------------------------------
/**
 * access_denied_message
 *
 * The notification to save to flashdata when access is denied.
 */
$config['access_denied_message'] = 'You do not have access to view this page.';

// --------------------------------------------------------------------------
/**
 * logged_in_message
 *
 * The notification to save to flashdata when user logs in.
 */
$config['logged_in_message'] = 'You have been logged in.';

// --------------------------------------------------------------------------
/**
 * logged_out_message
 *
 * The notification to save to flashdata when logged out.
 */
$config['logged_out_message'] = 'You have been logged out.';

// --------------------------------------------------------------------------
/**
 * login_required_message
 *
 * The notification to save to flashdata when a user is not logged in but
 * tries to access a page that requires login.
 */
$config['login_required_message'] = 'Please login to continue.';

// --------------------------------------------------------------------------
/**
 * register_success_message
 *
 * The notification to save to flashdata when user succeeds in verifying
 *  registration request.
 */
$config['register_success_message'] = 'A confirmation has been sent to your email address. Please click the link there to continue.';

// --------------------------------------------------------------------------
/**
 * register_success_title
 *
 * Saves to flashdata alert_page_title.
 */
$config['register_success_title'] = 
$config['request_reset_success_title'] = 'Almost Done!';

// --------------------------------------------------------------------------
/**
 * confirm_register_success_message
 *
 * The notification to save to flashdata when user succeeds in verifying
 * registration request.
 */
$config['confirm_register_success_message'] = 'Registration confirmed. Please login.';

// --------------------------------------------------------------------------
/**
 * confirm_register_fail_message
 *
 * The notification to save to flashdata when user fails in verifying
 * registration request.
 */
$config['confirm_register_fail_message'] = 'Registration confirmation failed. Please try logging in. If that does not work, please try registering again.';

// --------------------------------------------------------------------------
/**
 * request_reset_success_message
 *
 * The notification to save to flashdata when user succeeds in requesting a
 * new password.
 */
$config['request_reset_success_message'] = 'A confirmation has been sent to your email address. Please click the link there to reset your password.';

// --------------------------------------------------------------------------
/**
 * request_reset_success_title
 *
 * Saves to flashdata alert_page_title.
 */
$config['request_reset_success_title'] = 'Almost Done!';

// --------------------------------------------------------------------------
/**
 * confirm_reset_success_message
 *
 * The notification to save to flashdata when user succeeds in confirming a
 * new password.
 */
$config['confirm_reset_success_message'] = 'Password reset. Your new password has been emailed to you. Please retrieve it and login.';

// --------------------------------------------------------------------------

/* End of file ci_authentication.php */
/* Location: ./ci_authentication/config/ci_authentication.php */