<?php $this->load->view('otrack/common/header'); ?>
<?php $this->load->view('otrack/common/navbar'); ?>

<div class="container">
  <h3 class="page-header">Home</h3>

	<a class="btn btn-default" href="<?php echo base_url('customers/create'); ?>">Add Customer</a>
	<a class="btn btn-default" href="<?php echo base_url('orders/create'); ?>">Add Order</a>
</div>

<?php $this->load->view('otrack/common/footer'); ?>