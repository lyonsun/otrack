<?php $this->load->view('otrack/common/header'); ?>
<?php $this->load->view('otrack/common/navbar'); ?>

<div class="container">
  <?php if ($message): ?>
  <div class="alert alert-<?php if ($status): ?><?php echo $status; ?><?php else: ?>danger<?php endif ?>"><?php echo $message;?></div>
  <?php endif ?>
  <h3 class="page-header">Customers</h3>
  <a class="btn btn-default" href="<?php echo base_url('customers/create'); ?>"><i class="fa fa-fw fa-plus"></i> Add Customer</a>
  <hr>

  <?php
    if ($customers) {
      $tmpl = array (
        'table_open'  => '<div class="table-responsive"><table class="table table-hover">',
        'heading_cell_start'  => '<th class="bg-primary">',
        'table_close'         => '</table></div>',
      );

      $this->table->set_template($tmpl);

      $heading = array(
        'Name',
        'Phone Number',
        'Primary Address',
        'Secondary Address',
        'District',
        'City',
        'Province',
        'Zip Code',
        'Action',
      );

      $this->table->set_heading($heading);

      foreach ($customers as $customer) {
        $row = array(
          $customer->name,
          $customer->phone,
          $customer->address_1,
          $customer->address_2,
          $customer->district,
          $customer->city,
          $customer->province,
          $customer->zipcode,
          '<div class="btn-group">'.
          anchor(base_url('customers/edit').'/'.$customer->id,'<i class="fa fa-fw fa-edit"></i><span class="hidden-xs">Edit</span>',array('class'=>'btn btn-xs btn-info')).
          anchor('#modal-delete','<i class="fa fa-fw fa-trash"></i><span class="hidden-xs">Delete</span>',array('class'=>'btn btn-xs btn-danger btn-modal-delete','data-toggle'=>'modal','data-cid'=>$customer->id,'data-name'=>$customer->name)).
          '</div>',
        );

        $this->table->add_row($row);
      }

      echo $table = $this->table->generate();
  }
   ?>

</div>

<script>
  $(function() {
    $('.btn-modal-delete').on('click', function(e) {
      cid = $(this).data('cid');
      name = $(this).data('name');
      BootstrapDialog.show({
        title: 'Delete Customer: '+name,
        message: 'Caution! Are you sure to delete this customer?',
        type: 'type-danger',
        closable: true,
        closeByBackdrop: false,
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
  });
</script>

<?php $this->load->view('otrack/common/footer'); ?>
