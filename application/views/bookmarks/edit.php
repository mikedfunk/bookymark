<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * edit bookmark view
 *
 * @author Mike Funk
 * @email mfunk@christianpublishing.com
 *
 * @file edit.php
 */
// --------------------------------------------------------------------------
$this->data['title'] = (isset($this->bookmark) ? 'Edit Bookymark' : 'New Bookymark');
?>
<section>
  <div class="container">
    <ul class="breadcrumb">
      <li><a href="<?=base_url()?>">Home</a> <span class="divider">&rarr;</span></li>
      <li><a href="<?=base_url('bookmarks')?>">Bookmarks</a> <span class="divider">&rarr;</span></li>
      <?=$bookmark->active_breadcrumb()?>
    </ul>
    <div class="page-header">
      <h1><?=$bookmark->title()?> <small>Items with a * are required</small></h1>
    </div><!--page-header-->
    <?=$this->ci_alerts->display()?>
    <?=$bookmark->form_open()?>
      <?=$bookmark->url_field()?>
      <?=$bookmark->description_field()?>
      <div class="form-actions">
        <button type="submit" class="btn btn-success"><i class="icon-ok icon-white"></i> Save</button>
        <a href="/bookmarks/cancel" class="btn btn-danger"><i class="icon-remove icon-white"></i> Cancel</a>
      </div><!--form-actions-->
    </form>
  </div><!--container-->
</section>
<?php
/* End of file edit.php */
/* Location: ./application/views/bookmarks/edit.php */