<!DOCTYPE html>
<html>
<head>
	<title>LOGIN</title>
	
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	
	<link rel="stylesheet" href="/asset/bower_components/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="/asset/bower_components/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="/asset/bower_components/Ionicons/css/ionicons.min.css">
	<link rel="stylesheet" href="/asset//dist/css/AdminLTE.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

	<script src="/asset/bower_components/jquery/dist/jquery.min.js"></script>
	<script src="/asset/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body class="hold-transition register-page">
	<div class="register-box">
		<div class="register-logo">
			LOGO
		</div>

		<div class="register-box-body">
			<p class="login-box-msg">Register a new membership</p>
			
			<form action="/auth/register_submit" method="post">
				<div class="form-group has-feedback">
					<select name="groupNameId" class="form-control">
						<?php foreach ($groupNameList as $key => $value) { ?>
						<option value="<?=$value['id']?>"><?=$value['name']?></option>
						<?php } ?>
					</select>
				</div>
				<div class="form-group has-feedback">
					<input type="text" name="memberId" class="form-control" placeholder="ID" required="required"> 
					<span class="glyphicon glyphicon-user form-control-feedback"></span>
				</div>
				<div class="form-group has-feedback">
					<input type="text" name="nickname" class="form-control" placeholder="Nickname" required="required"> 
					<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
				</div>
				<div class="form-group has-feedback">
					<input type="password" name="password" class="form-control" placeholder="Password" required="required">
					<span class="glyphicon glyphicon-lock form-control-feedback"></span>
				</div>
				<div class="form-group has-feedback">
					<input type="password" name="passwordConfirm" class="form-control"	placeholder="Retype password" required="required"> 
					<span class="glyphicon glyphicon-lock form-control-feedback"></span>
				</div>
				
				<div class="row">
					<div class="col-xs-8">
					
					</div>
					
					<div class="col-xs-4">
						<button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
					</div>
				</div>
			</form>
			
			<a href="/auth/login" class="text-center">I already have a membership</a>
		</div>
	</div>
</body>
</html>