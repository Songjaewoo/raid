<div class="content-wrapper">
	<section class="content">
		<div class="row">
			<div class="col-md-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-group">
							<label>날짜</label>

							<div class="input-group date">
								<div class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</div>
								<input type="text" class="form-control pull-right" value="<?=date("Y-m-d", strtotime($detailBossBoard['killDateTime']))?>" disabled="disabled">
							</div>
						</div>
						
						<div class="form-group">
							<label>보스</label>
							<input type="text" class="form-control" value="<?=$detailBossBoard['bossName']?>" disabled="disabled">
						</div>
						
						<div class="form-group">
							<label>드랍 아이템 +입찰자</label>
							
							<table class="table table-bordered table-striped">
								<tbody id="boss-item-list">
									<tr>
										<th>드랍아이템</th>
										<th>가격</th>
										<th>입찰자</th>
									</tr>
									<?php if ($detailBossBoard['item'] != null) { ?>
    									<?php foreach ($detailBossBoard['item'] as $key => $value) { ?>
    									<tr>
    										<td><span style="color: <?=$value['itemLevelColor']?>;"><?=$value['itemName']?></span></td>
    										<td><?=$value['itemPrice']?></td>
    										<td><?=$value['buyerMemberNickname']?></td>
    									</tr>
    									<?php } ?>
									<?php } else { ?>
    									<tr>
    										<td colspan="3" align="center">리스트가 없습니다.</td>
    									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
						
						<div class="form-group">
							<label>사진</label>
							
							<div class="row">
								<div class="col-md-12">
								<?php foreach ($detailBossBoard['attachFile'] as $key => $value) { ?>
									<a href="<?=$value['fileUrl']?>" target="_blank">
        								<img src="<?=$value['fileUrl']?>" style="max-width: 100%;">
        							</a>
        							<br><br>
								<?php } ?>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label>비고</label>

							<textarea class="form-control" rows="5" disabled="disabled"><?=$detailBossBoard['etc']?></textarea>
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-md-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-group">
							<label>참여인원 <span id="count-participant"><?=COUNT($detailBossBoard['participant'])?></span>명</label>
							
							<table class="table table-bordered table-striped">
								<tbody id="participant-list">
									<tr>
										<th>혈맹</th>
										<th>혈맹원</th>
										<th>분배금</th>
										<th>정산</th>
									</tr>
									<?php if ($detailBossBoard['participant'] != null) { ?>
    									<?php foreach ($detailBossBoard['participant'] as $key => $value) { ?>
    									<tr>
    										<td><?=$value['groupName']?></td>
    										<td><?=$value['memberNickname']?></td>
    										<td><?=$value['dividend']?></td>
    										<td>
												<?php if ($value['isFinish'] == "Y") { ?>
													<?php $isFinish = true; ?>
													완료
												<?php } else { ?>
												<button type="button" data-id="<?=$value['id']?>" class="btn-dividend-finish btn btn-sm btn-warning btn-flat">
													미완료
            									</button>
												<?php } ?>
											</td>
    									</tr>
    									<?php } ?>
									<?php } else { ?>
    									<tr>
    										<td colspan="4" align="center">리스트가 없습니다.</td>
    									</tr>
									<?php } ?>
									
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12" style="text-align: center;">
				<?php if ($isFinish != true) { ?>
				<button type="button" id="btn-del-boss-board" data-id="<?=$bossBoardId?>" class="btn btn-danger btn-flat" style="width: 100px;">
					삭제
				</button>
				<?php } ?>
				
				<a href="/bossBoard">
					<button type="button" class="btn btn-default btn-flat" style="width: 100px;">
						목록
					</button>
				</a>
			</div>
		</div>
	</section>
</div>

<script>
$(".btn-dividend-finish").on("click", function() {
	if (confirm("정산 하시겠습니까?")) {
		var id = $(this).data("id");
		$.ajax({
        	type : "POST",
        	data : {"id": id},
        	dataType : "json",
        	url : "/dividend/updateDividendFinish_ajax",
        	success : function(result) {
        		if (result.status == 200) {
        			alert("정산 완료 하였습니다.");
        			location.reload();
        		} else {
        			alert("오류");
        		}
        	},
        	error : function(xhr, status, error) {
        		console.log(xhr);
        		console.log(status);
        		console.log(error);
        	}
        });
	}	
})

$("#btn-del-boss-board").on("click", function() {
	if (confirm("삭제하시겠습니까?")) {
		var bossBoardId = $(this).data("id");
        $.ajax({
        	type : "POST",
        	data : {"bossBoardId": bossBoardId},
        	dataType : "json",
        	url : "/bossBoard/delete_ajax",
        	success : function(result) {
        		if (result.status == 200) {
        			alert("삭제 하였습니다.");
        			location.href = "/bossBoard";
        		} else {
        			alert("오류");
        		}
        	},
        	error : function(xhr, status, error) {
        		console.log(xhr);
        		console.log(status);
        		console.log(error);
        	}
        });
	}
})
</script>