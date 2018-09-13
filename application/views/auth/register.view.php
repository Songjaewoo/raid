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
	<script src="/asset/plugins/jQuery-Mask-Plugin-master/jquery.mask.min.js"></script>
	<script src="/asset/plugins/jquery.validate.js"></script>
	
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
<!-- 			LOGO -->
		</div>

		<div class="register-box-body">
			<h4 style="text-align: center;">회원가입</h4>
			
			<form id="register-form" action="/auth/register_submit" method="post">
				<div class="form-group has-feedback">
					<select name="groupNameId" class="form-control">
						<?php foreach ($groupNameList as $key => $value) { ?>
						<option value="<?=$value['id']?>"><?=$value['name']?></option>
						<?php } ?>
					</select>
				</div>
				
				<div class="form-group has-feedback">
					<select name="className" class="form-control">
						<option value="기사">기사</option>
						<option value="요정">요정</option>
						<option value="마법사">마법사</option>
						<option value="다크엘프">다크엘프</option>
						<option value="군주">군주</option>
						<option value="총사">총사</option>
						<option value="투사">투사</option>
					</select>
				</div>
				
				<div class="form-group has-feedback">
					<input type="text" name="memberId" class="form-control" placeholder="아이디" required="required"> 
					<span class="glyphicon glyphicon-user form-control-feedback"></span>
				</div>
				
				<div class="form-group has-feedback">
					<input type="text" name="nickname" class="form-control" placeholder="캐릭터명" required="required"> 
					<span class="glyphicon glyphicon-user form-control-feedback"></span>
				</div>
				
				<div class="form-group has-feedback">
					<input type="text" id="phoneNumber" name="phoneNumber" class="form-control" placeholder="핸드폰 번호" required="required"> 
					<span class="glyphicon glyphicon-phone form-control-feedback"></span>
				</div>
				
				<div class="form-group has-feedback">
					<input type="password" id="password" name="password" class="form-control" placeholder="비밀번호" required="required">
					<span class="glyphicon glyphicon-lock form-control-feedback"></span>
				</div>
				
				<div class="form-group has-feedback">
					<input type="password" name="passwordConfirm" class="form-control"	placeholder="비밀번호 확인" required="required"> 
					<span class="glyphicon glyphicon-lock form-control-feedback"></span>
				</div>
				
				<div class="form-group has-feedback">
					<button type="button" id="btn-register" class="btn btn-primary btn-block btn-flat">회원가입</button>
				</div>
				
				<div class="form-group has-feedback">
					<a href="/auth/login">
						<button type="button" class="btn btn-default btn-block btn-flat">로그인</button>
					</a>
				</div>
			</form>
		</div>
	</div>
	
	<script>
	$(document).ready(function() {
		$.validator.addMethod("alphanumeric", function(value, element) {
			return this.optional(element) || /^[a-zA-Z0-9]+$/.test(value);
		}); 
	    
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

	$("#phoneNumber").mask('000-0000-0000');
	
	$("#btn-register").on("click", function() {
		$("#register-form").validate({
			ignore: [],
	        rules: {
	        	groupNameId: {
	                required : true,
	            },
	            className: {
	                required : true,
	            },
	            memberId: {
	                required : true,
	                alphanumeric : true,
	                rangelength : [4, 15],
	            },
	            nickname: {
	                required : true,
	                rangelength : [1, 10],
	            },
	            phoneNumber: {
	            	required : true,
	            },
	            password: {
	                required : true,
	                rangelength : [4, 20],
	            },
	            passwordConfirm: {
	                required : true,
	                rangelength : [4, 20],
	                equalTo: "#password",
	            },
	        },
	        messages : {
	        	groupNameId: {
	                required : "혈맹을 선택해주세요.",
	            },
	            className: {
	                required : "클래스를 선택해주세요.",
	            },
	            memberId: {
	                required : "아이디를 입력해주세요.",
	                alphanumeric : "아이디는 영문과 숫자만 가능합니다.",
	                rangelength : "아이디 입력범위 4자 ~ 15자",
	            },
	            nickname: {
	                required : "캐릭터명을 입력해주세요.",
	                rangelength : "닉네임 입력범위 1자 ~ 10자",
	            },
	            phoneNumber: {
	            	required : "핸드폰 번호를 입력해주세요.",
	            },
	            password: {
	                required : "비밀번호를 입력해주세요.",
	                rangelength : "비밀번호 입력범위 4자 ~ 20자",
	            },
	            passwordConfirm: {
	                required : "비밀번호 확인을 입력해주세요.",
	                rangelength : "비밀번호 입력범위 4자 ~ 20자",
	                equalTo: "비밀번호가 맞지 않습니다.",
	            },
	        }
	    });
	
		if ($("#register-form").valid()) {
			$("#register-form").submit();
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