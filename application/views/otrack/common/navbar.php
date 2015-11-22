<nav class="navbar navbar-default navbar-static-top" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo base_url(); ?>"><?php echo $this->lang->line('site_title'); ?></a>
    </div>
    
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
      <?php if ($this->ion_auth->logged_in()): ?>      
      <ul class="nav navbar-nav">
        <li <?php echo $this->uri->segment(1)==''?'class="active"':""; ?>><a href="<?php echo base_url(); ?>"><i class="fa fa-fw fa-home"></i> <?php echo lang('home_heading'); ?></a></li>
        <li <?php echo $this->uri->segment(1)== 'customers'?'class="active"':""; ?>><a href="<?php echo base_url('customers'); ?>"><i class="fa fa-fw fa-users"></i> <?php echo lang('customer_heading'); ?></a></li>
        <li <?php echo $this->uri->segment(1)== 'orders'?'class="active"':""; ?>><a href="<?php echo base_url('orders'); ?>"><i class="fa fa-fw fa-file"></i> <?php echo lang('order_heading'); ?></a></li>
        <li <?php echo $this->uri->segment(1)== 'products'?'class="active"':""; ?>><a href="<?php echo base_url('products'); ?>"><i class="fa fa-fw fa-list"></i> <?php echo lang('product_heading'); ?></a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="<?php echo base_url('logout'); ?>"><i class="fa fa-fw fa-sign-out"></i> <?php echo lang('logout_heading'); ?></a></li>
      </ul>
      <?php else: ?>
        <?php if ($this->uri->segment(1) != 'login'): ?>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="<?php echo base_url(); ?>"><i class="fa fa-fw fa-sign-in"></i> <?php echo lang('login_heading'); ?></a></li>
        </ul>
        <?php endif ?>
      <?php endif ?>
    </div>
  </div>
</nav>