<?php $this->load->view('otrack/common/header'); ?>
<?php $this->load->view('otrack/common/navbar'); ?>

<div class="container">
  <?php if ($message): ?>
  <div class="alert alert-<?php if ($status): ?><?php echo $status; ?><?php else: ?>danger<?php endif ?>"><?php echo $message;?></div>
  <?php endif ?>
  <h3 class="page-header"><?php echo $title; ?></h3>

  <div class="panel panel-default">
    <div class="panel-body">
      <h4><?php echo $order->buyer_name; ?></h4>
      <p><?php echo $buyer_info; ?></p>
    </div>
    <div class="panel-body bg-primary">
      <b>Products</b>
    </div>
    <ul class="list-group">
    <?php if ($order_products): ?>
      <?php foreach ($order_products as $product): ?>
      <li class="list-group-item">
        <span class="progress-bar-success badge"><?php echo $product->product_amount; ?></span>
        <?php echo $product->product_title; ?>
      </li>          
      <?php endforeach ?>
    <?php endif ?>
    </ul>
  </div>

  <?php 
  $form_attributes = array(
    'id' => 'form-edit-order',
    'class' => 'form-edit-order',
  );

  $express_name = array(
    'id' => 'express_name',
    'name' => 'express_name',
    'class' => 'form-control',
    'placeholder' => 'Express Name',
    'value' => set_value('express_name') ? set_value('express_name') : $order->express_name,
    'size' => 30,
    'maxlength' => 30,
  );

  $tracking_number = array(
    'id' => 'tracking_number',
    'name' => 'tracking_number',
    'class' => 'form-control',
    'placeholder' => 'Tracking Number',
    'value' => set_value('tracking_number') ? set_value('tracking_number') : $order->tracking_number,
    'size' => 30,
    'maxlength' => 30,
  );

  $submit = array(
    'id' => 'btn-edit-order',
    'class' => 'btn btn-primary btn-block',
    'value' => 'Submit',
  );

   ?>

  <?php echo form_open(base_url($this->uri->uri_string()), $form_attributes); ?>
  <div class="form-group">
    <?php echo form_label('Express Name', 'express_name', array('class'=>'control-label')); ?>
    <?php echo form_input($express_name); ?>
  </div>
  <div class="form-group">
    <?php echo form_label('Tracking Number', 'tracking_number', array('class'=>'control-label')); ?>
    <?php echo form_input($tracking_number); ?>
  </div>
  <div class="form-group">
    <?php echo form_submit($submit); ?>
  </div>

  <?php echo form_close(); ?>

</div>

<?php $this->load->view('otrack/common/js'); ?>

<script>
  $(function() {
    $('#form-edit-order')
    .formValidation({
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
        tracking_number: {
          validators: {
            notEmpty: {},
            digits: {},
            stringLength: {
                message: 'Tracking # must be at least 10 digits.',
                min: 10,
            }
          }
        },
      },
    })
  });
</script>

<?php $this->load->view('otrack/common/footer'); ?>