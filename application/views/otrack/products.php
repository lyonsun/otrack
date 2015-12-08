<?php $this->load->view('otrack/common/header'); ?>
  
  <?php
  $form_attributes = array('id'=>'form-search-product', 'class'=>'form-search-product form-inline', 'method'=>'GET');
  $search_criteria = array(
  'id' => 'criteria',
  'name' => 'q',
  'class' => 'form-control',
  'placeholder' => lang('action_search').'...',
  'value' => $criteria,
  );
  $submit = array(
  'id' => 'btn-search-product',
  'class' => 'btn btn-default btn-block',
  'type' => 'submit',
  'content' => '<i class="fa fa-fw fa-filter"></i> '.lang('action_filter'),
  );
  ?>
  <?php echo form_open(base_url($this->uri->uri_string()), $form_attributes); ?>
  <div class="form-group">
    <?php echo form_input($search_criteria); ?>
  </div>
  <div class="form-group">
    <?php echo form_button($submit); ?>
  </div>
  <div class="form-group">
    <a class="btn btn-primary btn-block" href="<?php echo base_url('products/create'); ?>"><i class="fa fa-fw fa-plus"></i><span> <?php echo lang('action_add'); ?></span></a>
  </div>
  <?php echo form_close(); ?>
  <hr>
  <?php if ($products): ?>
  <!-- <div class="row"> -->
  <div id="products" class="row list-group">
    <?php foreach ($products as $product): ?>
    <?php
    if ($product->stock <= 0) {
    $status = 'danger';
    } else if ($product->stock <= 5) {
    $status = 'warning';
    } else {
    $status = 'success';
    }
    ?>
    <div class="item col-sm-6 col-md-4 col-lg-3">
      <div class="thumbnail">
        <img class="list-group-image" src="holder.js/400x50?bg=000&fg=fff&text=<?php echo lang('field_images'); ?>" alt="" width="100%" />
        <div class="caption">
          <h5 style="min-height:50px;">
          <b><?php echo $product->name; ?></b>
          </h5>
          <p class="list-group-item-text text-warning" style="min-height:60px;">
            <?php echo $product->description; ?>
          </p>
          <p class="text-<?php echo $status; ?>"><?php echo lang('field_stock'); ?>: <?php echo $product->stock; ?></p>
          <hr>
          <div class="row">
            <div class="col-xs-6">
              <?php echo anchor(base_url('products/edit').'/'.$product->id,'<i class="fa fa-fw fa-edit"></i><span>'.$this->lang->line('action_edit').'</span>',array('class'=>'btn btn-block btn-xs btn-success')); ?>
            </div>
            <div class="col-xs-6">
              <?php echo anchor('#modal-delete','<i class="fa fa-fw fa-trash"></i><span>'.$this->lang->line('action_delete').'</span>',array('class'=>'btn btn-block btn-xs btn-default btn-modal-delete','data-toggle'=>'modal','data-pid'=>$product->id,'data-name'=>$product->name)); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php endforeach ?>
  </div>
  <div class="text-center">
    <?php
    // echo $product_table;
    echo $this->pagination->create_links();
    ?>
  </div>
  <?php else: ?>
  <p class="lead text-center"><?php echo lang('field_no_matches'); ?></p>
  <?php endif ?>


<script>
  $(function() {

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
  });
</script>

<?php $this->load->view('otrack/common/footer'); ?>
