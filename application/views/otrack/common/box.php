<div class="col-lg-3 col-md-6">
  <div class="panel panel-<?php echo $status; ?>">
    <div class="panel-heading">
      <div class="row">
        <div class="col-xs-3">
          <?php echo $icon; ?>
        </div>
        <div class="col-xs-9 text-right" style="font-size:25px;font-weight:bold;">
          <div><?php echo $number; ?></div>
          <div><?php echo $text; ?></div>
        </div>
      </div>
    </div>
    <a href="<?php echo $link; ?>" style="color:#000;">
      <div class="panel-footer" style="background-color:#fff;">
        <span class="pull-left"><?php echo lang('action_view_details'); ?></span>
        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
        <div class="clearfix"></div>
      </div>
    </a>
  </div>
</div>