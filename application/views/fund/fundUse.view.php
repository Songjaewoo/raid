<div class="content-wrapper">
	<section class="content">
		<div class="row">
			<div class="col-md-8">
				<div class="box box-danger">
					<div class="box-header with-border">
    					<h3 class="box-title">혈비 사용 관리</h3>
    				</div>
    				
    				<div class="box-header">
    					<h3 class="box-title" style="font-size: 16px;">현재 예상 혈비: <strong><?=number_format($currentGroupFund)?></strong></h3>
    					
    					<button type="button" class="btn btn-sm btn-primary btn-flat pull-right" data-toggle="modal" data-target=".add-fund-use-modal">추가</button>
    				</div>
            
					<div class="box-body table-responsive no-padding">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>날짜</th>
									<th>내용</th>
									<th>금액</th>
									<th>작성자</th>
								</tr>
							</thead>
							<tbody>
								<?php if ($fundUseList != null) { ?>
    								<?php foreach ($fundUseList as $key => $value) { ?>
    								<tr>
    									<td><?=$value['useDate']?></td>
    									<td><?=$value['memo']?></td>
    									<td>
    										<?php if ($value['money'] > 0) { ?>
    											+<?=$value['money']?>
    										<?php } else { ?>
	    										<?=$value['money']?>
    										<?php } ?>
    									</td>
    									<td>[<?=$value['groupName']?>] <?=$value['memberNickname']?></td>
    								</tr>
    								<?php } ?>
								<?php } else { ?>
									<tr align="center">
										<td colspan="4">
											리스트가 없습니다.
										</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

<div class="modal fade add-fund-use-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
    			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
    			<span aria-hidden="true">×</span></button>
    			<h4 class="modal-title">혈비 사용 추가</h4>
    		</div>
			<div class="modal-body">
				<div class="form-group" style="margin-bottom: 8px;">
					<label>예상 혈비</label>

					<input type="text" class="form-control" value="<?=number_format($currentGroupFund)?>" readonly>
					<input type="hidden" id="groupFund" value="<?=$currentGroupFund?>">
				</div>
				
				<div class="form-group" style="margin-bottom: 8px;">
					<label>사용</label>
					
					<div class="radio">
						<label>
							<input type="radio" name="useType" value="1" checked="checked">차감
						</label>
						
						<label>
							<input type="radio" name="useType" value="2">누적
						</label>
					</div>
                  
					<div class="row">
						<div class="col-md-8">
							<input type="text" id="useMoney" class="form-control">
						</div>
						
						<div class="col-md-4">
							<button type="button" id="allUse" class="btn btn-warning btn-flat pull-right">전부 사용</button>
						</div>
					</div>
				</div>
				
				<div class="form-group" style="margin-bottom: 8px;">
					<label>잔액</label>
					
					<input id="remainFund" type="text" class="form-control" readonly style="color: #d73925;">
				</div>
				
				<div class="form-group" style="margin-bottom: 8px;">
					<label>메모</label>
					
					<textarea id="memo" class="form-control" cols="3"></textarea>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-flat btn-default" data-dismiss="modal">닫기</button>
				<button type="button" id="btn-add-fund-use" class="btn btn-flat btn-primary">추가</button>
			</div>
		</div>
	</div>
</div>

<script>
$("#allUse").on("click", function() {
	$("#useMoney").val($("#groupFund").val());
	cal();
})

$("#useMoney").keyup(function(){
	cal();
});

function cal(){
	var useType = $(":input:radio[name=useType]:checked").val();
	var groupFund = Number($("#groupFund").val());
	var useMoney = Number($("#useMoney").val());

	if (useType == 1) {
		useMoney = useMoney * -1;
	} else {
		useMoney = useMoney * +1;
	}
	
	$("#remainFund").val(groupFund+useMoney);
}


$("#btn-add-fund-use").on("click", function() {
	var useMoney = $("#useMoney").val();
	var memo = $("#memo").val();
	
	$.ajax({
		type: "POST",
		data: {"useMoney": useMoney, "memo": memo},
		url: "/fund/addFundUse_ajax",
		dataType: "json",
		success: function(result) {
			if (result.status == 200) {
				alert("추가 완료");
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
})
</script>