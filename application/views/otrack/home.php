<!DOCTYPE html>
<html lang="zh-cmn-Hans">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>O, Track</title>

		<!-- Bootstrap CSS -->
		<link href="<?php echo base_url(); ?>/static/bs3/css/bootstrap.min.css" rel="stylesheet">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
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
					<li class="active"><a href="<?php echo base_url(); ?>">首页</a></li>
					<li><a href="<?php echo base_url('customers'); ?>">客户</a></li>
					<li><a href="<?php echo base_url('orders'); ?>">订单</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right" style="padding-right:20px;">
					<li><a href="<?php echo base_url('logout'); ?>">退出</a></li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</nav>

		<!-- jQuery -->
		<script src="<?php echo base_url(); ?>/static/jquery-2.1.0.min.js"></script>
		<!-- Bootstrap JavaScript -->
		<script src="<?php echo base_url(); ?>/static/bs3/js/bootstrap.min.js"></script>
	</body>
</html>