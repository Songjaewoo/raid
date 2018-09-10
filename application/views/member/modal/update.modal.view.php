<div class="modal-dialog modal-sm" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">×</span></button>
			<h4 class="modal-title">회원정보 수정</h4>
		</div>
              
		<div class="modal-body">
			<div class="form-group has-feedback">
				<select id="groupId" name="groupId" class="form-control">
					<?php foreach ($groupList as $key => $value) { ?>
					<option value="<?=$value['id']?>" <?php if ($memberDetail['groupNameId'] == $value['id']) echo "selected";?>><?=$value['name']?></option>
					<?php } ?>
				</select>
			</div>
			
			<div class="form-group has-feedback">
				<select id="level" name="level" class="form-control">
					<option value="1" <?php if ($memberDetail['level'] == 1) echo "selected";?>>일반</option>
					<option value="2" <?php if ($memberDetail['level'] == 2) echo "selected";?>>보탐</option>
					<option value="3" <?php if ($memberDetail['level'] == 3) echo "selected";?>>수호</option>
					<option value="4" <?php if ($memberDetail['level'] == 4) echo "selected";?>>군주</option>
				</select>
			</div>
			
			<div class="form-group has-feedback">
				<select id="className" name="className" class="form-control">
					<option value="기사" <?php if ($memberDetail['className'] == "기사") echo "selected";?>>기사</option>
					<option value="요정" <?php if ($memberDetail['className'] == "요정") echo "selected";?>>요정</option>
					<option value="마법사" <?php if ($memberDetail['className'] == "마법사") echo "selected";?>>마법사</option>
					<option value="다크엘프" <?php if ($memberDetail['className'] == "다크엘프") echo "selected";?>>다크엘프</option>
					<option value="군주" <?php if ($memberDetail['className'] == "군주") echo "selected";?>>군주</option>
					<option value="총사" <?php if ($memberDetail['className'] == "총사") echo "selected";?>>총사</option>
					<option value="투사" <?php if ($memberDetail['className'] == "투사") echo "selected";?>>투사</option>
				</select>
			</div>
			
			<div class="form-group has-feedback">
				<input type="text" id="nickname" name="nickname" class="form-control" placeholder="캐릭터명" value="<?=$memberDetail['nickname']?>"> 
				<span class="glyphicon glyphicon-user form-control-feedback"></span>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-flat btn-default" data-dismiss="modal">닫기</button>
			<button type="button" id="btn-update-member" class="btn btn-flat btn-primary">수정</button>
		</div>
	</div>
</div>

<input type="hidden" id="memberId" name="memberId" value="<?=$memberDetail['id']?>">

<script>
	$("#btn-update-member").on("click", function() {
		var memberId = $("#memberId").val();
		var nickname = $("#nickname").val();
		var className = $("#className option:selected").val();
		var level = $("#level option:selected").val();
		var groupId = $("#groupId option:selected").val();
		
		var data = {
			"memberId": memberId,
			"nickname": nickname,
			"className": className,
			"level": level,
			"groupId": groupId,
		};

		if (confirm("회원 정보를 수정하시겠습니까?")) {
    		$.ajax({
    			type: "POST",
    			data: data,
    			dataType: "json",
    			url: "/member/memberUpdate_submit_ajax",
    			dataType: "json",
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