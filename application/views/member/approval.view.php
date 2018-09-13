<div class="content-wrapper">
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						<li>
							<a href="/member">회원 목록</a>
						</li>
						<li style="border-top-color: #dd4b39;">
							<a href="/member/approval">가입 대기</a>
						</li>
					</ul>
				</div>
          
				<div class="box box-danger">
					<div class="box-header with-border">
    					<h3 class="box-title">가입 대기 <small>(검색결과: <?=number_format(COUNT($memberList))?> 건)</small></h3>
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
                						<button type="button" data-id="<?=$value['id']?>" data-approval="1" class="btn-update-approval-member btn btn-sm btn-primary btn-flat">
                    						가입 승인
                    					</button>
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

<script>
	$(".btn-update-approval-member").on("click", function() {
		var memberId = $(this).data("id");
		var approval = $(this).data("approval");

		if (confirm("가입 승인 하시겠습니까?")) {
    		$.ajax({
    			type: "POST",
    			data: {"memberId": memberId, "approval": approval},
    			dataType: "json",
    			url: "/member/updateMemberApproval_ajax",
    			success: function(result) {
    				if (result.status == 200) {
    					alert("승인 완료");
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
