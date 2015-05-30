<?php $this->load->view('otrack/common/header'); ?>
<?php $this->load->view('otrack/common/navbar'); ?>

<div class="container">
  <?php if ($message): ?>
  <div class="alert alert-<?php if ($status): ?><?php echo $status; ?><?php else: ?>danger<?php endif ?>"><?php echo $message;?></div>
  <?php endif ?>
  <h3 class="page-header"><?php echo $title; ?></h3>

  <?php 
  $form_attributes = array('id'=>'form-create-order', 'class'=>'form-horizontal form-create-order');

  $buyer_options = array(''=>'');
  if ($customers) {
    foreach ($customers as $customer) {
      $buyer_options[$customer->id] = $customer->name;
    }
  }

  $buyer = array(
    'id' => 'buyer',
    'name' => 'buyer',
    'class' => 'form-control',
    'options' => $buyer_options,
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

  $pending = array(
    'id' => 'pending',
    'name' => 'status',
    'value' => '1',
    'checked' => 'checked',
  );

  $finished = array(
    'id' => 'finished',
    'name' => 'status',
    'value' => '2',
  );

  $express_name = array(
    'id' => 'express_name',
    'name' => 'express_name',
    'class' => 'form-control',
    'value' => $this->form_validation->set_value('express_name'),
  );

  $delivery_time = array(
    'id' => 'delivery_time',
    'name' => 'delivery_time',
    'class' => 'form-control',
    'value' => $this->form_validation->set_value('delivery_time'),
  );

  $submit = array(
    'id' => 'btn-create-order',
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
        <?php echo form_label('Buyer', 'buyer', array('class'=>'col-xs-2 control-label')); ?>
        <div class="col-xs-9">
        <?php echo form_dropdown($buyer); ?>
        </div>
      </div>
      <div class="form-group">
        <label class="col-xs-2 control-label">Products</label>
        <div class="col-xs-6">
          <input type="text" class="form-control" name="product[0][title]" placeholder="Title" />
        </div>
        <div class="col-xs-3">
          <input type="text" class="form-control" name="product[0][amount]" placeholder="Amount" />
        </div>
        <div class="col-xs-1">
          <button type="button" class="btn btn-default addButton"><i class="fa fa-plus"></i></button>
        </div>
      </div>

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
        <div class="col-xs-offset-2 col-xs-9">
        <?php echo form_label(form_radio($pending).'Pending', '', array('class'=>'radio-inline')); ?>
        <?php echo form_label(form_radio($finished).'Finished', '', array('class'=>'radio-inline')); ?>
        </div>
      </div>
      <div class="form-group">
        <?php echo form_label('Delivery Date', 'delivery_time', array('class'=>'col-xs-2 control-label')); ?>
        <div class="col-xs-9">
        <?php echo form_input($delivery_time); ?>
        </div>
      </div>
      <div class="form-group">
        <?php echo form_label('Express Name', 'express_name', array('class'=>'col-xs-2 control-label')); ?>
        <div class="col-xs-9">
        <?php echo form_input($express_name); ?>
        </div>
      </div>
      <div class="form-group">
        <div class="col-xs-offset-2 col-xs-9">
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
      placeholder: 'Select a buyer',
    });
    $('#products').select2({
      placeholder: 'Select one or more products',
    });
    $('#delivery_time').datepicker({
      autoclose: true,
      format: "yyyy-mm-dd",
      startDate: new Date(),
    });
    $("#delivery_time").datepicker("update", new Date());

    $('input[name="status"]').on('change', function(e) {
      console.log($(this).attr('id'))
      if ($(this).attr('id') == 'pending') {
        $("#delivery_time").datepicker("setStartDate", new Date());
        $("#delivery_time").datepicker("setEndDate", false);
      } else if ($(this).attr('id') == 'finished') {
        $("#delivery_time").datepicker("setStartDate", false);    
        $("#delivery_time").datepicker("setEndDate", new Date());    
      };
    });

    var buyerValidators = {
      validators: {
        notEmpty: {
          message: 'The buyer is required'
        }
      }
    }, 
    statusValidators = {
      validators: {
        notEmpty: {
          message: 'The status is required'
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

    $('#form-create-order')
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
        'status': statusValidators,
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
      $('#form-create-order')
        .formValidation('addField', 'product[' + productIndex + '][title]', titleValidators)
        .formValidation('addField', 'product[' + productIndex + '][amount]', amountValidators);
    })

    // Remove button click handler
    .on('click', '.removeButton', function() {
      var $row  = $(this).parents('.form-group'),
          index = $row.attr('data-product-index');

      // Remove fields
      $('#form-create-order')
        .formValidation('removeField', $row.find('[name="product[' + index + '][title]"]'))
        .formValidation('removeField', $row.find('[name="product[' + index + '][amount]"]'));

      // Remove element containing the fields
      $row.remove();
    });
  });
</script>

<?php $this->load->view('otrack/common/footer'); ?>