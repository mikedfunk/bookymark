<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * bookmark_view
 * 
 * Add or Edit bookmark view.
 * 
 * @license		http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @author		Mike Funk
 * @link		http://mikefunk.com
 * @email		mike@mikefunk.com
 * 
 * @file		bookmark_view.php
 * @version		1.3.1
 * @date		03/12/2012
 */

// --------------------------------------------------------------------------
?>
<section>
<div class="container">
<div class="page-header">
<h1><?=(isset($item) ? 'Edit' : 'Add')?> Bookmark <small>Items with a * are required</small></h1>
</div><!--page-header-->
<?php
$hidden = (isset($item) ? array('id' => $item->id) : '');
?>
<?=form_open('', array('class' => 'form-horizontal'), $hidden)?>

<div class="control-group form_item <?=(form_error('url') != '' ? 'error' : '')?>">
            <?=form_label('URL: *', 'url_field', array('class' => 'control-label'))?>
            <div class="controls">
<?php
// form value
if (set_value('url') != '') {$value = set_value('url');}
else {$value = (isset($item) ? $item->url : '');}
?>
              <?=form_input(array('name' => 'url', 'id' => 'url_field', 'class' => 'span3', 'value' => $value))?>
              <?=form_error('url')?>
            </div><!--controls-->
          </div><!--control-group-->
          
<div class="control-group form_item <?=(form_error('description') != '' ? 'error' : '')?>">
            <?=form_label('Description:', 'description_field', array('class' => 'control-label'))?>
            <div class="controls">
<?php
// form value
if (set_value('description') != '') {$value = set_value('description');}
else {$value = (isset($item) ? $item->description : '');}
?>
              <?=form_textarea(array('name' => 'description', 'id' => 'description_field', 'class' => 'span3', 'value' => $value, 'rows' => 3))?>
              <?=form_error('description')?>
            </div><!--controls-->
          </div><!--control-group-->

<fieldset class="form-actions">
<button type="submit" class="btn btn-success"><i class="icon-ok icon-white"></i> Save</button>
<a href="<?=base_url()?>bookmarks/cancel?redirect=bookmarks/list_items" class="btn btn-danger"><i class="icon-remove icon-white"></i> Cancel</a>
</fieldset><!--form-actions-->
</form>

</div><!--container-->
</section>