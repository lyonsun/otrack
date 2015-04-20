<?php $this->load->view('otrack/common/header'); ?>
<?php $this->load->view('otrack/common/navbar'); ?>
<div class="container">
  <div class="row">
    <div class="col-md-offset-3 col-md-6">      
      <div class="panel panel-default">
        <div class="panel-heading">
          <h1 class="panel-title"><?php echo lang('forgot_password_heading');?></h1>
        </div>
        <div class="panel-body">
          <p class="text-muted"><?php echo sprintf(lang('forgot_password_subheading'), $identity_label);?></p>
          <hr>
          <?php if ($message): ?>
          <div class="alert alert-<?php if ($status): ?><?php echo $status; ?><?php else: ?>danger<?php endif ?>"><?php echo $message;?></div>
          <?php endif ?>
          <?php
          $form_attributes = array(
          'id' => 'form-forgot-password',
          'class' => '',
          );
          $email['class'] = $password['class'] = 'form-control';
          $submit = array(
            'class' => 'btn btn-success btn-block',
            'id' => 'btn-forgot-password',
            'type' => 'submit',
            'content' => '<i class="fa fa-fw fa-send"></i> '.lang('forgot_password_submit_btn'),
          );
          ?>
          <?php echo form_open(base_url('forgot_password'), $form_attributes);?>
          <div class="form-group">
            <?php echo form_label(sprintf(lang('forgot_password_email_label'),$identity_label),'email',array('class'=>'control-label')); ?>
            <?php echo form_input($email); ?>
          </div>
          <div class="form-group">
            <?php echo form_button($submit);?>
          </div>
          <?php echo form_close();?>          
        </div>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view('otrack/common/footer'); ?>