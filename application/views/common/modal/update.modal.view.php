<div class="modal-dialog modal-sm" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">×</span></button>
			<h4 class="modal-title">회원정보 수정</h4>
		</div>
              
		<div class="modal-body">
			<div class="form-group has-feedback">
				<input type="text" class="form-control" value="<?=$memberDetail['memberId']?>" readonly="readonly"> 
				<span class="glyphicon glyphicon-user form-control-feedback"></span>
			</div>
			
			<div class="form-group has-feedback">
				<select id="header-groupId" name="groupId" class="form-control">
					<?php foreach ($groupList as $key => $value) { ?>
					<option value="<?=$value['id']?>" <?php if ($memberDetail['groupNameId'] == $value['id']) echo "selected";?>><?=$value['name']?></option>
					<?php } ?>
				</select>
			</div>
			
			<div class="form-group has-feedback">
				<select id="header-className" name="className" class="form-control">
					<option value="기사" <?php if ($memberDetail['className'] == "기사") echo "selected";?>>기사</option>
					<option value="요정" <?php if ($memberDetail['className'] == "요정") echo "selected";?>>요정</option>
					<option value="마법사" <?php if ($memberDetail['className'] == "마법사") echo "selected";?>>마법사</option>
					<option value="다크엘프" <?php if ($memberDetail['className'] == "다크엘프") echo "selected";?>>다크엘프</option>
					<option value="총사" <?php if ($memberDetail['className'] == "총사") echo "selected";?>>총사</option>
					<option value="투사" <?php if ($memberDetail['className'] == "투사") echo "selected";?>>투사</option>
				</select>
			</div>
			
			<div class="form-group has-feedback">
				<input type="text" id="header-nickname" name="nickname" class="form-control" placeholder="캐릭터명" value="<?=$memberDetail['nickname']?>"> 
				<span class="glyphicon glyphicon-user form-control-feedback"></span>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-flat btn-default" data-dismiss="modal">닫기</button>
			<button type="button" id="btn-header-update-member" class="btn btn-flat btn-primary">수정</button>
		</div>
	</div>
</div>

<script>
	$("#btn-header-update-member").on("click", function() {
		var nickname = $("#header-nickname").val();
		var className = $("#header-className option:selected").val();
		var groupId = $("#header-groupId option:selected").val();
		
		var data = {
			"nickname": nickname,
			"className": className,
			"groupId": groupId,
		};

		if (confirm("프로필 정보를 수정하시겠습니까?")) {
    		$.ajax({
    			type: "POST",
    			data: data,
    			dataType: "json",
    			url: "/member/headerMemberUpdate_submit_ajax",
    			dataType: "json",
    			success: function(result) {
    				if (result.status == 200) {
    					alert("수정 완료. 재로그인이 필요합니다.");
    					location.href = "/auth/login";
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