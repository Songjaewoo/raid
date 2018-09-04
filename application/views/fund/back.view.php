<div class="content-wrapper">
	<section class="content">
		<div class="row">
			<div class="col-md-8">
				<div class="box box-danger">
					<div class="box-header with-border">
    					<h3 class="box-title">상납금 관리</h3>
    				</div>
    				
					<div class="box-body table-responsive no-padding">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>혈맹</th>
									<th>등급</th>
									<th>클래스</th>
									<th>캐릭터명</th>
									<th>상납금</th>
									<th>-</th>
								</tr>
							</thead>
							<tbody>
								<?php if ($paymentList != null) { ?>
    								<?php foreach ($paymentList as $key => $value) { ?>
    								<tr>
    									<td><?=$value['groupName']?></td>
    									<td><?=$value['levelName']?></td>
    									<td><?=$value['className']?></td>
    									<td><?=$value['nickname']?></td>
    									<td><?=number_format($value['pay'])?></td>
    									<td>
    										<?php if (number_format($value['pay']) != 0) { ?>
    											<button type="button" data-id="<?=$value['id']?>" class="btn-update-pay-modal btn btn-sm btn-danger btn-flat">상납</button>
    										<?php } ?>	
    									</td>
    								</tr>
    								<?php } ?>
								<?php } else { ?>
									<tr align="center">
										<td colspan="6">
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

<div id="update-pay-modal" class="modal fade" tabindex="-1" role="dialog">
	<!-- INSERT MODAL AJAX -->
</div>

<script>
$(".btn-update-pay-modal").on("click", function() {
	var payId = $(this).data("id");
	$.ajax({
		type: "GET",
		data: {"payId": payId},
		url: "/fund/updatePayModal_ajax",
		success: function(result) {
			$("#update-pay-modal").html(result);
			$('#update-pay-modal').modal('show');
		},
		error: function(xhr, status, error) {
			console.log(xhr);
			console.log(status);
			console.log(error);
		}
	});
});

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

$(".btn-del-fund-use").on("click", function() {
	var id = $(this).data("id");

	if (confirm("삭제 하시겠습니까")) {
    	$.ajax({
    		type: "POST",
    		data: {"id": id},
    		url: "/fund/deleteFundUse_ajax",
    		dataType: "json",
    		success: function(result) {
    			if (result.status == 200) {
    				alert("삭제 완료");
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

$("#btn-add-fund-use").on("click", function() {
	var useMoney = $("#useMoney").val();
	var memo = $("#memo").val();

	if (confirm("추가 하시겠습니까?")) {
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
	}
})
</script>