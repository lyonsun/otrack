<!DOCTYPE html>
<html lang="zh-cmn-Hans">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Lyon Sun <sunly917@gmail.com>">
    <title><?php echo $title?$title." - ":""; ?><?php echo $this->lang->line('site_title'); ?></title>
    <!-- Bootstrap CSS -->
    <link href="<?php echo base_url(); ?>static/bs3/css/cerulean.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="<?php echo base_url(); ?>static/fa/css/font-awesome.min.css" rel="stylesheet">
    <!-- Otrack CSS -->
    <link href="<?php echo base_url(); ?>static/otrack/css/styles.css" rel="stylesheet">
  </head>
  <body>

      <?php $this->load->view('auth/common/navbar'); ?>