<?php $this->load->view('otrack/common/header'); ?>

<div class="container-fluid">
  <?php if ($message): ?>
  <div class="alert alert-<?php if ($status): ?><?php echo $status; ?><?php else: ?>danger<?php endif ?>"><?php echo $message;?></div>
  <?php endif ?>
  <a class="btn btn-primary" href="<?php echo base_url('products/create'); ?>"><i class="fa fa-fw fa-plus"></i><span class="hidden-xs"> <?php echo lang('action_add'); ?></span></a>
  <!-- <a class="btn btn-default <?php if ($number_of_products == 0): ?>hide<?php endif ?>" data-toggle="collapse" href="#collapse-search" aria-expanded="false" aria-controls="collapse-search"><i class="fa fa-fw fa-search"></i><span class="hidden-xs"> <?php echo lang('action_search'); ?></span></a> -->
  <!-- <button type="button" class="btn btn-info <?php if ($number_of_products == 0): ?>hide<?php endif ?>" id="btn-view-all"><i class="fa fa-fw fa-list"></i><span class="hidden-xs"> <?php echo lang('action_view_all'); ?></span></button> -->
  <!-- <button type="button" class="btn btn-danger pull-right <?php if ($number_of_products == 0): ?>hide<?php endif ?>" id="btn-delete-all"><i class="fa fa-fw fa-trash"></i><span class="hidden-xs"> <?php echo lang('action_delete_all'); ?></span></button> -->
  <hr>
  <div class="collapse" id="collapse-search">
    <div class="panel panel-default">
      <div class="panel-body">
        <?php
          $form_attributes = array('id'=>'form-search-product', 'class'=>'form-search-product form-horizontal');
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
          'id' => 'btn-search-product',
          'class' => 'btn btn-primary btn-block',
          'type' => 'submit',
          'content' => '<i class="fa fa-fw fa-filter"></i> '.lang('action_filter'),
          );
        ?>
        <?php echo form_open(base_url($this->uri->uri_string()), $form_attributes); ?>
        <div class="form-group">
          <?php echo form_label(lang('field_product_name'), 'name', array('class'=>'control-label col-md-2')); ?>
          <div class="col-md-10">
          <?php echo form_dropdown($name); ?>
          </div>
        </div>
        <div class="form-group">
          <?php echo form_label(lang('field_phone'), 'phone', array('class'=>'control-label col-md-2')); ?>
          <div class="col-md-10">
          <?php echo form_dropdown($phone); ?>
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
          <div class="col-md-offset-2 col-md-10">
          <?php echo form_button($submit); ?>
          </div>
        </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
  <?php
    echo $product_table;
    echo $this->pagination->create_links();
   ?>
</div>


<script>
  $(function() {
    $('#names, #phones, #provinces, #cities, #districts').select2({
      placeholder: '<?php echo lang("placeholder_select"); ?>',
    });

    $('.btn-modal-delete').on('click', function(e) {
      pid = $(this).data('pid');
      name = $(this).data('name');
      BootstrapDialog.show({
        title: '<?php echo lang("title_delete_product"); ?> '+name,
        message: '<?php echo lang("message_delete_product"); ?>',
        type: 'type-danger',
        closable: true,
        buttons: [{
            id: 'btn-delete',
            icon: 'glyphicon glyphicon-trash',
            label: 'Delete',
            action: function(dialog) {
              ajax_delete(pid, name, dialog, this)
            }
        }],
      });
    });

    function ajax_delete (pid, name, dialog, button) {
      $.ajax({
        url: '<?php echo base_url("products/delete") ?>',
        type: 'POST',
        dataType: 'json',
        data: {pid: pid},
        beforeSend: function () {
          button.disable();
          button.spin();
          dialog.setClosable(false);
        },
        success: function (data) {
          if (data) {
            dialog.close();
            BootstrapDialog.alert('<?php echo lang("message_product_deleted"); ?>', function () {
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

    // $('#btn-view-all').on('click', function(e) {
    //   window.location.replace('<?php echo base_url("products"); ?>');
    // });

    // $('#btn-delete-all').on('click', function(e) {
    //   <?php if ($number_of_products == 0): ?>
    //   BootstrapDialog.alert('<?php echo lang("no_products_found"); ?>');
    //   <?php else: ?>
    //   BootstrapDialog.show({
    //     title: '<?php echo lang("title_delete_all_product"); ?>',
    //     message: '<?php echo lang("message_delete_all_product"); ?>',
    //     type: 'type-danger',
    //     buttons: [{
    //         id: 'btn-delete',
    //         icon: 'glyphicon glyphicon-trash',
    //         cssClass: 'btn-warning',
    //         label: 'Delete All',
    //         action: function(dialog) {
    //           ajax_delete_all(dialog, this)
    //         }
    //     }],
    //   });
    //   <?php endif ?>
    // });

    // function ajax_delete_all (dialog, button) {
    //   $.ajax({
    //     url: '<?php echo base_url("products/delete_all") ?>',
    //     type: 'POST',
    //     dataType: 'json',
    //     data: {uid: '<?php echo $this->session->userdata("user_id"); ?>'},
    //     beforeSend: function () {
    //       button.disable();
    //       button.spin();
    //       dialog.setClosable(false);
    //     },
    //     success: function (data) {
    //       if (data) {
    //         dialog.close();
    //         BootstrapDialog.alert('<?php echo lang("message_all_product_deleted"); ?>', function () {
    //           location.reload();
    //         });
    //       } else {
    //         button.enable();
    //         button.stopSpin();
    //         dialog.setClosable(true);
    //       }
    //     }
    //   });
    // }
  });
</script>

<?php $this->load->view('otrack/common/footer'); ?>
