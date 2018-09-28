<section class="content">
	<div class="row">
		<div class="col-md-8">
			<div class="box box-danger">
				<div class="box-header with-border">
					<h3 class="box-title">
						보스 젠 시간
						<i id="btn-refresh" class="fa fa-fw fa-refresh" style="cursor: pointer;"></i>
					</h3>
					
					<button type="button" class="btn btn-sm btn-primary btn-flat pull-right" data-toggle="modal" data-target=".add-boss-modal">추가</button>
				</div>
            
				<div class="box-body table-responsive no-padding">
					<table class="table table-bordered table-hover" style="font-size: 17px;">
						<thead>
							<tr>
								<th>보스이름</th>
								<th>다음보탐시간</th>
								<th>남은시간</th>
								<th>킬</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($bossList as $key => $value) { ?>
							<tr>
								<td class="mouse-over-out">
									<?=$value['name']?>
									<i class="fa fa-trash-o btn-update-display" data-id="<?=$value['id']?>" style="display: none; margin-left: 12px; cursor: pointer;"></i>
								</td>
								<td><b><?=$value['nextTime']?></b></td>
								<td class="count-down-time" data-time="<?=$value['nextTime']?>"></td>
								<td>
									<button type="button" class="btn btn-danger btn-flat btn-update-kill-time" 
											data-id="<?=$value['id']?>">KILL</button>
									<button type="button" class="btn btn-danger btn-flat btn-update-kill-pass" 
											data-id="<?=$value['id']?>">PASS</button>
											
									<div class="btn-group">
										<button type="button" class="btn btn-warning btn-flat dropdown-toggle" data-toggle="dropdown" aria-expanded="false">직접입력</button>
										<div class="dropdown-menu pull-left" role="menu">
											<input type="text" class="form-control dateTimeMask direct-time-<?=$value['id']?>" value="<?=$currentDateTime?>" 
												style="width: 150px; float: left;">
												
											<button type="button" class="btn btn-danger btn-flat btn-update-direct-time" data-id="<?=$value['id']?>" style="float: left;">
												<span class="fa fa-caret-square-o-up"></span>
											</button>
										</div>
									</div>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		
		<div class="col-md-4">
			<div class="box box-danger">
				<div class="box-header with-border">
					<h3 class="box-title">메모사항</h3>
					
					<button type="button" id="btn-add-memo" class="btn btn-sm btn-primary btn-flat pull-right">
						수정
					</button>
				</div>
            
				<div class="box-body">
					<textarea id="memo-content" class="form-control" rows="10"><?=$bossMemoList[0]['content']?></textarea>
				</div>
				
				<div class="box-footer">
					[<?=$bossMemoList[0]['groupName']?>] <?=$bossMemoList[0]['nickname']?> <?=$bossMemoList[0]['createdDateTime']?>
				</div>
			</div>
		</div>
		
		<div class="col-md-4">
			<div class="box box-danger">
				<div class="box-header with-border">
					<h3 class="box-title">계산기</h3>
					
					<button type="button" class="btn btn-sm btn-primary btn-flat pull-right" data-toggle="modal" data-target=".tax-modal">
						세율수정
					</button>
				</div>
            
				<div class="box-body table-responsive no-padding">
					<table class="table table-bordered table-hover">
						<tbody>
							<tr>
								<th>세율</th>
								<td>
									<input type="number" id="rate" class="form-control input-sm" value="<?=$taxPercent?>">
								</td>
							</tr>
							<tr>
								<th>거래소등록</th>
								<td><input type="number" id="reg" class="form-control input-sm" value="0"></td>
							</tr>
							<tr>
								<th>혈원가</th>
								<td><input type="number" id="price" class="form-control input-sm" value="0"></td>
							</tr>
							<tr>
								<td colspan="2">
									<input type="button" onclick="cal()" class="btn btn-sm btn-primary btn-flat pull-right" value="계산하기">
								</td>
							</tr>
							<tr>
								<th>1차 정산금</th>
								<td><input type="number" id="temp1" class="form-control input-sm cal" value="0" readonly="readonly"></td>
							</tr>
							<tr>
								<th>페이백 금액</th>
								<td><input type="number" id="temp2" class="form-control input-sm cal text-red strong" value="0" readonly="readonly"></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>

<div class="modal fade tax-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
    			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
    			<span aria-hidden="true">×</span></button>
    			<h4 class="modal-title">세율 수정</h4>
    		</div>
			<div class="modal-body">
				<input type="number" id="tax-percent" class="form-control input-sm" value="<?=$taxPercent?>">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-flat btn-default" data-dismiss="modal">닫기</button>
				<button type="button" id="btn-update-tax-percent" class="btn btn-flat btn-primary">수정</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade add-boss-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
    			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
    			<span aria-hidden="true">×</span></button>
    			<h4 class="modal-title">보스 추가</h4>
    		</div>
			<div class="modal-body">
				<input type="text" id="boss-name" class="form-control input-sm" placeholder="보스명">
				<br>
				<input type="number" id="gen-time" class="form-control input-sm" placeholder="젠 시간">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-flat btn-default" data-dismiss="modal">닫기</button>
				<button type="button" id="btn-add-boss" class="btn btn-flat btn-primary">추가</button>
			</div>
		</div>
	</div>
</div>
					
<script>
$(".mouse-over-out").mouseover(function() {
	$(this).find("i").css("display", "");
}).mouseout(function() {
	$(this).find("i").css("display", "none");
});

$(".dateTimeMask").mask('0000-00-00 00:00', {
	placeholder: "0000-00-00 00:00"
});

$("#btn-add-memo").on("click", function() {
	var content = $("#memo-content").val();
	
	$.ajax({
		type: "POST",
		data: {"content": content},
		url: "/boss/addBossMemo_ajax",
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
})

$("#btn-add-boss").on("click", function() {
	var bossName = $("#boss-name").val();
	var genTime = $("#gen-time").val();
	
	$.ajax({
		type: "POST",
		data: {"bossName": bossName, "genTime": genTime},
		url: "/boss/addBoss_ajax",
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

$("#btn-update-tax-percent").on("click", function() {
	var taxPercent = $("#tax-percent").val();

	if (confirm("세율을 수정하시겠습니까?")) {
		$.ajax({
			type: "POST",
			data: {"taxPercent": taxPercent},
			url: "/boss/updateTaxPercent_ajax",
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
})

$("#btn-refresh").on("click", function() {
	getBossList();
});

$(".count-down-time").each(function(i) {
	var targetTime = $(this).data("time");
	$(this).countdown(targetTime, {elapse: true}).on('update.countdown', function(e) {
		if (e.elapsed) {
			$(this).html("+ " + e.strftime('%H:%M:%S'));
			$(this).parent().css("background", "#f9e6e6");
		} else {
			$(this).html("- " + e.strftime('%H:%M:%S'));
		}
	});
});

$(".btn-update-direct-time").on("click", function() {
	var id = $(this).data("id");
	var updateTime = $(".direct-time-" + id).val();

	var data = {
		"id": id,
		"updateTime": updateTime,
	};

	if (confirm("잡은 시간을 수정하시겠습니까?")) {
    	$.ajax({
    		type: "POST",
    		data: data,
    		url: "/boss/updateDirectDateTime_ajax",
    		dataType: "json",
    		success: function(result) {
    			if (result.status == 200) {
    				getBossList();
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


$(".btn-update-kill-time").on("click", function() {
	var id = $(this).data("id");
	var data = {
		"id": id,
	};

	if (confirm("킬 하시겠습니까?")) {
    	$.ajax({
    		type: "POST",
    		data: data,
    		url: "/boss/updateKillDateTime_ajax",
    		dataType: "json",
    		success: function(result) {
    			if (result.status == 200) {
    				getBossList();
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

$(".btn-update-kill-pass").on("click", function() {
	var id = $(this).data("id");
	var data = {
		"id": id,
	};

	if (confirm("멍 처리하시겠습니까?")) {
    	$.ajax({
    		type: "POST",
    		data: data,
    		url: "/boss/updateKillPass_ajax",
    		dataType: "json",
    		success: function(result) {
    			if (result.status == 200) {
    				getBossList();
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

$(".btn-update-display").on("click", function() {
	var id = $(this).data("id");
	var data = {
		"id": id,
	};

	if (confirm("삭제 하시겠습니까?")) {
    	$.ajax({
    		type: "POST",
    		data: data,
    		url: "/boss/updateIsDisplay_ajax",
    		dataType: "json",
    		success: function(result) {
    			if (result.status == 200) {
        			alert("삭제 완료");
    				getBossList();
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

function cal(){
	var rate = Number($('#rate').val());
	var reg = Number($('#reg').val());
	var price = Number($('#price').val());
	
	var temp1 = Math.floor(reg*(100-rate)/100)	
	var temp2 = temp1-price;
	var result = Math.ceil((temp2/(100-rate))*100);
	
	$('#temp1').val(temp1);
	$('#temp2').val(temp2);
	$('#result').val(result);
}
</script>
