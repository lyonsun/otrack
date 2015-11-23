<?php $this->load->view('otrack/common/header'); ?>

<div class="container-fluid">
  <?php if ($message): ?>
  <div class="alert alert-<?php if ($status): ?><?php echo $status; ?><?php else: ?>danger<?php endif ?>"><?php echo $message;?></div>
  <?php endif ?>

  <?php 
  $customerBoxData = array(
    'status' => 'success',
    'icon' => '<i class="fa fa-users fa-5x"></i>',
    'link' => base_url('customers'),
    'number' => $number_of_customers,
    'text' => lang('customer_heading'),
  );

  $orderBoxData = array(
    'status' => 'primary',
    'icon' => '<i class="fa fa-file fa-5x"></i>',
    'link' => base_url('orders'),
    'number' => $number_of_orders,
    'text' => lang('order_heading'),
  );

  $productBoxData = array(
    'status' => 'info',
    'icon' => '<i class="fa fa-list fa-5x"></i>',
    'link' => base_url('products'),
    'number' => $number_of_products,
    'text' => lang('product_heading'),
  );

  $pendingOrderBoxData = array(
    'status' => 'danger',
    'icon' => '<i class="fa fa-exclamation-circle fa-5x"></i>',
    'link' => base_url('orders').'/index/1',
    'number' => $number_of_pending_orders,
    'text' => lang('field_pending'),
  );
   ?>

  <div class="row">
  <?php $this->load->view('otrack/common/box', $customerBoxData); ?>
  <?php $this->load->view('otrack/common/box', $orderBoxData); ?>
  <?php $this->load->view('otrack/common/box', $productBoxData); ?>
  <?php $this->load->view('otrack/common/box', $pendingOrderBoxData); ?>
  </div>

  <div class="row">    
    <div class="col-md-8">
      <div class="panel panel-primary">
          <div class="panel-heading">
            <h3 class="panel-title"><?php echo lang('heading_order_trends'); ?></h3>
          </div>
          <div class="panel-body">
            <div id="morris-area-chart"></div>
          </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="panel panel-warning">
        <div class="panel-heading">
          <h3 class="panel-title"><?php echo lang('heading_out_of_stock'); ?></h3>
        </div>
        <?php if ($out_of_stock): ?>
        <ul class="list-group">
          <?php foreach ($out_of_stock as $key => $value): ?>
          
          <li class="list-group-item">
            <span class="badge progress-bar-danger"><?php echo $value->stock; ?></span>
            <?php echo $value->name; ?>
          </li>
          <?php endforeach ?>
        </ul>
        <?php else: ?>
        <div class="panel-body">
          <?php echo lang('field_no_matches'); ?>
        </div>
        <?php endif ?>
      </div>
    </div>
  </div>
  
</div>


<script>
  $(function() {

    $.get('<?php echo base_url("home"); ?>/order_trends', function(data) {
      Morris.Line({
        element: 'morris-area-chart',
        data: JSON.parse(data),
        xkey: 'period',
        ykeys: ['order'],
        labels: ['<?php echo lang("heading_order_count"); ?>'],
        // pointSize: 2,
        hideHover: 'auto',
        resize: true,
        parseTime:false,
      });
    });

  });
</script>

<?php $this->load->view('otrack/common/footer'); ?>