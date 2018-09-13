<div class="content-wrapper">
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						<li style="border-top-color: #dd4b39;">
							<a href="/member">회원 목록</a>
						</li>
						<li>
							<a href="/member/approval">가입 대기</a>
						</li>
					</ul>
				</div>
          
				<div class="box box-danger">
					<div class="box-header with-border">
    					<h3 class="box-title">회원 관리 (<?=number_format(COUNT($memberList))?> 명)</h3>
    				</div>
    				
					<div class="box-header">
						<div class="row">
        					<form action="/member" method="get">
								<div class="col-sm-2">
									<select name="groupId" class="form-control input-sm border-input">
										<option value="0">혈맹</option>
										<?php foreach ($groupList as $key => $value) { ?>
										<option value="<?=$value['id']?>" <?php if ($groupId == $value['id']) { echo "selected"; }?>>
											<?=$value['name']?>
										</option>
										<?php } ?>
									</select>
								</div>
								<div class="col-sm-2">
									<select name="level" class="form-control input-sm border-input">
										<option value="0" <?php if ($level == 0) { echo "selected"; }?>>등급</option>
										<option value="1" <?php if ($level == 1) { echo "selected"; }?>>일반</option>
            							<option value="2" <?php if ($level == 2) { echo "selected"; }?>>보탐</option>
            							<option value="3" <?php if ($level == 3) { echo "selected"; }?>>수호</option>
            							<option value="4" <?php if ($level == 4) { echo "selected"; }?>>군주</option>
            							<option value="99" <?php if ($level == 99) { echo "selected"; }?>>관리자</option>
									</select>
								</div>
								<div class="col-sm-2">
									<select name="className" class="form-control input-sm border-input">
										<option value="" <?php if ($className == "") { echo "selected"; }?>>클래스</option>
										<option value="기사" <?php if ($className == "기사") { echo "selected"; }?>>기사</option>
                						<option value="요정" <?php if ($className == "요정") { echo "selected"; }?>>요정</option>
                						<option value="마법사" <?php if ($className == "마법사") { echo "selected"; }?>>마법사</option>
                						<option value="다크엘프" <?php if ($className == "다크엘프") { echo "selected"; }?>>다크엘프</option>
                						<option value="군주" <?php if ($className == "군주") { echo "selected"; }?>>군주</option>
                						<option value="총사" <?php if ($className == "총사") { echo "selected"; }?>>총사</option>
                						<option value="투사" <?php if ($className == "투사") { echo "selected"; }?>>투사</option>
									</select>
								</div>
								<div class="col-sm-2">
									<select name="approval" class="form-control input-sm border-input">
										<option value="1" <?php if ($approval == 1) { echo "selected"; }?>>가입회원</option>
										<option value="2" <?php if ($approval == 2) { echo "selected"; }?>>탈퇴회원</option>
									</select>
								</div>
								<div class="col-sm-2">
									<input type="text" name="nickname" class="form-control input-sm border-input" placeholder="캐릭터명" value="<?=$nickname?>">
								</div>
								<div class="col-sm-1">
									<input type="submit" class="btn btn-sm btn-primary btn-flat" value="검색">
								</div>
        					</form>
						</div>
					</div>
            
					<div class="box-body table-responsive no-padding">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>혈맹</th>
    								<th>등급</th>
    								<th>클래스</th>
    								<th>아이디</th>
    								<th>캐릭터명</th>
    								<th>연락처</th>
    								<th>가입일</th>
    								<th>-</th>
    								<th>-</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($memberList as $key => $value) { ?>
								<tr>
									<td><?=$value['groupName']?></td>
        							<td><?=$value['levelName']?></td>
        							<td><?=$value['className']?></td>
        							<td><?=$value['memberId']?></td>
        							<td><?=$value['nickname']?></td>
        							<td><?=$value['phoneNumber']?></td>
        							<td><?=date("Y-m-d", strtotime($value['createdDateTime']))?></td>
        							<td>
        								<?php if ($value['level'] != 99) { ?>
                        					<button type="button" class="btn-update-modal btn btn-sm btn-primary btn-flat" data-id="<?=$value['id']?>">
                        						수정
                        					</button>
                        					
                        					<?php if ($approval == 1) { ?>
                            					<button type="button" data-id="<?=$value['id']?>" data-approval="2" class="btn-update-approval-member btn btn-sm btn-danger btn-flat">
                            						탈퇴
                            					</button>
                        					<?php } else if ($approval == 2) { ?>
                        						<button type="button" data-id="<?=$value['id']?>" data-approval="1" class="btn-update-approval-member btn btn-sm btn-danger btn-flat">
                            						재승인
                            					</button>
                        					<?php } ?>
                    					<?php } ?>
									</td>
									<td>
										<?php if ($value['level'] != 99) { ?>
										<button type="button" data-id="<?=$value['id']?>" class="btn-update-password-modal btn btn-sm btn-danger btn-flat">
                    						비밀번호 초기화
                    					</button>
                    					<?php } ?>
									</td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
					
					<div class="box-footer">
					
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

<div id="member-update-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	<!-- AJAX MODAL -->
</div>

<div id="member-password-update-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	<!-- AJAX MODAL -->
</div>

<script>
	$(".btn-update-password-modal").on("click", function() {
		var memberId = $(this).data("id");
		$.ajax({
			type: "GET",
			data: {"memberId": memberId},
			url: "/member/memberPasswordUpdateModal_ajax",
			success: function(result) {
				$("#member-password-update-modal").html(result);
				$('#member-password-update-modal').modal('show');
			},
			error: function(xhr, status, error) {
				console.log(xhr);
				console.log(status);
				console.log(error);
			}
		});
	});
	
	$(".btn-update-modal").on("click", function() {
		var memberId = $(this).data("id");
		$.ajax({
			type: "GET",
			data: {"memberId": memberId},
			url: "/member/memberUpdateModal_ajax",
			success: function(result) {
				$("#member-update-modal").html(result);
				$('#member-update-modal').modal('show');
			},
			error: function(xhr, status, error) {
				console.log(xhr);
				console.log(status);
				console.log(error);
			}
		});
	});

	$(".btn-update-approval-member").on("click", function() {
		var memberId = $(this).data("id");
		var approval = $(this).data("approval");
		var confirmMsg = "";
		if (approval == 1) {
			confirmMsg = "재승인 하시겠습니까?";
		} else {
			confirmMsg = "탈퇴 시키시겠습니까?";
		}
		
		if (confirm(confirmMsg)) {
    		$.ajax({
    			type: "POST",
    			data: {"memberId": memberId, "approval": approval},
    			dataType: "json",
    			url: "/member/updateMemberApproval_ajax",
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
