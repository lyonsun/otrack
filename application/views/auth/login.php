<?php $this->load->view('otrack/common/header'); ?>
<?php $this->load->view('otrack/common/navbar'); ?>
<div class="container">
  <div class="row">
    <div class="col-md-offset-3 col-md-6">      
      <div class="panel panel-default">
        <div class="panel-heading">
          <h1 class="panel-title"><?php echo lang('login_heading');?></h1>
        </div>
        <div class="panel-body">
          <p class="text-muted page-header"><?php echo lang('login_subheading');?></p>
          <?php if ($message): ?>
          <div class="alert alert-<?php if ($status): ?><?php echo $status; ?><?php else: ?>danger<?php endif ?>"><?php echo $message;?></div>
          <?php endif ?>
          <?php
          $form_attributes = array(
          'id' => 'form-login',
          'class' => 'col-md-offset-1 col-md-10 col-sm-offset-2 col-sm-8',
          );
          $identity['class'] = $password['class'] = 'form-control';
          $submit = array(
            'class' => 'btn btn-success btn-block',
            'id' => 'btn-login',
            'type' => 'submit',
            'content' => '<i class="fa fa-fw fa-sign-in"></i> '.lang('login_submit_btn'),
          );
          ?>
          <?php echo form_open(base_url('login'), $form_attributes);?>
          <div class="form-group">
            <?php echo form_label(lang('login_identity_label', 'identity'),'identity',array('class'=>'control-label')); ?>
            <?php echo form_input($identity); ?>
          </div>
          <div class="form-group">
            <?php echo form_label(lang('login_password_label', 'password'),'password',array('class'=>'control-label')); ?>
            <p class="pull-right"><a href="<?php echo base_url('forgot_password'); ?>"><?php echo lang('login_forgot_password');?></a></p>
            <?php echo form_input($password); ?>
          </div>
          <div class="form-group">
            <?php echo form_label(form_checkbox('remember', '1', FALSE, 'id="remember"').lang('login_remember_label', 'remember'),'remember',array('class'=>'control-label')); ?>
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