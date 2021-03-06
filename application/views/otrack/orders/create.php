<?php $this->load->view('otrack/common/header'); ?>

  <?php 
  $form_attributes = array('id'=>'form-create-order', 'class'=>'form-horizontal form-create-order');

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

  $product_options = array(''=>'');
  if ($products) {
    foreach ($products as $product) {
      $product_options[$product->id] = $product->name.' - ['.$product->stock.' '. lang('field_left').']';
    }
  }

  $buyer = array(
    'id' => 'buyer',
    'name' => 'buyer',
    'class' => 'form-control',
    'options' => $buyer_options,
  );

  $product = array(
    'id' => 'products',
    'name' => 'product[0][title]',
    'class' => 'form-control title',
    'options' => $product_options,
  );

  $international = array(
    'id' => 'international',
    'name' => 'type',
    'value' => '1',
    'checked' => 'checked',
  );

  $domestic = array(
    'id' => 'domestic',
    'name' => 'type',
    'value' => '2',
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
  );

  $delivery_time = array(
    'id' => 'delivery_time',
    'name' => 'delivery_time',
    'class' => 'form-control',
    'value' => $this->form_validation->set_value('delivery_time'),
  );

  $comments = array(
    'id' => 'comments',
    'name' => 'comments',
    'class' => 'form-control',
    'placeholder' => lang('placeholder_comments'),
    'value' => $this->form_validation->set_value('comments'),
  );

  $submit = array(
    'id' => 'btn-create-order',
    'class' => 'btn btn-primary btn-block',
    'content' => lang('action_add'),
    'type' => 'submit',
  );
   ?>

  <?php echo form_open(base_url($this->uri->uri_string()), $form_attributes); ?>

  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title"><?php echo lang('heading_order_info'); ?></h3>
    </div>
    <div class="panel-body">
      <div class="form-group">
        <?php echo form_label(lang('field_receiver'), 'buyer', array('class'=>'col-md-2 control-label')); ?>
        <div class="col-md-9">
        <?php echo form_dropdown($buyer); ?>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label"><?php echo lang('field_products'); ?></label>
        <div class="col-md-6">
          <!-- <input type="text" class="form-control" name="product[0][title]" placeholder="<?php echo lang('placeholder_title'); ?>" /> -->
          <?php echo form_dropdown($product); ?>
        </div>
        <div class="col-md-3">
          <input type="text" class="form-control" name="product[0][amount]" placeholder="<?php echo lang('placeholder_amount'); ?>" />
        </div>
        <div class="col-md-1">
          <button type="button" class="btn btn-default addButton"><i class="fa fa-plus"></i></button>
        </div>
      </div>
      <div class="form-group" id="templateBefore">
        <div class="col-md-2 text-right hidden-sm"><b><?php echo lang('field_type'); ?></b></div>
        <div class="col-md-9">
        <?php echo form_label(form_radio($international).lang('field_international'), '', array('class'=>'radio-inline')); ?>
        <?php echo form_label(form_radio($domestic).lang('field_domestic'), '', array('class'=>'radio-inline')); ?>
        </div>
      </div>
      <div class="form-group">
        <?php echo form_label(lang('field_delivery_time'), 'delivery_time', array('class'=>'col-md-2 control-label')); ?>
        <div class="col-md-9">
        <?php echo form_input($delivery_time); ?>
        </div>
      </div>
      <div class="form-group">
        <?php echo form_label(lang('field_express'), 'express_name', array('class'=>'col-md-2 control-label')); ?>
        <div class="col-md-9">
        <?php echo form_dropdown($express_name); ?>
        </div>
      </div>
      <div class="form-group">
        <?php echo form_label(lang('field_comments'), 'comments', array('class'=>'col-md-2 control-label')); ?>
        <div class="col-md-9">
        <?php echo form_input($comments); ?>
        </div>
      </div>
      <div class="form-group">
        <div class="col-md-offset-2 col-md-9">
        <?php echo form_hidden('status', '1'); ?>
        <?php echo form_button($submit); ?>
        </div>
      </div>
    </div>
  </div>

  <?php echo form_close(); ?>


<!-- The template for adding new field -->
<div class="form-group hide" id="productTemplate">
  <div class="col-md-6 col-md-offset-2">
    <!-- <input type="text" class="form-control title" placeholder="<?php echo lang('placeholder_title'); ?>" /> -->
    <?php echo form_dropdown($product); ?>
  </div>
  <div class="col-md-3">
    <input type="text" class="form-control amount" placeholder="<?php echo lang('placeholder_amount'); ?>" />
  </div>
  <div class="col-md-1">
    <button type="button" class="btn btn-default removeButton"><i class="fa fa-minus"></i></button>
  </div>
</div>


<script src="<?php echo base_url(); ?>static/bs-dp3/js/bootstrap-datepicker.min.js"></script>
<script>
  $(function() {
    $('select').select2();

    $('#delivery_time').datepicker({
      autoclose: true,
      format: "yyyy-mm-dd",
      startDate: new Date(),
    });

    $('#delivery_time').datepicker('update', new Date());

    var buyerValidators = {
      validators: {
        notEmpty: {
          message: '<?php echo lang("buyer_required"); ?>'
        }
      }
    }, 
    typeValidators = {
      validators: {
        notEmpty: {
          message: '<?php echo lang("type_required"); ?>'
        }
      }
    },
    deliveryTimeValidators = {
      validators: {
        notEmpty: {
          message: '<?php echo lang("delivery_time_required"); ?>'
        }
      },
      date: {
        format: 'yyyy-mm-dd',
        message: '<?php echo lang("date_should_in_format"); ?>'
      }
    },
    expressNameValidators = {
      validators: {
        notEmpty: {
          message: '<?php echo lang("express_name_required"); ?>'
        }
      },
    }

    var titleValidators = {
      row: '.col-md-6',   // The title is placed inside a <div class="col-md-3"> element
      validators: {
        notEmpty: {
          message: '<?php echo lang("title_required"); ?>'
        }
      }
    },
    amountValidators = {
      row: '.col-md-3',
      validators: {
        notEmpty: {
          message: '<?php echo lang("amount_required"); ?>'
        },
        integer: {
          message: '<?php echo lang("amount_be_integer"); ?>'
        },
        greaterThan: {
          value: 0,
          message: '<?php echo lang("amount_greater_than"); ?>'
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
        'type': typeValidators,
        'delivery_time': deliveryTimeValidators,
        'express_name': expressNameValidators,
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
                      .insertBefore($('#templateBefore'));

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

    // for (var i = 0; i <= productIndex; i++) {
    //   $('#form-edit-order')
    //     .formValidation('addField', 'product[' + i + '][title]', titleValidators)
    //     .formValidation('addField', 'product[' + i + '][amount]', amountValidators);

    //   var index = 'product['+i+'][title]';
    //   console.log(index)
    //   $('select[name="'+index+'"]').select2({
    //     placeholder: '<?php echo lang("placeholder_select_products"); ?>',
    //   });
    // };
  });
</script>

<?php $this->load->view('otrack/common/footer'); ?>