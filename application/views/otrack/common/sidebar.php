<div class="sidebar" data-color="azure" data-image="">
  
  <!--
  
  Tip 1: you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple"
  Tip 2: you can also add an image using data-image tag
  
  -->
  
  <div class="sidebar-wrapper">
    <div class="logo">
      <a class="simple-text" href="<?php echo base_url(); ?>"><?php echo $this->lang->line('site_title'); ?></a>
    </div>
  
    <?php if ($this->ion_auth->logged_in()): ?>
    <ul class="nav" id="side-menu">
      <!-- <li class="sidebar-search">
        <div class="input-group custom-search-form">
          <input type="text" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
            <button class="btn btn-default" type="button">
            <i class="fa fa-search"></i>
            </button>
          </span>
        </div>          
      </li> -->
      <li <?php echo $this->uri->segment(1)==''?'class="active"':""; ?>><a href="<?php echo base_url(); ?>"><i class="fa fa-fw fa-home"></i> <?php echo lang('home_heading'); ?></a></li>
      <li <?php echo $this->uri->segment(1)== 'customers'?'class="active"':""; ?>><a href="<?php echo base_url('customers'); ?>"><i class="fa fa-fw fa-users"></i> <?php echo lang('customer_heading'); ?></a></li>
      <li <?php echo $this->uri->segment(1)== 'orders'?'class="active"':""; ?>><a href="<?php echo base_url('orders'); ?>"><i class="fa fa-fw fa-file"></i> <?php echo lang('order_heading'); ?></a></li>
      <li <?php echo $this->uri->segment(1)== 'products'?'class="active"':""; ?>><a href="<?php echo base_url('products'); ?>"><i class="fa fa-fw fa-list"></i> <?php echo lang('product_heading'); ?></a></li>

      <li><a href="<?php echo base_url('logout'); ?>"><i class="fa fa-fw fa-sign-out"></i> <?php echo lang('logout_heading'); ?></a></li>
    </ul>
    <?php endif ?>

  </div>
</div>