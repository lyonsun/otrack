<?php $this->load->view('otrack/common/header'); ?>
<?php $this->load->view('otrack/common/navbar'); ?>
<div class="container">
  <?php if ($message): ?>
  <div class="alert alert-<?php if ($status): ?><?php echo $status; ?><?php else: ?>danger<?php endif ?>"><?php echo $message;?></div>
  <?php endif ?>
  <h3 class="page-header"><?php echo $title; ?></h3>
  <div class="row">
    <div class="col-md-offset-2 col-md-8">
      <?php
      $form_attributes = array('id'=>'form-update-customer', 'class'=>'form-update-customer');
      $name = array(
      'id' => 'name',
      'name' => 'name',
      'class' => 'form-control',
      'value' => $this->form_validation->set_value('name', $customer->name),
      'placeholder' => 'Customer Name',
      );
      $phone = array(
      'id' => 'phone',
      'name' => 'phone',
      'class' => 'form-control',
      'value' => $this->form_validation->set_value('phone', $customer->phone),
      'placeholder' => 'Phone Number',
      );
      $address_1 = array(
      'id' => 'address_1',
      'name' => 'address_1',
      'class' => 'form-control',
      'value' => $this->form_validation->set_value('address_1', $customer->address_1),
      'placeholder' => 'Addresss Line 1',
      );
      $address_2 = array(
      'id' => 'address_2',
      'name' => 'address_2',
      'class' => 'form-control',
      'value' => $this->form_validation->set_value('address_2', $customer->address_2),
      'placeholder' => 'Addresss',
      );
      $city = array(
      'id' => 'city',
      'name' => 'city',
      'class' => 'form-control',
      'value' => $this->form_validation->set_value('city', $customer->city),
      'placeholder' => 'City',
      );
      $district = array(
      'id' => 'district',
      'name' => 'district',
      'class' => 'form-control',
      'value' => $this->form_validation->set_value('district', $customer->district),
      'placeholder' => 'County/District',
      );
      $province = array(
      'id' => 'province',
      'name' => 'province',
      'class' => 'form-control',
      'value' => $this->form_validation->set_value('province', $customer->province),
      'placeholder' => 'Province',
      );
      $zipcode = array(
      'id' => 'zipcode',
      'name' => 'zipcode',
      'class' => 'form-control',
      'value' => $this->form_validation->set_value('zipcode', $customer->zipcode),
      'placeholder' => 'Zip Code',
      );
      $submit = array(
      'id' => 'btn-update-customer',
      'name' => 'btn-update-customer',
      'class' => 'btn btn-primary btn-block',
      'type' => 'submit',
      'content' => 'Update',
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
  </div>
</div>
<script>
$(function() {
  $('#form-update-customer').formValidation({
    framework: 'bootstrap',
    locale: 'en',
    icon: {
      valid: 'glyphicon glyphicon-ok',
      invalid: 'glyphicon glyphicon-remove',
      validating: 'glyphicon glyphicon-refresh'
    },
    err: {
      container: 'tooltip'
    },
    fields: {
      name: {
        validators: {
          notEmpty: {},
        }
      },
      phone: {
        validators: {
          notEmpty: {},
        }
      },
      address_1: {
        validators: {
          notEmpty: {},
        }
      },
      district: {
        validators: {
          notEmpty: {},
        }
      },
      city: {
        validators: {
          notEmpty: {},
        }
      },
      province: {
        validators: {
          notEmpty: {},
        }
      },
    },
  });
});
</script>
<?php $this->load->view('otrack/common/footer'); ?>
