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

  <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Orders <small><a href="<?php echo base_url('orders'); ?>"><i class="fa fa-fw fa-external-link"></i> Details</a></small></h3>
      </div>
    <ul class="list-group">
      <li class="list-group-item"><b>Total Number of Orders:</b> <span class="progress-bar-success badge pull-right"><?php echo $number_of_orders; ?></span></li>
    </ul>
      <div class="panel-body">
        <div class="row">
          <div class="col-md-6">
            <div id="chart1"></div>
          </div>
          <div class="col-md-6">
            <div id="chart2"></div>
          </div>
        </div> 
      </div>
  </div>
  
  
</div>

<?php $this->load->view('otrack/common/js'); ?>

<script>
  $(function() {
    $('#chart1').highcharts({
        chart: {
          plotBackgroundColor: null,
          plotBorderWidth: null,
          // spacing: [50,50,50,50],
          plotShadow: false
        },
        title: {
          text: 'International vs Domestic'
        },
        credits: false,
        tooltip: {
        },
        plotOptions: {
          pie: {
            dataLabels: {
              enabled: false
            },
            showInLegend: true
          }
        },
        series: [{
          type: 'pie',
          name: 'Count',
          data: [
              ['International',     <?php echo $number_of_international_orders; ?>],
              ['Domestic',   <?php echo $number_of_domestic_orders; ?>]
          ]
        }]
    });

    $('#chart2').highcharts({
        chart: {
          plotBackgroundColor: null,
          plotBorderWidth: null,
          // spacing: [50,50,50,50],
          plotShadow: false
        },
        title: {
          text: 'Pending vs Finished'
        },
        credits: false,
        tooltip: {
        },
        plotOptions: {
          pie: {
            dataLabels: {
              enabled: false
            },
            showInLegend: true
          }
        },
        series: [{
          type: 'pie',
          name: 'Count',
          data: [
              ['Pending',     <?php echo $number_of_pending_orders; ?>],
              ['Finished',   <?php echo $number_of_finished_orders; ?>]
          ]
        }]
    });
  });
</script>

<?php $this->load->view('otrack/common/footer'); ?>