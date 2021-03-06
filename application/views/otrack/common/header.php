<!DOCTYPE html>
<html lang="zh-cmn-Hans">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Lyon Sun <sunly917@gmail.com>">
    <title><?php echo $title?$title." - ":""; ?><?php echo $this->lang->line('site_title'); ?></title>
    <!-- Bootstrap CSS -->
    <link href="<?php echo base_url(); ?>static/bs3/css/lumen.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="<?php echo base_url(); ?>static/fa/css/font-awesome.min.css" rel="stylesheet">
    <!-- Bootstrap Dialog CSS -->
    <link href="<?php echo base_url(); ?>static/bs3-dialog/css/bootstrap-dialog.min.css" rel="stylesheet">
    <!-- FormValidation CSS -->
    <link href="<?php echo base_url(); ?>static/fv/css/formValidation.min.css" rel="stylesheet">
    <!-- Dropzone -->
    <link href="<?php echo base_url(); ?>static/dropzone/dropzone.css" rel="stylesheet">
    <!-- Bootstrap Datetime Picker CSS -->
    <link href="<?php echo base_url(); ?>static/bs-dp3/css/bootstrap-datepicker3.min.css" rel="stylesheet">
    <!-- Touch Spin -->
    <link href="<?php echo base_url(); ?>static/touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet">
    <!-- Morris Charts CSS -->
    <link href="<?php echo base_url(); ?>static/morris/css/morris.css" rel="stylesheet">
    <!-- SELECT 2 -->
    <link href="<?php echo base_url(); ?>static/select2-3.5.2/select2.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>static/select2-3.5.2/select2-bootstrap.css" rel="stylesheet" />
    <!-- Otrack CSS -->
    <link href="<?php echo base_url(); ?>static/otrack/css/styles.css" rel="stylesheet">
    <?php $this->load->view('otrack/common/js'); ?>
  </head>
  <body>
    <div id="wrapper">
      <?php $this->load->view('otrack/common/navbar'); ?>
      <div id="main-panel">
      <div class="container">
        <?php if (isset($message)): ?>
        <div class="alert alert-<?php if ($status): ?><?php echo $status; ?><?php else: ?>danger<?php endif ?>"><?php echo $message;?></div>
        <?php endif ?>
        <h4 class="page-header"><?php echo $title; ?></h4>
      </div>
      <div class="container">