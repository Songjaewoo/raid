<div class="content-wrapper">
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-danger">
					<div class="box-header with-border">
    					<h3 class="box-title">미정산 리스트</h3>
    				</div>
					
					<div class="box-header">
    					<strong class="text-light-blue">
    						[<?=$memberDetail['groupName']?>] <?=$memberDetail['nickname']?>
    					</strong>
    				</div>
    				
					<div class="box-body table-responsive no-padding">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th style="width: 55px;">
										<label>
<!-- 											<input type="checkbox" id="btn-all-check" checked> -->
										</label>
									</th>
									<th>날짜</th>
									<th>보스</th>
									<th>비고</th>
									<th>미정산금</th>
									<th>작성자</th>
									<th>-</th>
								</tr>
							</thead>
							<tbody>
								<?php if ($dividendDetailList != null) { ?>
									<?php $totalDividend = 0;?>
    								<?php foreach ($dividendDetailList as $key => $value) { ?>
        								<tr>
        									<td>
        										<label>
        											<input type="checkbox" class="btn-check" data-id="<?=$value['id']?>" checked>
        										</label>
        									</td>
        									<td><?=date("Y-m-d", strtotime($value['killDateTime']))?></td>
        									<td>
        										<a href="/bossBoard/detail?id=<?=$value['bossBoardId']?>">
        											<?=$value['bossName']?>
        										</a>
        									</td>
        									<td><?=$value['etc']?></td>
        									<td><?=number_format($value['dividend'])?></td>
        									<td><?=$value['writerNickName']?></td>
        									<td>
        										<button type="button" data-id="<?=$value['id']?>" class="btn-dividend-finish btn btn-sm btn-warning btn-flat">
        											정산
        										</button>
        									</td>
        								</tr>
        								<?php $totalDividend += $value['dividend'];?>
    								<?php } ?>
    								<tr>
    									<td colspan="4">합계</td>
        								<td colspan="3"><?=number_format($totalDividend)?></td>
    								</tr>
								<?php } else { ?>
									<tr align="center">
										<td colspan="7">리스트가 없습니다.</td>							
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
					
					<div class="box-footer" style="text-align: center;">
						<button type="button" id="btn-check-dividend-finish" class="btn btn-primary btn-flat" style="width: 100px;">정산</button>
						
						<a href="/dividend">
							<button type="button" class="btn btn-default btn-flat" style="width: 100px;">목록</button>
						</a>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

<script>
$(document).ready(function(){ 
    $("#btn-all-check").on("ifChecked", function(d) {
    	$(".btn-check").iCheck("checked");
    });
    
    $("#btn-all-check").on("ifUnChecked", function() {
    	$(".btn-check").iCheck("unchecked");
    });
	
});


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

$("#btn-check-dividend-finish").on("click", function() {
	if (confirm("정산 하시겠습니까?")) {
		var checkIdArray = [];
		$(".btn-check:checked").each(function(i, v) {
			var id = $(this).data("id");
			checkIdArray.push(id);
		});

		$.ajax({
        	type : "POST",
        	data : {"checkIdArray": checkIdArray},
        	dataType : "json",
        	url : "/dividend/updateCheckDividendFinish_ajax",
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

$("#btn-all-check").iCheck({
	checkboxClass: 'icheckbox_flat-red',
})

$(".btn-check").iCheck({
	checkboxClass: 'icheckbox_flat-red',
})
</script>
