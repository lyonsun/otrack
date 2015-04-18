<?php $this->load->view('otrack/common/header'); ?>
<?php $this->load->view('otrack/common/navbar'); ?>

<div class="container">

  <?php 
  $form_attributes = array('id'=>'form-create-order', 'class'=>'form-create-order');

  $sender_name = array(
    'id' => 'sender_name',
    'name' => 'sender_name',
    'class' => 'form-control',
    'placeholder' => 'Sender Name',
  );

  $sender_phone = array(
    'id' => 'sender_phone',
    'name' => 'sender_phone',
    'class' => 'form-control',
    'placeholder' => 'Sender Phone',
  );

  $receiver_name = array(
    'id' => 'receiver_name',
    'name' => 'receiver_name',
    'class' => 'form-control',
    'placeholder' => 'Receiver Name',
  );

  $receiver_phone = array(
    'id' => 'receiver_phone',
    'name' => 'receiver_phone',
    'class' => 'form-control',
    'placeholder' => 'Receiver Phone',
  );

  $submit = array(
    'id' => 'btn-create-order',
    'name' => 'btn-create-order',
    'class' => 'btn btn-primary',
    'content' => 'Create',
  );
   ?>

  <?php echo form_open($this->uri->uri_string(), $form_attributes); ?>

  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">Sender Information</h3>
    </div>
    <div class="panel-body">
      <div class="form-group">
        <?php echo form_label('Sender Name', 'sender_name', array('class'=>'control-label')); ?>
        <?php echo form_input($sender_name); ?>
      </div>

      <div class="form-group">
        <?php echo form_label('Sender Phone Number', 'sender_phone', array('class'=>'control-label')); ?>
        <?php echo form_input($sender_phone); ?>
      </div>
    </div>
  </div>

  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">Receiver Information</h3>
    </div>
    <div class="panel-body">
      <div class="form-group">
        <?php echo form_label('Receiver Name', 'receiver_name', array('class'=>'control-label')); ?>
        <?php echo form_input($receiver_name); ?>
      </div>

      <div class="form-group">
        <?php echo form_label('Receiver Phone Number', 'receiver_phone', array('class'=>'control-label')); ?>
        <?php echo form_input($receiver_phone); ?>
      </div>
    </div>
  </div>

  <?php echo form_button($submit); ?>
  <?php echo form_close(); ?>
</div>

<?php $this->load->view('otrack/common/footer'); ?>