<?php $this->load->view('otrack/common/header'); ?>
<?php $this->load->view('otrack/common/navbar'); ?>

<div class="container">
  <?php if ($message): ?>
  <div class="alert alert-<?php if ($status): ?><?php echo $status; ?><?php else: ?>danger<?php endif ?>"><?php echo $message;?></div>
  <?php endif ?>
  <h3 class="page-header"><?php echo $title; ?></h3>

  <?php 
  $form_attributes = array('id'=>'form-edit-order', 'class'=>'form-horizontal form-edit-order');

  $buyer_options = array(''=>'');
  if ($customers) {
    foreach ($customers as $customer) {
      $address = array($customer->province,$customer->city,$customer->district,$customer->address_1);
      if (!empty($customer->address_2)) {
        $address[] = $customer->address_2;
      }
      if (!empty($customer->zipcode)) {
        $address[] = $customer->zipcode;
      }
      $buyer_options[$customer->id] = $customer->name.' - ['.implode(', ', $address).']';
    }
  }

  $buyer = array(
    'id' => 'buyer',
    'name' => 'buyer',
    'class' => 'form-control',
    'options' => $buyer_options,
    'selected' => $order->buyer_id,
  );

  $product_options = array(
    'Orange' => 'Orange',
    'Apple' => 'Apple',
    'Peach' => 'Peach',
    'Cherry' => 'Cherry',
  );

  $products = array(
    'id' => 'products',
    'name' => 'products[]',
    'class' => 'form-control',
    'options' => $product_options,
    'multiple' => 'multiple',
  );

  $international = array(
    'id' => 'international',
    'name' => 'type',
    'value' => '1',
    'checked' => $order->type == 1,
  );

  $domestic = array(
    'id' => 'domestic',
    'name' => 'type',
    'value' => '2',
    'checked' => $order->type == 2,
  );

  $express_name = array(
    'id' => 'express_name',
    'name' => 'express_name',
    'class' => 'form-control',
    'options' => array(
      '' => '',
      '顺丰速运' => '顺丰速运',
      '圆通速递' => '圆通速递',
      '百世汇通' => '百世汇通',
      '申通快递' => '申通快递',
      '中通快递' => '中通快递',
      '韵达快递' => '韵达快递',
      '天天快递' => '天天快递',
      '国际包裹' => '国际包裹',
      'EMS' => 'EMS',
    ),
    'selected' => $order->express_name,
  );

  $delivery_time = array(
    'id' => 'delivery_time',
    'name' => 'delivery_time',
    'class' => 'form-control',
    'value' => date('Y-m-d', strtotime($order->est_delivery_time)),
  );

  $comments = array(
    'id' => 'comments',
    'name' => 'comments',
    'class' => 'form-control',
    'placeholder' => 'E.g. Address is wrong, using the following address...',
    'value' => $order->comments,
  );

  $submit = array(
    'id' => 'btn-edit-order',
    'class' => 'btn btn-primary btn-block',
    'content' => 'Add',
    'type' => 'submit',
  );
   ?>

  <?php echo form_open(base_url($this->uri->uri_string()), $form_attributes); ?>

  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">Order Information</h3>
    </div>
    <div class="panel-body">
      <div class="form-group">
        <?php echo form_label('Receiver', 'buyer', array('class'=>'col-xs-2 control-label')); ?>
        <div class="col-xs-9">
        <?php echo form_dropdown($buyer); ?>
        </div>
      </div>

      <?php foreach ($order_products as $key => $order_product): ?>
      <div class="form-group">
        <?php if ($key == 0): ?>
        <label class="col-xs-2 control-label">Products</label>
        <div class="col-xs-6">
        <?php else: ?>
        <div class="col-xs-6 col-xs-offset-2">
        <?php endif ?>
          <input type="text" class="form-control" name="product[<?php echo $key; ?>][title]" value="<?php echo $order_product->product_title; ?>" />
        </div>
        <div class="col-xs-3">
          <input type="text" class="form-control" name="product[<?php echo $key; ?>][amount]" value="<?php echo $order_product->product_amount; ?>" />
        </div>
        <div class="col-xs-1">
          <?php if ($key == 0): ?>
          <button type="button" class="btn btn-default addButton"><i class="fa fa-plus"></i></button>
          <?php else: ?>
          <button type="button" class="btn btn-default removeButton"><i class="fa fa-minus"></i></button>
          <?php endif ?>
        </div>
      </div>
        
      <?php endforeach ?>

      <!-- The template for adding new field -->
      <div class="form-group hide" id="productTemplate">
        <div class="col-xs-6 col-xs-offset-2">
          <input type="text" class="form-control title" placeholder="Title" />
        </div>
        <div class="col-xs-3">
          <input type="text" class="form-control amount" placeholder="Amount" />
        </div>
        <div class="col-xs-1">
          <button type="button" class="btn btn-default removeButton"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <div class="form-group">
        <div class="col-xs-2 text-right"><b>Type</b></div>
        <div class="col-xs-9">
        <?php echo form_label(form_radio($international).'International', '', array('class'=>'radio-inline')); ?>
        <?php echo form_label(form_radio($domestic).'Domestic', '', array('class'=>'radio-inline')); ?>
        </div>
      </div>
      <div class="form-group">
        <?php echo form_label('Est. Delivery Date', 'delivery_time', array('class'=>'col-xs-2 control-label')); ?>
        <div class="col-xs-9">
        <?php echo form_input($delivery_time); ?>
        </div>
      </div>
      <div class="form-group">
        <?php echo form_label('Express Name', 'express_name', array('class'=>'col-xs-2 control-label')); ?>
        <div class="col-xs-9">
        <?php echo form_dropdown($express_name); ?>
        </div>
      </div>
      <div class="form-group">
        <?php echo form_label('Comments', 'comments', array('class'=>'col-xs-2 control-label')); ?>
        <div class="col-xs-9">
        <?php echo form_input($comments); ?>
        </div>
      </div>
      <div class="form-group">
        <div class="col-xs-offset-2 col-xs-9">
        <?php echo form_hidden('status', '1'); ?>
        <?php echo form_button($submit); ?>
        </div>
      </div>
    </div>
  </div>

  <?php echo form_close(); ?>
</div>

<?php $this->load->view('otrack/common/js'); ?>

<script src="<?php echo base_url(); ?>static/bs-dp3/js/bootstrap-datepicker.min.js"></script>
<script>
  $(function() {
    $('#buyer').select2({
      placeholder: 'Select a receiver',
    });
    $('#express_name').select2({
      placeholder: 'Select a express',
    });
    $('#products').select2({
      placeholder: 'Select one or more products',
    });
    $('#delivery_time').datepicker({
      autoclose: true,
      format: "yyyy-mm-dd",
      // startDate: new Date(),
    });
    // $("#delivery_time").datepicker("update", new Date());

    // $("#delivery_time").datepicker("setStartDate", new Date());
    // $("#delivery_time").datepicker("setEndDate", false);

    var buyerValidators = {
      validators: {
        notEmpty: {
          message: 'The buyer is required'
        }
      }
    }, 
    typeValidators = {
      validators: {
        notEmpty: {
          message: 'The type is required'
        }
      }
    },
    deliveryTimeValidators = {
      validators: {
        notEmpty: {
          message: 'The delivery date is required'
        }
      },
      date: {
        format: 'yyyy-mm-dd',
        message: 'The date is not a valid'
      }
    }

    var titleValidators = {
      row: '.col-xs-6',   // The title is placed inside a <div class="col-xs-3"> element
      validators: {
        notEmpty: {
          message: 'The title is required'
        }
      }
    },
    amountValidators = {
      row: '.col-xs-3',
      validators: {
        notEmpty: {
          message: 'The amount is required'
        },
        integer: {
          message: 'The amount must be a numeric number'
        },
        greaterThan: {
          value: 0,
          message: 'The amount must be larger than 0'
        }
      }
    },
    productIndex = 0;

    $('#form-edit-order')
    .formValidation({
      framework: 'bootstrap',
      excluded: ':disabled',
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
        'buyer': buyerValidators,
        'type': typeValidators,
        'delivery_time': deliveryTimeValidators,
        'product[0][title]': titleValidators,
        'product[0][amount]': amountValidators,
      }
    })

    // Add button click handler
    .on('click', '.addButton', function() {
      productIndex++;
      var $template = $('#productTemplate'),
          $clone    = $template
                      .clone()
                      .removeClass('hide')
                      .removeAttr('id')
                      .attr('data-product-index', productIndex)
                      .insertBefore($template);

      // Update the name attributes
      $clone
        .find('.title').attr('name', 'product[' + productIndex + '][title]').end()
        .find('.amount').attr('name', 'product[' + productIndex + '][amount]').end();

      // Add new fields
      // Note that we also pass the validator rules for new field as the third parameter
      $('#form-edit-order')
        .formValidation('addField', 'product[' + productIndex + '][title]', titleValidators)
        .formValidation('addField', 'product[' + productIndex + '][amount]', amountValidators);
    })

    // Remove button click handler
    .on('click', '.removeButton', function() {
      var $row  = $(this).parents('.form-group'),
          index = $row.attr('data-product-index');

      // Remove fields
      $('#form-edit-order')
        .formValidation('removeField', $row.find('[name="product[' + index + '][title]"]'))
        .formValidation('removeField', $row.find('[name="product[' + index + '][amount]"]'));

      // Remove element containing the fields
      $row.remove();
    });
  });
</script>

<?php $this->load->view('otrack/common/footer'); ?>