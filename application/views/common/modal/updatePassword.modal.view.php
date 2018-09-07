<div class="modal-dialog modal-sm" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">×</span></button>
			<h4 class="modal-title">비밀번호 수정</h4>
		</div>
              
		<div class="modal-body">
			<div class="form-group has-feedback">
				<input type="password" id="header-current-password" name="password" class="form-control" placeholder="현재 비밀번호">
				<span class="glyphicon glyphicon-lock form-control-feedback"></span>
			</div>
			
			<div class="form-group has-feedback">
				<input type="password" id="header-password" name="password" class="form-control" placeholder="변경 비밀번호">
				<span class="glyphicon glyphicon-lock form-control-feedback"></span>
			</div>
			
			<div class="form-group has-feedback">
				<input type="password" id="header-password-confirm" name="password" class="form-control" placeholder="변경 비밀번호 확인">
				<span class="glyphicon glyphicon-lock form-control-feedback"></span>
			</div>
		</div>
		
		<div class="modal-footer">
			<button type="button" class="btn btn-flat btn-default" data-dismiss="modal">닫기</button>
			<button type="button" id="btn-header-update-password-member" class="btn btn-flat btn-primary">수정</button>
		</div>
	</div>
</div>

<script>
	$("#btn-header-update-password-member").on("click", function() {
		var currentPassword = $("#header-current-password").val();
		var password = $("#header-password").val();
		var passwordConfirm = $("#header-password-confirm").val();
		
		var data = {
			"currentPassword": currentPassword,
			"password": password,
			"passwordConfirm": passwordConfirm,
		};

		if (confirm("비밀번호를 수정하시겠습니까?")) {
    		$.ajax({
    			type: "POST",
    			data: data,
    			dataType: "json",
    			url: "/member/headerUpdateMemberPassword_ajax",
    			success: function(result) {
    				if (result.status == 200) {
    					alert(result.data);
    					location.reload();
    				} else {
    					alert(result.data);
    				}
    			},
    			error: function(xhr, status, error) {
    				console.log(xhr);
    				console.log(status);
    				console.log(error);
    			}
    		});
		}
	});
</script>