<?php $this->load->view('otrack/common/header'); ?>

  <div class="row" id="boxes"></div>
  <div class="row">
    <div class="col-md-12" id="products-list"></div>
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title"><?php echo lang('heading_order_trends'); ?></h3>
        </div>
        <div class="panel-body">
          <div id="order_trends_line" style="max-height:200px !important;"></div>
        </div>
      </div>
    </div>
  </div>

<script src="<?php echo base_url(); ?>static/otrack/js/home/components.js"></script>
<script src="<?php echo base_url(); ?>static/otrack/js/home/index.js"></script>

<script>
  $(function() {
    $.get('<?php echo base_url("home"); ?>/order_trends', function(data) {
      Morris.Line({
        element: 'order_trends_line',
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