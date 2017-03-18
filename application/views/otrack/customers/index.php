<?php $this->load->view('otrack/common/header'); ?>
  
  <?php
  $form_attributes = array('id'=>'form-search-customer', 'class'=>'form-search-customer form-inline', 'method'=>'GET');
  $search_criteria = array(
  'id' => 'criteria',
  'name' => 'q',
  'class' => 'form-control',
  'placeholder' => lang('action_search').'...',
  'value' => $criteria,
  );
  $submit = array(
  'id' => 'btn-search-customer',
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
    <a class="btn btn-primary btn-block" href="<?php echo base_url('customers/create'); ?>"><i class="fa fa-fw fa-plus"></i><span> <?php echo lang('action_add'); ?></span></a>
  </div>
  <?php echo form_close(); ?>
  <hr>
  <?php if ($number_of_customers <= 0): ?>
  <p class="lead text-center"><?php echo lang('field_no_matches'); ?></p>
  <?php else: ?>
  <div class="row">
    <?php foreach ($customers as $customer): ?>
    <?php
    $address = array($customer->province,$customer->city,$customer->district,$customer->address_1);
    if (!empty($customer->address_2)) {
    $address[] = $customer->address_2;
    }
    if (!empty($customer->zipcode)) {
    $address[] = $customer->zipcode;
    }
    ?>
    <div class="col-md-4">
      <div class="thumbnail">
        <div class="caption">
          <h5>
          <b><?php echo $customer->name; ?></b>
          </h5>
          <div class="text-danger"><?php echo $customer->phone; ?></div>
          <div style="min-height:70px;">
            <?php echo implode(', ', $address); ?>
          </div>
          <hr>
          <div class="row">
            <div class="col-xs-6">
              <?php echo anchor(base_url('customers/edit').'/'.$customer->id,'<i class="fa fa-fw fa-edit"></i><span>'.$this->lang->line('action_edit').'</span>',array('class'=>'btn btn-xs btn-block btn-success')); ?>
            </div>
            <div class="col-xs-6">
              <?php echo anchor('#modal-delete','<i class="fa fa-fw fa-trash"></i><span>'.$this->lang->line('action_delete').'</span>',array('class'=>'btn btn-xs btn-block btn-default btn-modal-delete','data-toggle'=>'modal','data-cid'=>$customer->id,'data-name'=>$customer->name)); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php endforeach ?>
  </div>
  <div class="text-center"><?php echo $this->pagination->create_links(); ?></div>
  <?php endif ?>

<!-- <script src="<?php echo base_url(); ?>static/otrack/js/customers/index.js"></script> -->

<script>
  $(function() {

    $('.btn-modal-delete').on('click', function(e) {
      cid = $(this).data('cid');
      name = $(this).data('name');
      BootstrapDialog.show({
        title: '<?php echo lang("title_delete_customer"); ?>'+name,
        message: '<?php echo lang("message_delete_customer"); ?>',
        type: 'type-danger',
        closable: true,
        buttons: [{
            id: 'btn-delete',
            icon: 'glyphicon glyphicon-trash',
            label: '<?php echo lang("action_delete"); ?>',
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
            BootstrapDialog.alert('<?php echo lang("message_customer_deleted"); ?>', function () {
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
