<?php $this->load->view('otrack/common/header'); ?>
<?php $this->load->view('otrack/common/navbar'); ?>

<div class="container">
  <?php if ($message): ?>
  <div class="alert alert-<?php if ($status): ?><?php echo $status; ?><?php else: ?>danger<?php endif ?>"><?php echo $message;?></div>
  <?php endif ?>
  <h3 class="page-header">Create Customer</h3>
  <?php
  $form_attributes = array('id'=>'form-create-order', 'class'=>'form-create-order');
  $name = array(
  'id' => 'name',
  'name' => 'name',
  'class' => 'form-control',
  'placeholder' => 'Customer Name',
  );
  $phone = array(
  'id' => 'phone',
  'name' => 'phone',
  'class' => 'form-control',
  'placeholder' => 'Phone Number',
  );
  $address_1 = array(
  'id' => 'address_1',
  'name' => 'address_1',
  'class' => 'form-control',
  'placeholder' => 'Addresss Line 1',
  );
  $address_2 = array(
  'id' => 'address_2',
  'name' => 'address_2',
  'class' => 'form-control',
  'placeholder' => 'Addresss',
  );
  $city = array(
  'id' => 'city',
  'name' => 'city',
  'class' => 'form-control',
  'placeholder' => 'City',
  );
  $district = array(
  'id' => 'district',
  'name' => 'district',
  'class' => 'form-control',
  'placeholder' => 'County/District',
  );
  $province = array(
  'id' => 'province',
  'name' => 'province',
  'class' => 'form-control',
  'placeholder' => 'Province',
  );
  $zipcode = array(
  'id' => 'zipcode',
  'name' => 'zipcode',
  'class' => 'form-control',
  'placeholder' => 'Zip Code',
  );
  $submit = array(
  'id' => 'btn-create-customer',
  'name' => 'btn-create-customer',
  'class' => 'btn btn-primary',
  'type' => 'submit',
  'content' => 'Create',
  );
  ?>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">Customer Information</h3>
    </div>
    <div class="panel-body">
      <?php echo form_open(base_url($this->uri->uri_string()), $form_attributes); ?>
      <div class="form-group">
        <?php echo form_label('Customer Name', 'name', array('class'=>'control-label')); ?>
        <?php echo form_input($name); ?>
      </div>
      <div class="form-group">
        <?php echo form_label('Phone Number', 'phone', array('class'=>'control-label')); ?>
        <?php echo form_input($phone); ?>
      </div>
      <div class="form-group">
        <?php echo form_label('Address 1', 'address_1', array('class'=>'control-label')); ?>
        <?php echo form_input($address_1); ?>
      </div>
      <div class="form-group">
        <?php echo form_label('Address 2', 'address_2', array('class'=>'control-label')); ?>
        <?php echo form_input($address_2); ?>
      </div>
      <div class="form-group">
        <?php echo form_label('County/District', 'district', array('class'=>'control-label')); ?>
        <?php echo form_input($district); ?>
      </div>
      <div class="form-group">
        <?php echo form_label('City', 'city', array('class'=>'control-label')); ?>
        <?php echo form_input($city); ?>
      </div>
      <div class="form-group">
        <?php echo form_label('Province', 'province', array('class'=>'control-label')); ?>
        <?php echo form_input($province); ?>
      </div>
      <div class="form-group">
        <?php echo form_label('Zip Code', 'zipcode', array('class'=>'control-label')); ?>
        <?php echo form_input($zipcode); ?>
      </div>
      <div class="form-group">
        <?php echo form_button($submit); ?>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>
<?php $this->load->view('otrack/common/footer'); ?>