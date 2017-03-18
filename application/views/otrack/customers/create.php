<?php $this->load->view('otrack/common/header'); ?>

  <div class="row">
    <div class="col-md-12">
      <?php
        $form_attributes = array('id'=>'form-create-customer', 'class'=>'form-create-customer form-horizontal');
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
        'placeholder' => lang('field_optional'),
        );
        $zipcode = array(
        'id' => 'zipcode',
        'name' => 'zipcode',
        'class' => 'form-control',
        'placeholder' => lang('field_optional'),
        );
        $submit = array(
        'id' => 'btn-create-customer',
        'class' => 'btn btn-primary',
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
            <?php echo form_label(lang('field_customer_name'), 'name', array('class'=>'control-label col-md-2')); ?>
            <div class="col-md-10">
            <?php echo form_input($name); ?>
            </div>
          </div>
          <div class="form-group">
            <?php echo form_label(lang('field_phone'), 'phone', array('class'=>'control-label col-md-2')); ?>
            <div class="col-md-10">
            <?php echo form_input($phone); ?>
            </div>
          </div>
          <div class="form-group">
            <?php echo form_label(lang('field_province'), 'province', array('class'=>'control-label col-md-2')); ?>
            <div class="col-md-10">
            <?php echo form_dropdown($province); ?>
            </div>
          </div>
          <div class="form-group">
            <?php echo form_label(lang('field_city'), 'city', array('class'=>'control-label col-md-2')); ?>
            <div class="col-md-10">
            <?php echo form_dropdown($city); ?>
            </div>
          </div>
          <div class="form-group">
            <?php echo form_label(lang('field_district'), 'district', array('class'=>'control-label col-md-2')); ?>
            <div class="col-md-10">
            <?php echo form_dropdown($district); ?>
            </div>
          </div>
          <div class="form-group">
            <?php echo form_label(lang('field_address_1'), 'address_1', array('class'=>'control-label col-md-2')); ?>
            <div class="col-md-10">
            <?php echo form_input($address_1); ?>
            </div>
          </div>
          <div class="form-group">
            <?php echo form_label(lang('field_address_2').' ('.lang('field_optional').')', 'address_2', array('class'=>'control-label col-md-2')); ?>
            <div class="col-md-10">
            <?php echo form_input($address_2); ?>
            </div>
          </div>
          <div class="form-group">
            <?php echo form_label(lang('field_zipcode').' ('.lang('field_optional').')', 'zipcode', array('class'=>'control-label col-md-2')); ?>
            <div class="col-md-10">
            <?php echo form_input($zipcode); ?>
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-offset-2 col-md-10">
            <?php echo form_button($submit); ?>
              <a class="btn btn-default" href="<?php echo base_url('customers'); ?>"><?php echo lang('action_cancel'); ?></a>
            </div>
          </div>
          <?php echo form_close(); ?>
        </div>
      </div>
    </div>
  </div>


<script>
$(function() {

  $('select').select2();

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
    $('#city').html('<option value=""></option>');
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
