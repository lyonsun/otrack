<?php $this->load->view('otrack/common/header'); ?>

<div class="container-fluid">
  <?php if ($message): ?>
  <div class="alert alert-<?php if ($status): ?><?php echo $status; ?><?php else: ?>danger<?php endif ?>"><?php echo $message;?></div>
  <?php endif ?>
  <h3 class="page-header"><?php echo $title; ?></h3>
  
  <div class="list-group">
    <a class="list-group-item" href="<?php echo base_url('customers'); ?>">
      <span class="progress-bar-success badge"><?php echo $number_of_customers; ?></span>
      <b><?php echo lang('customer_heading'); ?></b>
    </a>
  </div>

  <div class="panel panel-default">
    <div class="list-group">
      <a class="list-group-item" href="<?php echo base_url('orders'); ?>">
        <span class="progress-bar-success badge"><?php echo $number_of_orders; ?></span>
        <b><?php echo lang('order_heading'); ?></b>
      </a>
    </div>
    <table class="table table-bordered text-center">
      <thead class="bg-warning">
        <tr>
          <th class="text-center"><?php echo lang('field_international'); ?></th>
          <th class="text-center"><?php echo lang('field_domestic'); ?></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><span class="progress-bar-info badge"><?php echo $number_of_international_orders; ?></span></td>
          <td><span class="progress-bar-info badge"><?php echo $number_of_domestic_orders; ?></span></td>
        </tr>
      </tbody>
      <thead class="bg-warning">
        <tr>
          <th class="text-center"><?php echo lang('field_pending'); ?></th>
          <th class="text-center"><?php echo lang('field_finished'); ?></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><?php echo anchor(base_url('orders').'/index/1', '<span class="progress-bar-danger badge">'.$number_of_pending_orders.' <i class="fa fa-fw fa-arrow-right"></i></span>'); ?></td>
          <td><?php echo anchor(base_url('orders').'/index/2', '<span class="badge">'.$number_of_finished_orders.' <i class="fa fa-fw fa-arrow-right"></i></span>'); ?></td>
        </tr>
      </tbody>
    </table>
  </div>
  
  
</div>


<script>
  $(function() {

  });
</script>

<?php $this->load->view('otrack/common/footer'); ?>