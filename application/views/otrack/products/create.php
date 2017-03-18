<?php $this->load->view('otrack/common/header'); ?>

  <div class="row">
    <div class="col-md-offset-2 col-md-8">
      <?php
        $form_attributes = array('id'=>'form-create-product', 'class'=>'form-create-product col-md-offset-1 col-md-10');
        $name = array(
        'id' => 'name',
        'name' => 'name',
        'class' => 'form-control',
        'placeholder' => lang('field_name'),
        );
        $description = array(
        'id' => 'description',
        'name' => 'description',
        'class' => 'form-control',
        'placeholder' => lang('field_description'),
        );
        $stock = array(
        'id' => 'stock',
        'name' => 'stock',
        'class' => 'form-control',
        'placeholder' => lang('field_stock'),
        );
        $images = array(
        'id' => 'images',
        'name' => 'images',
        'class' => 'form-control select2',
        'placeholder' => lang('field_images'),
        'options' => $image_options,
        );
        $submit = array(
        'id' => 'btn-create-product',
        'class' => 'btn btn-primary btn-block',
        'type' => 'submit',
        'content' => lang('action_add'),
        );
      ?>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title"><?php echo lang('heading_product_info'); ?></h3>
        </div>
        <div class="panel-body">
          <?php echo form_open(base_url($this->uri->uri_string()), $form_attributes); ?>
          <div class="form-group">
            <?php echo form_label(lang('field_name'), 'name', array('class'=>'control-label')); ?>
            <?php echo form_input($name); ?>
          </div>
          <div class="form-group">
            <?php echo form_label(lang('field_description'), 'description', array('class'=>'control-label')); ?>
            <?php echo form_textarea($description); ?>
          </div>
          <div class="form-group">
            <?php echo form_label(lang('field_stock'), 'stock', array('class'=>'control-label')); ?>
            <?php echo form_input($stock); ?>
          </div>
          <div class="form-group">
            <?php echo form_label(lang('field_images'), 'images', array('class'=>'control-label')); ?>
            <div class="input-group select2-bootstrap-append">
              <?php echo form_dropdown($images); ?>
              <span class="input-group-btn">
                <a class="btn btn-primary" data-toggle="modal" href='#modal-id'><i class="fa fa-plus"></i></a>
              </span>
            </div>
          </div>
          <div class="form-group">
            <?php echo form_button($submit); ?>
          </div>
          <?php echo form_close(); ?>
        </div>
      </div>
      <div class="modal fade" id="modal-id">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header bg-primary">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title"><?php echo lang('heading_upload_new_image'); ?></h4>
            </div>
            <div class="modal-body">
              <div id="dropzone" style="min-height:150px;line-height:150px;border:dotted 3px #436634;cursor:pointer;font-size:20px;font-weight:bold;" class="text-center"><?php echo lang('action_drop_or_select'); ?></div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('action_cancel'); ?></button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


<script>
$(function() {
  // $('select').select2();

  $("input[name='stock']").TouchSpin({
    // verticalbuttons: true,
    min: 0,
    max: 1000,
    initval: 1,
    step: 1,
    decimals: 0,
    boostat: 5,
    maxboostedstep: 10,
    buttondown_class: "btn btn-primary",
    buttonup_class: "btn btn-primary"
  });

  var md = new Dropzone(
    "#dropzone", 
    {
      url: '<?php echo base_url("images") ?>/create',
      previewTemplate: '<div class="well"><div class="dz-preview dz-file-preview"><div class="thumbnail"><img data-src="#" alt="" data-dz-thumbnail><div class="caption"><h3 data-dz-name></h3><p data-dz-size></p><div class="progress"><div class="progress-bar progress-bar-success" role="progressbar" aria-valuemin="0" aria-valuemax="100" data-dz-uploadprogress></div></div><p data-dz-uploadprogress></p><p data-dz-errormessage></p></div></div></div></div>',
      maxFiles: 1,
    }
  );

  function UrlExists(url)
  {
    var http = new XMLHttpRequest();
    http.open('HEAD', url, false);
    http.send();
    return http.status!=404;
  }

  md.on('addedfile', function(file) {
    if (UrlExists('<?php echo base_url(); ?>uploads/'+file.name)) {
      this.removeAllFiles();
      BootstrapDialog.alert('<?php echo lang("images_file_exists"); ?>');
    };
  });

  md.on("success", function (file, response) {
    var response = $.parseJSON(response);
    if(response.code == 501){ // succeeded
      BootstrapDialog.alert('<?php echo lang("image_file_uploaded"); ?>', function () {
        location.reload();
      });
    }else if (response.code == 403){  //  error
      BootstrapDialog.alert(response.msg, function () {
        md.removeAllFiles();
      });
    }
  });

  $('#form-create-product')
  .formValidation({
    framework: 'bootstrap',
    excluded: ':disabled',
    locale: 'en',
    icon: {
      valid: 'glyphicon glyphicon-ok',
      invalid: 'glyphicon glyphicon-remove',
      validating: 'glyphicon glyphicon-refresh'
    },
    err: {
      container: 'tooltip'
    },
    fields: {
      name: {
        validators: {
          notEmpty: {},
        }
      },
      description: {
        validators: {
          notEmpty: {},
        }
      },
      stock: {
        validators: {
          notEmpty: {},
        }
      },
      // images: {
      //   validators: {
      //     notEmpty: {},
      //   }
      // },
    },
  });
});
</script>
<?php $this->load->view('otrack/common/footer'); ?>
