<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * authentication_helper
 * 
 * Description
 * 
 * @license		Copyright Xulon Press, Inc. All Rights Reserved.
 * @author		Xulon Press
 * @link		http://xulonpress.com
 * @email		info@xulonpress.com
 * 
 * @file		authentication_helper.php
 * @version		1.0
 * @date		02/17/2012
 * 
 * Copyright (c) 2012
 */

// --------------------------------------------------------------------------

/**
 * auth_username function.
 * 
 * @access public
 * @return void
 */
function auth_username()
{
	$_ci =& get_instance();
	$_ci->load->library('session');
	$_ci->config->load('authentication_config');
	
	return $_ci->session->userdata(config_item('username_field'));
}

// --------------------------------------------------------------------------

/**
 * auth_password function.
 * 
 * @access public
 * @return void
 */
function auth_password()
{
	$_ci =& get_instance();
	$_ci->load->library('session');
	$_ci->config->load('authentication_config');
	
	return $_ci->session->userdata(config_item('password_field'));
}

// --------------------------------------------------------------------------

/* End of file authentication_helper.php */
/* Location: ./bookymark/application/third_party/authentication/helpers/authentication_helper.php */