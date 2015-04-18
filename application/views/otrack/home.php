<?php $this->load->view('otrack/common/header'); ?>
<?php $this->load->view('otrack/common/navbar'); ?>

<div class="container">
  <?php if ($message): ?>
  <div class="alert alert-<?php if ($status): ?><?php echo $status; ?><?php else: ?>danger<?php endif ?>"><?php echo $message;?></div>
  <?php endif ?>
  <h3 class="page-header">Home</h3>

	<a class="btn btn-default" href="<?php echo base_url('customers/create'); ?>">Add Customer</a>
	<a class="btn btn-default" href="<?php echo base_url('orders/create'); ?>">Add Order</a>
</div>

<?php $this->load->view('otrack/common/footer'); ?>