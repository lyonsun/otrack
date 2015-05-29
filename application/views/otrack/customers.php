<?php $this->load->view('otrack/common/header'); ?>
<?php $this->load->view('otrack/common/navbar'); ?>

<div class="container">
  <?php if ($message): ?>
  <div class="alert alert-<?php if ($status): ?><?php echo $status; ?><?php else: ?>danger<?php endif ?>"><?php echo $message;?></div>
  <?php endif ?>
  <h3 class="page-header"><?php echo $title; ?></h3>
  <a class="btn btn-primary" href="<?php echo base_url('customers/create'); ?>"><i class="fa fa-fw fa-plus"></i><span class="hidden-xs"> Add</span></a>
  <a class="btn btn-default <?php if ($number_of_customers == 0): ?>hide<?php endif ?>" data-toggle="collapse" href="#collapse-search" aria-expanded="false" aria-controls="collapse-search"><i class="fa fa-fw fa-search"></i><span class="hidden-xs"> Search</span></a>
  <button type="button" class="btn btn-info <?php if ($number_of_customers == 0): ?>hide<?php endif ?>" id="btn-view-all"><i class="fa fa-fw fa-list"></i><span class="hidden-xs"> View All</span></button>
  <button type="button" class="btn btn-danger pull-right <?php if ($number_of_customers == 0): ?>hide<?php endif ?>" id="btn-delete-all"><i class="fa fa-fw fa-trash"></i><span class="hidden-xs"> Delete All</span></button>
  <hr>
  <div class="collapse" id="collapse-search">
    <div class="panel panel-default">
      <div class="panel-body">
        <?php
          $form_attributes = array('id'=>'form-search-customer', 'class'=>'form-search-customer form-horizontal');
          $name = array(
          'id' => 'names',
          'name' => 'names[]',
          'class' => 'form-control',
          'multiple' => 'multiple',
          'selected' => $selected_names,
          'options' => $names,
          );
          $phone = array(
          'id' => 'phones',
          'name' => 'phones[]',
          'class' => 'form-control',
          'multiple' => 'multiple',
          'selected' => $selected_phones,
          'options' => $phones,
          );
          $province = array(
          'id' => 'provinces',
          'name' => 'provinces[]',
          'class' => 'form-control',
          'multiple' => 'multiple',
          'selected' => $selected_provinces,
          'options' => $provinces,
          );
          $city = array(
          'id' => 'cities',
          'name' => 'cities[]',
          'class' => 'form-control',
          'multiple' => 'multiple',
          'selected' => $selected_cities,
          'options' => $cities,
          );
          $district = array(
          'id' => 'districts',
          'name' => 'districts[]',
          'class' => 'form-control',
          'multiple' => 'multiple',
          'selected' => $selected_districts,
          'options' => $districts,
          );
          $submit = array(
          'id' => 'btn-search-customer',
          'class' => 'btn btn-primary btn-block',
          'type' => 'submit',
          'content' => '<i class="fa fa-fw fa-filter"></i> Filter',
          );
        ?>
        <?php echo form_open(base_url($this->uri->uri_string()), $form_attributes); ?>
        <div class="form-group">
          <?php echo form_label('Customer Name', 'name', array('class'=>'control-label col-md-2')); ?>
          <div class="col-md-10">
          <?php echo form_dropdown($name); ?>
          </div>
        </div>
        <div class="form-group">
          <?php echo form_label('Phone Number', 'phone', array('class'=>'control-label col-md-2')); ?>
          <div class="col-md-10">
          <?php echo form_dropdown($phone); ?>
          </div>
        </div>
        <div class="form-group">
          <?php echo form_label('Province', 'province', array('class'=>'control-label col-md-2')); ?>
          <div class="col-md-10">
          <?php echo form_dropdown($province); ?>
          </div>
        </div>
        <div class="form-group">
          <?php echo form_label('City', 'city', array('class'=>'control-label col-md-2')); ?>
          <div class="col-md-10">
          <?php echo form_dropdown($city); ?>
          </div>
        </div>
        <div class="form-group">
          <?php echo form_label('County/District', 'district', array('class'=>'control-label col-md-2')); ?>
          <div class="col-md-10">
          <?php echo form_dropdown($district); ?>
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-offset-2 col-md-10">
          <?php echo form_button($submit); ?>
          </div>
        </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
  <?php
    echo $customer_table;
    echo $this->pagination->create_links();
   ?>
</div>

<?php $this->load->view('otrack/common/js'); ?>

<script>
  $(function() {
    $('#names, #phones, #provinces, #cities, #districts').select2({
      placeholder: 'Please type or click to select',
    });

    $('.btn-modal-delete').on('click', function(e) {
      cid = $(this).data('cid');
      name = $(this).data('name');
      BootstrapDialog.show({
        title: 'Delete Customer: '+name,
        message: 'Caution! Are you sure to delete this customer?',
        type: 'type-danger',
        closable: true,
        buttons: [{
            id: 'btn-delete',
            icon: 'glyphicon glyphicon-trash',
            label: 'Delete',
            action: function(dialog) {
              ajax_delete(cid, name, dialog, this)
            }
        }],
      });
    });

    function ajax_delete (cid, name, dialog, button) {
      $.ajax({
        url: '<?php echo base_url("customers/delete") ?>',
        type: 'POST',
        dataType: 'json',
        data: {cid: cid},
        beforeSend: function () {
          button.disable();
          button.spin();
          dialog.setClosable(false);
        },
        success: function (data) {
          if (data) {
            dialog.close();
            BootstrapDialog.alert('Customer '+name+' Deleted.', function () {
              location.reload();
            });
          } else {
            button.enable();
            button.stopSpin();
            dialog.setClosable(true);
          }
        }
      });
    }

    $('#btn-view-all').on('click', function(e) {
      window.location.replace('<?php echo base_url("customers"); ?>');
    });

    $('#btn-delete-all').on('click', function(e) {
      <?php if ($number_of_customers == 0): ?>
      BootstrapDialog.alert('No customers found.');
      <?php else: ?>
      BootstrapDialog.show({
        title: 'Delete All Customer',
        message: 'Caution! Delete all customer records? Really? Reaaaaaly? Not taking a second thought anymore? Down this road is the end of all your customer information saved, close this box if you have no intension to commit this action.',
        type: 'type-danger',
        buttons: [{
            id: 'btn-delete',
            icon: 'glyphicon glyphicon-trash',
            cssClass: 'btn-warning',
            label: 'Delete All',
            action: function(dialog) {
              ajax_delete_all(dialog, this)
            }
        }],
      });
      <?php endif ?>
    });

    function ajax_delete_all (dialog, button) {
      $.ajax({
        url: '<?php echo base_url("customers/delete_all") ?>',
        type: 'POST',
        dataType: 'json',
        data: {uid: '<?php echo $this->session->userdata("user_id"); ?>'},
        beforeSend: function () {
          button.disable();
          button.spin();
          dialog.setClosable(false);
        },
        success: function (data) {
          if (data) {
            dialog.close();
            BootstrapDialog.alert('All Customers Deleted.', function () {
              location.reload();
            });
          } else {
            button.enable();
            button.stopSpin();
            dialog.setClosable(true);
          }
        }
      });
    }
  });
</script>

<?php $this->load->view('otrack/common/footer'); ?>
