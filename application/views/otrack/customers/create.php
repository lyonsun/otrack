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
        $form_attributes = array('id'=>'form-create-customer', 'class'=>'form-create-customer col-md-offset-1 col-md-10');
        $name = array(
        'id' => 'name',
        'name' => 'name',
        'class' => 'form-control',
        'placeholder' => lang('field_customer_name'),
        );
        $phone = array(
        'id' => 'phone',
        'name' => 'phone',
        'class' => 'form-control',
        'placeholder' => lang('field_phone'),
        );
        $province = array(
        'id' => 'province',
        'name' => 'province',
        'class' => 'form-control',
        'options' => array(''=>''),
        );
        $city = array(
        'id' => 'city',
        'name' => 'city',
        'class' => 'form-control',
        'options' => array(''=>''),
        );
        $district = array(
        'id' => 'district',
        'name' => 'district',
        'class' => 'form-control',
        'options' => array(''=>''),
        );
        $address_1 = array(
        'id' => 'address_1',
        'name' => 'address_1',
        'class' => 'form-control',
        'placeholder' => lang('field_address_1'),
        );
        $address_2 = array(
        'id' => 'address_2',
        'name' => 'address_2',
        'class' => 'form-control',
        'placeholder' => lang('field_address_2'),
        );
        $zipcode = array(
        'id' => 'zipcode',
        'name' => 'zipcode',
        'class' => 'form-control',
        'placeholder' => lang('field_zipcode'),
        );
        $submit = array(
        'id' => 'btn-create-customer',
        'class' => 'btn btn-primary btn-block',
        'type' => 'submit',
        'content' => lang('action_add'),
        );
      ?>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title"><?php echo lang('heading_customer_info'); ?></h3>
        </div>
        <div class="panel-body">
          <?php echo form_open(base_url($this->uri->uri_string()), $form_attributes); ?>
          <div class="form-group">
            <?php echo form_label(lang('field_customer_name'), 'name', array('class'=>'control-label')); ?>
            <?php echo form_input($name); ?>
          </div>
          <div class="form-group">
            <?php echo form_label(lang('field_phone'), 'phone', array('class'=>'control-label')); ?>
            <?php echo form_input($phone); ?>
          </div>
          <div class="form-group">
            <?php echo form_label(lang('field_province'), 'province', array('class'=>'control-label')); ?>
            <?php echo form_dropdown($province); ?>
          </div>
          <div class="form-group">
            <?php echo form_label(lang('field_city'), 'city', array('class'=>'control-label')); ?>
            <?php echo form_dropdown($city); ?>
          </div>
          <div class="form-group">
            <?php echo form_label(lang('field_district'), 'district', array('class'=>'control-label')); ?>
            <?php echo form_dropdown($district); ?>
          </div>
          <div class="form-group">
            <?php echo form_label(lang('field_address_1'), 'address_1', array('class'=>'control-label')); ?>
            <?php echo form_input($address_1); ?>
          </div>
          <div class="form-group">
            <?php echo form_label(lang('field_address_2'), 'address_2', array('class'=>'control-label')); ?>
            <?php echo form_input($address_2); ?>
          </div>
          <div class="form-group">
            <?php echo form_label(lang('field_zipcode'), 'zipcode', array('class'=>'control-label')); ?>
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

  $('#province').select2({
    placeholder: "<?php echo lang('placeholder_select_province'); ?>",
  });

  $('#city').select2({
    placeholder: "<?php echo lang('placeholder_select_city'); ?>",
  });

  $('#district').select2({
    placeholder: "<?php echo lang('placeholder_select_district'); ?>",
  });

  jQuery.extend({
    getValues: function(url) {
      var result = null;
      $.ajax({
        url: url,
        type: 'get',
        dataType: 'json',
        async: false,
        success: function(data) {
            result = data;
        }
      });
     return result;
    }
  });

  var provinces = $.getValues('<?php echo base_url(); ?>/static/json/cn_city.json');

  load_states();

  function load_states () {
    $.each(provinces, function(province_index, province) {
      $('#province').append('<option value="'+province.name+'">'+province.name+'</option>');
    });
  }

  $('#province').on('change', function(e) {
    $('#city').select2('val', 'All');
    $('#city').html('<option value=""></option>');
    $('#district').select2('val', 'All');
    $('#district').html('<option value=""></option>');
    load_citys($(this).val());
  });

  function load_citys (state) {
    $.each(provinces, function(province_index, province) {
      if (province.name == state) {
        $.each(province.children, function(city_index, city) {
          $('#city').append('<option value="'+city.name+'">'+city.name+'</option>');
        });
      };
    });
  }

  $('#city').on('change', function(e) {
    $('#district').select2('val', 'All');
    $('#district').html('<option value=""></option>');
    load_districts($(this).val());
  });

  function load_districts (city) {
    $.each(provinces, function(province_index, province) {
      $.each(province.children, function(city_index, val) {        
        if (val.name == city) {
          $.each(val.children, function(district_index, district) {
            $('#district').append('<option value="'+district.name+'">'+district.name+'</option>');
          });
        };
      });
    });
  }

  $('#form-create-customer')
  .find('[name="province"]')
    .select2()
    // Revalidate the color when it is changed
    .change(function(e) {
        $('#form-create-customer').formValidation('revalidateField', 'province');
    })
    .end()
  .find('[name="city"]')
    .select2()
    // Revalidate the color when it is changed
    .change(function(e) {
        $('#form-create-customer').formValidation('revalidateField', 'city');
    })
    .end()
  .find('[name="district"]')
    .select2()
    // Revalidate the color when it is changed
    .change(function(e) {
        $('#form-create-customer').formValidation('revalidateField', 'district');
    })
    .end()
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
