<?php $this->load->view('otrack/common/header'); ?>
<?php $this->load->view('otrack/common/navbar'); ?>

<div class="container">
  <?php if ($message): ?>
  <div class="alert alert-<?php if ($status): ?><?php echo $status; ?><?php else: ?>danger<?php endif ?>"><?php echo $message;?></div>
  <?php endif ?>
  <h3 class="page-header"><?php echo $title; ?></h3>

  <div class="panel panel-default">
    <div class="panel-body">
      <h4><?php echo $order->buyer_name; ?></h4>
      <p><?php echo $buyer_info; ?></p>
      <p><b>Comments: </b></p>
      <p><?php echo $order->comments; ?></p>
    </div>
    <div class="panel-body bg-primary">
      <b>Products</b>
    </div>
    <ul class="list-group">
    <?php if ($order_products): ?>
      <?php foreach ($order_products as $product): ?>
      <li class="list-group-item">
        <span class="progress-bar-success badge"><?php echo $product->product_amount; ?></span>
        <?php echo $product->product_title; ?>
      </li>          
      <?php endforeach ?>
    <?php endif ?>
    </ul>
  </div>

  <h4 class="page-header">Tracking Information <small><?php echo $order->express_name; ?>: <?php echo $order->tracking_number; ?> <?php echo anchor(base_url('orders/send').'/'.$order->id,'Change Tracking #'); ?></small></h4>

  <div id="tracking_info"></div>
<!-- 
  <?php if ($tracking_info['status'] != '200'): ?>
  <div class="alert alert-danger"><?php echo $tracking_info['status'].': '.$tracking_info['message']; ?></div>
  <?php else: ?>
  <div class="well">
    <p class="lead">Express Company Code: <?php echo isset($tracking_info['companytype']) ? $tracking_info['companytype'] : $tracking_info['com']; ?></p>
  <?php foreach ($tracking_info['data'] as $key => $value): ?>
    <div class="alert alert-info">
    <?php echo $value['time']; ?>
    <span style="margin-left:20px;"><?php echo $value['context']; ?></span>
    </div>
  <?php endforeach ?>
  </div>
  <?php endif ?>
 -->
</div>


<script>
  $(function() {
    var tracking_number = '<?php echo $order->tracking_number; ?>';
        url = '<?php echo base_url("orders"); ?>/get_tracking_info';
        tracking_info = $('#tracking_info');

    ajax_get_tracking_info(tracking_number, url);
  });

  function ajax_get_tracking_info (tracking_number, url) {
    $.ajax({
      url: url,
      type: 'GET',
      dataType: 'json',
      data: {
        tracking_number: tracking_number,
      },
      beforeSend: function () {
        tracking_info.html('<div class="alert alert-info"><i class="fa fa-fw fa-spinner fa-spin"></i> Retriving tracking information...</div>');
      },
      success: function (data) {
        if (data.status != '200') {
          tracking_info.html('<div class="alert alert-danger">'+data.message+' <button type="button" data-tracking_number="'+tracking_number+'" data-url="'+url+'" class="btn btn-default btn-link" id="btn-retry">Retry</button></div>');

          $('#btn-retry').on('click', function(e) {
            ajax_get_tracking_info($(this).data('tracking_number'), $(this).data('url'));      
          });
        } else {
          var tracking_context = '';
          company_code = data.companytype || data.com;
          tracking_company_code = '<p class="lead">Express Company Code: '+company_code+'</p>';
          $.each(data.data, function(index, val) {
            tracking_context += '<div class="alert alert-success">'+val.time+'<span style="margin-left:20px;">'+val.context+'</span></div>';
            
          });
          tracking_info.html('<div class="well">'+tracking_company_code+tracking_context+'</div>');
        }
      }
    });
  }
</script>

<?php $this->load->view('otrack/common/footer'); ?>