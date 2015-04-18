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
        'Address',
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
          $customer->district,
          $customer->city,
          $customer->province,
          $customer->zipcode,
          'TODO',
        );

        $this->table->add_row($row);
      }

      echo $table = $this->table->generate();
  }
   ?>
</div>

<?php $this->load->view('otrack/common/footer'); ?>