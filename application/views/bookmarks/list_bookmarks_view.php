<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * list_bookmarks_view
 * 
 * Shows a list of bookmarks paginated.
 * 
 * @license		http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @author		Mike Funk
 * @link		http://mikefunk.com
 * @email		mike@mikefunk.com
 * 
 * @file		list_bookmarks_view.php
 * @version		1.3.1
 * @date		03/12/2012
 */

// --------------------------------------------------------------------------
?>
    <section>
        <div class="container">
            <div class="page-header">
                <h1>My Bookymarks <small>Hover over a row for more options</small></h1>
            </div><!--page-header-->
			<div class="notification_wrap">

<?=$this->ci_alerts->display()?>

			</div><!--notification_wrap-->
			
<form method="get" accept-charset="utf-8" action="<?=base_url() . uri_query_string()?>" class="form-inline well" />
<?php if ($user->can_add_bookmarks): ?>
<a class="btn btn-success pull-right" href="<?=base_url()?>bookmarks/add_item?return_url=<?=urlencode(uri_query_string())?>"><i class="icon-plus icon-white"></i> New Contest Entry</a>
<?php endif; ?>
<input type="text" name="filter" value="<?=$this->input->get('filter')?>" placeholder="Search..." id="filter_field" class="search-query" data-provide="typeahead" data-items="4" data-source='["dork"]'>
<button type="submit" class="btn"><i class="icon-search"></i> Search</button>
</form>
            <?php
            // loop through bookmarks
            if ($bookmarks->num_rows() > 0):
                $result = $bookmarks->result();
            ?>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>URL</th>

                        <th>Description</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead><?php 
                    foreach ($result as $item):
                ?>

                <tr>
                    <td><?=$item->url?></td>

                    <td><?=$item->description?></td>
                    <td><div class="actions pull-right">
<?php
// if permission allows
if ($this->session->userdata('can_edit_bookmarks')):
?>
                    <a href="<?=base_url()?>bookmarks/edit_item/<?=$item->id?>" class="btn btn-mini"><i class="icon-edit"></i> Edit</a> 
<?php endif; 
// if permission allows
if ($this->session->userdata('can_delete_bookmarks')):
?>       
                    <a href="<?=base_url()?>bookmarks/delete_item/<?=$item->id?>" class="btn btn-mini"><i class="icon-trash"></i> Delete</a>
<?php endif; ?>
                    </div><!--actions--></td>
                </tr><?php 
                    endforeach; // foreach result as item
                ?>
            </table>
			<?=$this->pagination->create_links()?>
            <?php
            else: // else bookmarks num rows is zero
            ?>

            <div class="alert alert-error ">
                No bookymarks found. Add one!
            </div><?php
            endif; // if ($bookmarks->num_rows() > 0):
            ?>
        </div><!--container-->
    </section>
<?php
/* End of file list_bookmarks_view.php */
/* Location: ./bookymark/application/views/list_bookmarks_view.php */