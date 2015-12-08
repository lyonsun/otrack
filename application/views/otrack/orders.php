<?php $this->load->view('otrack/common/header'); ?>

  <a class="btn btn-primary" href="<?php echo base_url('orders/create'); ?>"><i class="fa fa-fw fa-plus"></i><span class="hidden-xs"> <?php echo lang('action_add'); ?></span></a>
  <hr>
  
  <ul class="nav nav-tabs">
    <li <?php if ($this->uri->segment(3) == ''): ?>class="active"<?php endif ?>><a href="<?php echo base_url('orders'); ?>"><?php echo lang('field_all'); ?> <span class="progress-bar-success badge"><?php echo $all_order_count; ?></span></a></li>
    <li <?php if ($this->uri->segment(3) == '1'): ?>class="active"<?php endif ?>><a href="<?php echo base_url('orders'); ?>/index/1"><?php echo lang('field_pending'); ?> <span class="progress-bar-danger badge"><?php echo $pending_order_count; ?></span></a></li>
    <li <?php if ($this->uri->segment(3) == '2'): ?>class="active"<?php endif ?>><a href="<?php echo base_url('orders'); ?>/index/2"><?php echo lang('field_finished'); ?> <span class="badge"><?php echo $finished_order_count; ?></span></a></li>
  </ul>

  <br>
  
  <?php 
    echo $order_table;
   ?>
  <div class="text-center">
  <?php 
    echo $this->pagination->create_links();
   ?>
   </div>


<script>
  $(function() {

    $('.btn-modal-delete').on('click', function(e) {
      oid = $(this).data('oid');
      BootstrapDialog.show({
        title: '<?php echo lang("title_delete_order"); ?>',
        message: '<?php echo lang("message_delete_order"); ?>',
        type: 'type-danger',
        closable: true,
        buttons: [{
            id: 'btn-delete',
            icon: 'glyphicon glyphicon-trash',
            label: 'Delete',
            action: function(dialog) {
              ajax_delete(oid, dialog, this)
            }
        }],
      });
    });

    function ajax_delete (oid, dialog, button) {
      $.ajax({
        url: '<?php echo base_url("orders/delete") ?>',
        type: 'POST',
        dataType: 'json',
        data: {oid: oid},
        beforeSend: function () {
          button.disable();
          button.spin();
          dialog.setClosable(false);
        },
        success: function (data) {
          if (data) {
            dialog.close();
            BootstrapDialog.alert('<?php echo lang("message_order_deleted"); ?>', function () {
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
