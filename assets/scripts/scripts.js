/**
 * scripts.js
 * 
 * Description
 * 
 * @license		Copyright Mike Funk. All Rights Reserved.
 * @author		Mike Funk
 * @link		http://mikefunk.com
 * @email		mike@mikefunk.com
 * 
 * @file		scripts.js
 * @version		1.0
 * @date		02/08/2012
 * 
 * Copyright (c) 2012
 */

// --------------------------------------------------------------------------

/**
 * notify function.
 *
 * notification with bootstrap
 * 
 * @param string text
 * @param string type
 * @return void
 */
var notify = function(text, type)
{
	// fix text
	text = text.replace(/\&amp\;/g, '&');
	text = $("<div/>").html(text).text();
	
	// types: error, warning, success, info
	type = type || 'error';
	
	// set template and add
	var template = '<div class="alert alert-'+type+' fade in hide" data-dismiss="alert"><a class="close" href="#">&times;</a>'+text+'</div>';
    
	// append, scroll, fade in
    $('.alert_wrap').append(template);
    $('body').scrollTop('0');
    $('.notification_wrap > .alert:last').fadeIn('fast');
}

// --------------------------------------------------------------------------
// !tested
/**
 * loading_in function.
 * 
 * @return void
 */
var loading_in = function($this)
{
	if ($this !== undefined)
	{
		var the_html = $this.html();
		$this.data('the_content', the_html);
		$this.addClass('disabled');
		$this.html('Loading...');
	}
}

// --------------------------------------------------------------------------
// !tested
/**
 * loading_out function.
 * 
 * @return void
 */
var loading_out = function($this)
{
	if ($this !== undefined)
	{
		var content = $this.data('the_content');
		$this.html(content);
		$this.removeClass('disabled');
	}
}

// --------------------------------------------------------------------------

/**
 * ajax setup
 */
$.ajaxSetup({
	error:function (xhr, ajaxOptions, thrownError)
	{
        if (xhr.status === 404) 
        {
        	notify('Error: page not found.');
        }
        else if (xhr.status === 500)
        {
        	notify('Uh oh! A communications error occurred. <a href="mailto:mfunk@xulonpress.com" class="follow_link">Let Mike know</a>!');
        }
//         console.log('status: ' + xhr.status);
//         console.log('status text: ' + xhr.statusText);
//         console.log('response text: ' + xhr.responseText);
    }
});

// --------------------------------------------------------------------------

/* End of file scripts.js */
/* Location: ./bookymark/assets/scripts/scripts.js */