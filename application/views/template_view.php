<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * template_view
 * 
 * The wrapper view for pretty much everything.
 * 
 * @license		http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @author		Mike Funk
 * @link		http://mikefunk.com
 * @email		mike@mikefunk.com
 * 
 * @file		template_view.php
 * @version		1.3.1
 * @date		03/12/2012
 */

// --------------------------------------------------------------------------
?>
<!DOCTYPE html>
<html lang="en" class="">
  <head>
    <meta charset="utf-8">
    <title><?=(isset($title)?$title:'Bookymark! Save your bookmarks.')?></title>
    <meta name="description" content="<?=(isset($description)?$description:'')?>">
    <meta name="author" content="<?=(isset($author)?$author:'')?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

<?php
// assets

// $this->carabiner->css('twitter_bootstrap/less/bootstrap.less');
$this->carabiner->css('twitter_bootstrap/docs/assets/css/bootstrap.css');
$this->carabiner->css('twitter_bootstrap/docs/assets/css/bootstrap-responsive.css');

$this->carabiner->css('styles/styles.less');
// require_once(FCPATH_U.APPPATH_U.'third_party/carabiner/libraries/less_php/lessc.inc.php');
// lessc::ccompile(FCPATH_U.'assets/styles/styles.less', FCPATH_U.'assets/cache/styles.css');
// $this->carabiner->css('cache/styles.css');

// remote jquery
$this->carabiner->js('http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js');
// local jquery
// $this->carabiner->js('scripts/jquery-1.7.min.js');
$this->carabiner->js('twitter_bootstrap/js/bootstrap-alert.js');
$this->carabiner->js('twitter_bootstrap/js/bootstrap-carousel.js');
$this->carabiner->js('scripts/actions.js');
$this->carabiner->js('scripts/scripts.js');
$this->carabiner->display();
?>

    <!-- HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

	<!--[if IE]><![endif]-->
	
    <!-- fav and touch icons -->
<?php /*
    <link rel="shortcut icon" href="<?=base_url()?>assets/images/favicon.ico">
    <link rel="apple-touch-icon" href="<?=base_url()?>assets/images/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?=base_url()?>assets/images/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?=base_url()?>assets/images/apple-touch-icon-114x114.png">
*/ ?>
  </head>
  <body>

<div class="navbar navbar-fixed-top">
<div class="navbar-inner">
    <div class="fill">
      <div class="container">
        <a class="brand" href="<?=base_url()?>">Bookymark <?php /*<sup>&reg;</sup> */ ?></a>
<?php
// logged in text
if (is_callable('auth_username')):
	if (auth_username() !== FALSE):
?>
<p class="navbar-text pull-right"><i class="icon-user icon-white"></i> Logged in as <strong><?=auth_username()?></strong>. <i class="icon-share icon-white"></i> <a href="<?=base_url()?>auth/logout">Logout</a></p>
<?php 
	endif; 
endif;
?>
        </div><!--container-->
        </div><!--fill-->
        </div><!--navbar-inner-->
</div><!--navbar-->


  <?=$content?>
  <footer>
<div class="footer">
<hr />
<div class="container">
<p><a href="http://www.apache.org/licenses/LICENSE-2.0">Apache License 2.0</p>
</div><!--container-->
</div><!--footer-->
</footer>
<a href="https://github.com/mikedfunk/bookymark"><img style="position: fixed; z-index: 9999; top: 0; right: 0; border: 0;" src="https://a248.e.akamai.net/assets.github.com/img/e6bef7a091f5f3138b8cd40bc3e114258dd68ddf/687474703a2f2f73332e616d617a6f6e6177732e636f6d2f6769746875622f726962626f6e732f666f726b6d655f72696768745f7265645f6161303030302e706e67" alt="Fork me on GitHub"></a>
  </body>
</html>
<?php
/* End of file template_view.php */
/* Location: ./bookymark/application/views/template_view.php */