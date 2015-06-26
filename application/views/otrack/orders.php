<?php $this->load->view('otrack/common/header'); ?>
<?php $this->load->view('otrack/common/navbar'); ?>

<div class="container">
  <?php if ($message): ?>
  <div class="alert alert-<?php if ($status): ?><?php echo $status; ?><?php else: ?>danger<?php endif ?>"><?php echo $message;?></div>
  <?php endif ?>
  <h3 class="page-header"><?php echo $title; ?></h3>
  <a class="btn btn-primary" href="<?php echo base_url('orders/create'); ?>"><i class="fa fa-fw fa-plus"></i><span class="hidden-xs"> Add</span></a>
  <hr>
  
  <ul class="nav nav-tabs">
    <li <?php if ($this->uri->segment(3) == ''): ?>class="active"<?php endif ?>><a href="<?php echo base_url('orders'); ?>">All <span class="progress-bar-success badge"><?php echo $all_order_count; ?></span></a></li>
    <li <?php if ($this->uri->segment(3) == '1'): ?>class="active"<?php endif ?>><a href="<?php echo base_url('orders'); ?>/index/1">Pending <span class="progress-bar-danger badge"><?php echo $pending_order_count; ?></span></a></li>
    <li <?php if ($this->uri->segment(3) == '2'): ?>class="active"<?php endif ?>><a href="<?php echo base_url('orders'); ?>/index/2">Finished <span class="badge"><?php echo $finished_order_count; ?></span></a></li>
  </ul>

  <br>

  <?php 
    echo $order_table;
    echo $this->pagination->create_links();
   ?>
</div>


<script>
  $(function() {

    $('.btn-modal-delete').on('click', function(e) {
      oid = $(this).data('oid');
      BootstrapDialog.show({
        title: 'Delete this order?',
        message: 'Caution! Are you sure to delete this order?',
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
            BootstrapDialog.alert('Order Deleted.', function () {
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
