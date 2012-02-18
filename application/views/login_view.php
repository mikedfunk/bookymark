<section>
<div class="container">
<?php /*<div class="row">
<div class="span16"> */ ?>
<?=form_open('home/login', array('id' => 'login_form', 'class' => 'form-horizontal'))?>
        <div class="page-header">
          <h1>Please Login</h1>
          </div><!--page-header-->
<div class="alert_wrap">

<?php
// logged out notification
if ($this->input->get('notification') == 'logged_out'):
?>
<div class="alert alert-error fade in" data-dismiss="alert"><a class="close" href="#">&times;</a>Please login to continue.</div>
<?php endif; ?>

<?php
// logout success notification
if ($this->input->get('notification') == 'logout_success'):
?>
<div class="alert alert-success fade in" data-dismiss="alert"><a class="close" href="#">&times;</a>You have been logged out.</div>
<?php endif; ?>
<?php
// logout success notification
if (validation_errors() != ''):
?>
<div class="alert alert-error fade in" data-dismiss="alert"><a class="close" href="#">&times;</a>Please correct the highlighted errors.</div>
<?php endif; ?>

</div>
<div class="control-group form_item <?=(form_error('email_address') != '' ? 'error' : '')?>">
            <?=form_label('Email Address:', 'email_address_field', array('class' => 'control-label'))?>
            <div class="controls">
              <?=form_input(array('name' => 'email_address', 'id' => 'email_address_field', 'class' => 'span3', 'value' => get_cookie('email_address')))?>
              <?=form_error('email_address')?>
            </div><!--controls-->
          </div><!--control-group-->
          
<div class="control-group form_item <?=(form_error('password') != '' ? 'error' : '')?>">
            <?=form_label('Password', 'password_field', array('class' => 'control-label'))?>
            <div class="controls">
              <?=form_password(array('name' => 'password', 'id' => 'password_field', 'class' => 'span3', 'value' => get_cookie('password')))?>
              <?=form_error('password')?>
            </div><!--controls-->
</div><!--control-group-->

          <fieldset class="form-actions">
          <button type="submit" class="btn btn-primary login save_and_back">Login</button>
          </fieldset><!--form-actions-->
</form>
<?php /* </div><!--span-->
</div><!--row--> */ ?>
</div><!--container-->
</section>