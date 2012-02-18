<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * MY_Form_validation
 * 
 * Description
 * 
 * @license		Copyright Xulon Press, Inc. All Rights Reserved.
 * @author		Xulon Press
 * @link		http://xulonpress.com
 * @email		info@xulonpress.com
 * 
 * @file		MY_Form_validation.php
 * @version		1.0
 * @date		02/17/2012
 * 
 * Copyright (c) 2012
 */

// --------------------------------------------------------------------------

/**
 * MY_Form_validation class.
 * 
 * @extends CI_Form_validation
 */
class MY_Form_validation extends CI_Form_validation 
{
	// --------------------------------------------------------------------------
	
    /**
     * __construct function.
     * 
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->_error_prefix = '<span class="help-inline error">';
        $this->_error_suffix    = '</span>';
    }
    
    // --------------------------------------------------------------------------
}
/* End of file MY_Form_validation.php */
/* Location: ./bookymark/application/libraries/MY_Form_validation.php */