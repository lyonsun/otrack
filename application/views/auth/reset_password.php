<?php $this->load->view('auth/common/header'); ?>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-offset-3 col-md-6">      
      <div class="panel panel-default">
        <div class="panel-heading">
          <h1 class="panel-title"><?php echo lang('reset_password_heading');?></h1>
        </div>
        <div class="panel-body">
          <p class="text-muted"><?php echo sprintf(lang('forgot_password_subheading'), $identity_label);?></p>
          <hr>
          <?php if ($message): ?>
          <div class="alert alert-<?php if ($status): ?><?php echo $status; ?><?php else: ?>danger<?php endif ?>"><?php echo $message;?></div>
          <?php endif ?>
          <?php
          $form_attributes = array(
          'id' => 'form-reset-password',
          'class' => '',
          );
          $new_password['class'] = $new_password_confirm['class'] = 'form-control';
          $submit = array(
            'class' => 'btn btn-success btn-block',
            'id' => 'btn-reset-password',
            'type' => 'submit',
            'content' => '<i class="fa fa-fw fa-send"></i> '.lang('reset_password_submit_btn'),
          );
          ?>
          <?php echo form_open(base_url('auth/reset_password')."/".$code, $form_attributes);?>
          <div class="form-group">
            <?php echo form_label(sprintf(lang('reset_password_new_password_label'),$min_password_length),'new_password',array('class'=>'control-label')); ?>
            <?php echo form_input($new_password); ?>
          </div>
          <div class="form-group">
            <?php echo form_label(lang('reset_password_new_password_confirm_label'),'new_password_confirm',array('class'=>'control-label')); ?>
            <?php echo form_input($new_password_confirm); ?>
          </div>
          <div class="form-group">
						<?php echo form_input($user_id);?>
						<?php echo form_hidden($csrf); ?>
            <?php echo form_button($submit);?>
          </div>
          <?php echo form_close();?>          
        </div>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view('auth/common/footer'); ?>