<!DOCTYPE html>
<html>
<head>
	<title>LINEAGE M</title>
	
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	
	<link rel="stylesheet" href="/asset/bower_components/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="/asset/bower_components/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="/asset/dist/css/skins/_all-skins.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
	<link rel="stylesheet" href="/asset/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
	<link rel="stylesheet" href="/asset/bower_components/select2/dist/css/select2.min.css">
	<link rel="stylesheet" href="/asset/dist/css/AdminLTE.min.css">
	
	<script src="/asset/bower_components/jquery/dist/jquery.min.js"></script>
	<script src="/asset/bower_components/jquery-ui/jquery-ui.min.js"></script>
	<script src="/asset/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="/asset/bower_components/jquery.countdown/jquery.countdown.min.js"></script>
	<script src="/asset/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
	<script src="/asset/bower_components/select2/dist/js/select2.full.min.js"></script>
	<script src="/asset/plugins/jQuery-Mask-Plugin-master/jquery.mask.min.js"></script>
	<script src="/asset/plugins/jquery.validate.js"></script>
	<script src="/asset/dist/js/adminlte.min.js"></script>
	
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body class="hold-transition skin-red sidebar-mini">
	<div class="wrapper">
		<header class="main-header">
			<a href="/" class="logo">
				<span class="logo-mini">Lin <b>M</b></span>
				<span class="logo-lg">Lineage M</span>
			</a>
			<nav class="navbar navbar-static-top">
				<!-- Sidebar toggle button-->
				<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
					<span class="sr-only">Toggle navigation</span>
				</a>
				
				<div class="navbar-custom-menu">
					<ul class="nav navbar-nav">
						<li class="dropdown user user-menu">
							<a href="javascript:voie(0);">
								<span class="hidden-xs">[<?=LOGIN_GROUP_NAME?>] <?=LOGIN_NICKNAME?></span>
							</a>
						</li>
						
						<li>
							<a href="/auth/logout"><i class="glyphicon glyphicon-log-out"></i></a>
						</li>
					</ul>
				</div>
			</nav>
		</header>
		
		
		<aside class="main-sidebar">
			<section class="sidebar">
				<ul class="sidebar-menu" data-widget="tree">
					<li class="header">Menu</li>
					<li>
						<a href="/boss">
							<i class="fa fa-calendar"></i> <span>보스 시간표</span>
						</a>
					</li>
					<li>
						<a href="/bossBoard">
							<i class="fa fa-list-ul"></i> <span>보스탐 참여</span>
						</a>
					</li>
				</ul>
			</section>
		</aside>
