<div class="modal-dialog modal-sm" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">×</span></button>
			<h4 class="modal-title">비밀번호 수정</h4>
		</div>
              
		<div class="modal-body">
			<div class="form-group has-feedback">
				<input type="password" id="password" name="password" class="form-control" placeholder="비밀번호" value="">
				<span class="glyphicon glyphicon-lock form-control-feedback"></span>
			</div>
		</div>
		
		<div class="modal-footer">
			<button type="button" class="btn btn-flat btn-default" data-dismiss="modal">닫기</button>
			<button type="button" id="btn-update-password-member" class="btn btn-flat btn-primary">수정</button>
		</div>
	</div>
</div>

<input type="hidden" id="memberId" name="memberId" value="<?=$memberId?>">

<script>
	$("#btn-update-password-member").on("click", function() {
		var memberId = $("#memberId").val();
		var password = $("#password").val();
		
		var data = {
			"memberId": memberId,
			"password": password,
		};

		if (confirm("비밀번호를 수정하시겠습니까?")) {
    		$.ajax({
    			type: "POST",
    			data: data,
    			dataType: "json",
    			url: "/member/updateMemberPassword_ajax",
    			success: function(result) {
    				if (result.status == 200) {
    					alert("수정 완료");
    					location.reload();
    				} else {
    					alert("오류");
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