<?php $this->load->view('otrack/common/header') ?>

  <div class="row">
  <div class="col-md-8">
    <div class="thumbnail">
      <img data-src="<?php echo $product_image; ?>" src="<?php echo $product_image && file_exists(FCPATH.'uploads/'.$product_image) ? $product_image : 'https://placehold.it/250x100/aaa/000?text='.lang('field_images'); ?>" width="100%" alt="product_image">
    </div>
  </div>
  <div class="col-md-4">
    
      <div class="caption">
        <h3>
          <?php echo $product->name; ?>
        </h3>

        <?php 

        if ($product->stock <= 0) {
          $status = 'danger';
        } else if ($product->stock <= 5) {
          $status = 'warning';
        } else {
          $status = 'success';
        }

         ?>
        <div class="list-group-item">
          <span class="badge progress-bar-<?php echo $status; ?>"><?php echo $product->stock; ?></span>
          <?php echo lang('field_stock'); ?>
        </div>
        <hr>
        <p>
          <a id="btn-edit" href="<?php echo base_url('products/edit').'/'.$product->id; ?>" class="btn btn-info"><?php echo lang('action_edit'); ?></a>
          <a id="btn-confirm-delete" data-pid="<?php echo $product->id; ?>" data-name="<?php echo $product->name; ?>" class="btn btn-danger"><?php echo lang('action_delete'); ?></a>
        </p>
      </div>
  </div>
  </div>

  <div class="panel panel-default">
    <div class="panel-heading">
      <div class="panel-title"><?php echo lang('field_description'); ?></div>
    </div>
    <div class="panel-body">
      <?php echo $product->description; ?>
    </div>
  </div>

<script>
  $(function() {
    $('#btn-confirm-delete').on('click', function(e) {
      pid = $(this).data('pid');
      name = $(this).data('name');
      BootstrapDialog.show({
        title: '<?php echo lang("title_delete_product"); ?> '+name,
        message: '<?php echo lang("message_delete_product"); ?>',
        type: 'type-danger',
        closable: true,
        buttons: [{
            id: 'btn-confirm-delete',
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
        url: '<?php echo base_url("products/delete"); ?>',
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
              location.replace('<?php echo base_url("products"); ?>');
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

<?php $this->load->view('otrack/common/footer') ?>