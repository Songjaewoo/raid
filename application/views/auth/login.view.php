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
	<script src="/asset/plugins/jquery.validate.js"></script>
	
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body class="hold-transition register-page">
	<div class="login-box">
		<div class="login-logo">
<!-- 			<a href="#"><b>Admin</b>LTE</a> -->
		</div>
		<div class="login-box-body">
			<form id="login-form" action="/auth/login_submit" method="post">
				<div class="form-group has-feedback">
					<input type="text" id="memberId" name="memberId" class="form-control" placeholder="아이디">
					<span class="glyphicon glyphicon-user form-control-feedback"></span>
				</div>
				
				<div class="form-group has-feedback">
					<input type="password" name="password" class="form-control" placeholder="비밀번호">
					<span class="glyphicon glyphicon-lock form-control-feedback"></span>
				</div>
				
<!-- 				<div class="form-group has-feedback"> -->
<!-- 					<label> -->
<!-- 						<input id="check-save-id" type="checkbox"> 아이디 저장 -->
<!-- 					</label> -->
<!-- 				</div> -->
				
				<div class="form-group has-feedback">
					<button type="submit" id="btn-login" class="btn btn-primary btn-block btn-flat">로그인</button>
				</div>
				
				<div class="form-group has-feedback">
					<a href="/auth/register">
						<button type="button" class="btn btn-default btn-block btn-flat">회원가입</button>
					</a>
				</div>
			</form>
		</div>
	</div>
	
	<script>
	$(document).ready(function() {
		$.validator.setDefaults({
			onkeyup:false,
	        onclick:false,
	        onfocusout:false,
		    showErrors:function(errorMap, errorList){
		        if(this.numberOfInvalids()) {
		            alert(errorList[0].message);
		        }
		    }
		});
	});

	$("#btn-login").on("click", function() {
		$("#login-form").validate({
			ignore: [],
	        rules: {
	        	memberId: {
	                required : true,
	            },
	            password: {
	                required : true,
	            },
	        },
	        messages : {
	        	memberId: {
	                required : "아이디를 입력해 주세요.",
	            },
	            password: {
	                required : "비밀번호를 입력해 주세요.",
	            },
	        }
	    });
	
		if ($("#login-form").valid()) {
			$("#login-form").submit();
		}
	});
	</script>
	
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-125736950-1"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());
	
	  gtag('config', 'UA-125736950-1');
	</script>
</body>
</body>
</html>