<!DOCTYPE html>
<html>
<head>
<!-- 	<title>LINEAGE M</title> -->
	
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	
	<link rel="stylesheet" href="/asset/bower_components/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="/asset/bower_components/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="/asset/dist/css/skins/_all-skins.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
	<link rel="stylesheet" href="/asset/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
	<link rel="stylesheet" href="/asset/bower_components/select2/dist/css/select2.min.css">
	<link rel="stylesheet" href="/asset/plugins/iCheck/all.css">
	<link rel="stylesheet" href="/asset/bower_components/Ionicons/css/ionicons.min.css">
	<link rel="stylesheet" href="/asset/dist/css/AdminLTE.min.css">
	
	<script src="/asset/bower_components/jquery/dist/jquery.min.js"></script>
	<script src="/asset/bower_components/jquery-ui/jquery-ui.min.js"></script>
	<script src="/asset/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="/asset/bower_components/jquery.countdown/jquery.countdown.min.js"></script>
	<script src="/asset/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
	<script src="/asset/bower_components/select2/dist/js/select2.full.min.js"></script>
	<script src="/asset/plugins/jQuery-Mask-Plugin-master/jquery.mask.min.js"></script>
	<script src="/asset/plugins/jquery.validate.js"></script>
	<script src="/asset/plugins/iCheck/icheck.min.js"></script>
	<script src="/asset/dist/js/adminlte.min.js"></script>
	
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	
	<script>
		$(document).ready(function() {
			var uriSegment1 = "<?=$uriSegment1?>";
			var uriSegment2 = "<?=$uriSegment2?>";
			
			if (uriSegment1 == "") {
				$("#nav-home").addClass("active");
			} else if (uriSegment1 == "boss") {
				$("#nav-boss").addClass("active");
			} else if (uriSegment1 == "bossBoard") {
				$("#nav-boss-board").addClass("active");
			} else if (uriSegment1 == "item") {
				$("#nav-item").addClass("active");
			} else if (uriSegment1 == "dividend") {
				$("#nav-dividend").addClass("active");
			} else if (uriSegment1 == "fund") {
				$("#nav-fund").addClass("active").addClass("menu-open");

				if (uriSegment2 == "useList") {
					$("#nav-fund-use").addClass("active")
				} else if (uriSegment2 == "back") {
					$("#nav-fund-back").addClass("active")
				}
			} else if (uriSegment1 == "member") {
				$("#nav-member").addClass("active");
			}

			$("#btn-header-update-member-modal").on("click", function() {
				$.ajax({
					type: "GET",
					url: "/member/headerMemberUpdateModal_ajax",
					success: function(result) {
						$("#header-member-update-modal").html(result);
						$('#header-member-update-modal').modal('show');
					},
					error: function(xhr, status, error) {
						console.log(xhr);
						console.log(status);
						console.log(error);
					}
				});
			});

			$("#btn-header-update-password-modal").on("click", function() {
				$.ajax({
					type: "GET",
					url: "/member/headerMemberPasswordUpdateModal_ajax",
					success: function(result) {
						$("#header-member-password-update-modal").html(result);
						$('#header-member-password-update-modal').modal('show');
					},
					error: function(xhr, status, error) {
						console.log(xhr);
						console.log(status);
						console.log(error);
					}
				});
			});
		});
	</script>
</head>
<body class="hold-transition skin-red sidebar-mini">
	<div class="wrapper">
		<header class="main-header">
			<a href="/" class="logo">
<!-- 				<span class="logo-mini">Lin <b>M</b></span> -->
<!-- 				<span class="logo-lg">Lineage M</span> -->
			</a>
			<nav class="navbar navbar-static-top">
				<!-- Sidebar toggle button-->
				<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
					<span class="sr-only">Toggle navigation</span>
				</a>
				
				<div class="navbar-custom-menu">
					<ul class="nav navbar-nav">
						<li class="dropdown user user-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
								<img src="/asset/dist/img/avatar.png" class="user-image" alt="User Image">
								<span class="hidden-xs">[<?=LOGIN_GROUP_NAME?>] <?=LOGIN_NICKNAME?></span>
							</a>
							
							<ul class="dropdown-menu">
								<li class="user-header">
									<img src="/asset/dist/img/avatar.png" class="img-circle" alt="User Image">
									<p>[<?=LOGIN_GROUP_NAME?>] <?=LOGIN_NICKNAME?></p>
								</li>
								<li class="user-body">
									<div class="row">
										<div id="btn-header-update-member-modal" class="col-xs-4 text-center">
											<a href="#">프로필</a>
										</div>
										<div id="btn-header-update-password-modal" class="col-xs-4 text-center">
											<a href="#">비밀번호</a>
										</div>
										<div class="col-xs-4 text-center">
											<a href="/auth/logout">로그아웃</a>
										</div>
									</div>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</nav>
		</header>
		
		
		<aside class="main-sidebar">
			<section class="sidebar">
				<div class="user-panel" style="height: 85px;">
					<div class="pull-left image">
						<img src="/asset/dist/img/avatar.png" class="img-circle" alt="User Image">
					</div>
					<div class="pull-left info">
						<p><?=LOGIN_NICKNAME?></p>
						<p href="javascript:void(0);"><i class="fa fa-dollar"></i> 
							분배금: <?=number_format($myDividend)?>
						</p>
						<?php if ($myPayment != null) { ?>
						<p href="javascript:void(0);"><i class="fa fa-dollar"></i> 
							상납금: <?=number_format($myPayment)?>
						</p>
						<?php } ?>
					</div>
				</div>
      
				<ul class="sidebar-menu" data-widget="tree">
					<li class="header">Menu</li>
					<li id="nav-home">
						<a href="/">
							<i class="fa fa-home"></i>
							<span>HOME</span>
						</a>
					</li>
					<li id="nav-boss">
						<a href="/boss">
							<i class="fa fa-clock-o"></i>
							<span>보스 시간표</span>
						</a>
					</li>
					<li id="nav-boss-board">
						<a href="/bossBoard">
							<i class="fa fa-list-ul"></i>
							<span>보스탐 참여</span>
						</a>
					</li>
					<li id="nav-item">
						<a href="/item">
							<i class="fa fa-book"></i>
							<span>아이템 혈원가</span>
						</a>
					</li>
					<li id="nav-dividend">
						<a href="/dividend">
							<i class="fa fa-dollar"></i>
							<span>정산 관리</span>
						</a>
					</li>
					<li id="nav-fund" class="treeview">
						<a href="#">
							<i class="fa fa-dollar"></i> 
							<span>혈비 관리</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
                            <li id="nav-fund-use">
                            	<a href="/fund/useList">
                            	<i class="fa fa-credit-card"></i> 혈비 사용</a>
                            </li>
                            <li id="nav-fund-back"> 
                            	<a href="/fund/back">
                            	<i class="fa fa-credit-card"></i> 혈비 상납</a>
                            </li>
						</ul>
					</li>
					<li id="nav-member">
						<a href="/member">
							<i class="fa fa-user"></i>
							<span>회원 관리</span>
						</a>
					</li>
				</ul>
			</section>
		</aside>

		<div id="header-member-update-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
			<!-- AJAX MODAL -->
		</div>
		
		<div id="header-member-password-update-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
			<!-- AJAX MODAL -->
		</div>
	