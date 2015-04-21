<?php $this->load->view('otrack/common/header'); ?>
<?php $this->load->view('otrack/common/navbar'); ?>

<div class="container">
  <?php if ($message): ?>
  <div class="alert alert-<?php if ($status): ?><?php echo $status; ?><?php else: ?>danger<?php endif ?>"><?php echo $message;?></div>
  <?php endif ?>
  <h3 class="page-header"><?php echo $title; ?></h3>
  
  <div class="list-group">
    <a class="list-group-item" href="<?php echo base_url('customers'); ?>">
      <span class="progress-bar-success badge"><?php echo $number_of_customers; ?></span>
      <b>Customers</b>
    </a>
  </div>
</div>

<?php $this->load->view('otrack/common/footer'); ?>