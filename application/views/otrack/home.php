<?php $this->load->view('otrack/common/header'); ?>
<div class="container">
  <?php if ($message): ?>
  <div class="alert alert-<?php if ($status): ?><?php echo $status; ?><?php else: ?>danger<?php endif ?>"><?php echo $message;?></div>
  <?php endif ?>
  <div class="row" id="boxes"></div>
  <div class="row">
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title"><?php echo lang('heading_product_list'); ?></h3>
        </div>
        <?php if ($products): ?>
        <div class="list-group">
          <?php foreach ($products as $key => $value): ?>
          <?php
          if ($value->stock <= 1) {
          $status = 'progress-bar-danger';
          } else if ($value->stock <= 5) {
          $status = 'progress-bar-warning';
          } else {
          $status = 'progress-bar-success';
          }
          ?>
          
          <a href="<?php echo base_url('products'); ?>/view/<?php echo $value->id; ?>" class="list-group-item">
            <span class="badge <?php echo $status; ?>"><?php echo $value->stock; ?></span>
            <?php echo $value->name; ?>
          </a>
          <?php endforeach ?>
        </div>
        <?php else: ?>
        <div class="panel-body">
          <?php echo lang('field_no_matches'); ?>
        </div>
        <?php endif ?>
      </div>
    </div>
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title"><?php echo lang('heading_order_trends'); ?></h3>
        </div>
        <div class="panel-body">
          <div id="morris-area-chart" style="max-height:200px !important;"></div>
        </div>
      </div>
    </div>
  </div>  
</div>

<script src="<?php echo base_url(); ?>static/otrack/js/dashbox.js"></script>
<script src="<?php echo base_url(); ?>static/otrack/js/home.js"></script>

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