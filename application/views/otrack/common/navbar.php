<nav class="navbar navbar-default navbar-static-top" role="navigation">
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
    <span class="sr-only">Toggle navigation</span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="<?php echo base_url(); ?>">O, Track</a>
  </div>
  
  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav">
      <li <?php echo explode('/', uri_string())[0]==''?'class="active"':""; ?>><a href="<?php echo base_url(); ?>">Home</a></li>
      <li <?php echo explode('/', uri_string())[0]== 'customers'?'class="active"':""; ?>><a href="<?php echo base_url('customers'); ?>">Customers</a></li>
      <li <?php echo explode('/', uri_string())[0]== 'orders'?'class="active"':""; ?>><a href="<?php echo base_url('orders'); ?>">Orders</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right" style="padding-right:20px;">
      <li><a href="<?php echo base_url('logout'); ?>">Logout</a></li>
    </ul>
  </div>
</nav>