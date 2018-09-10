<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">×</span></button>
			<h4 class="modal-title">혈비 상납</h4>
		</div>
              
		<div class="modal-body">
			<div class="row">
				<div class="col-md-6">
        			<div class="form-group has-feedback">
        				<label>혈맹</label>
        				<input type="text" class="form-control" value="<?=$payDetail['groupName']?>" readonly="readonly"> 
        			</div>
    			</div>
    			
    			<div class="col-md-6">
        			<div class="form-group has-feedback">
        				<label>등급</label>
        				<input type="text" class="form-control" value="<?=$payDetail['levelName']?>" readonly="readonly"> 
        			</div>
        		</div>
			</div>
			
			<div class="row">
				<div class="col-md-6">
        			<div class="form-group has-feedback">
        				<label>클래스</label>
        				<input type="text" class="form-control" value="<?=$payDetail['className']?>" readonly="readonly"> 
        			</div>
    			</div>
    			
    			<div class="col-md-6">
        			<div class="form-group has-feedback">
        				<label>캐릭터명</label>
        				<input type="text" id="nickname" class="form-control" value="<?=$payDetail['nickname']?>" readonly="readonly"> 
        			</div>
        		</div>
			</div>
			
			<div class="row">
				<div class="col-md-6">
        			<div class="form-group has-feedback">
        				<label>상납금</label>
        				<input type="text" id="payMoney" class="form-control" value="<?=$payDetail['pay']?>" readonly="readonly"> 
        			</div>
    			</div>
    			
    			<div class="col-md-6">
        			<div class="form-group has-feedback">
        				<label>차감</label>
        				
        				<div class="row">
        					<div class="col-xs-6">
            					<input type="text" id="useMoney" class="form-control" value="0"> 
            				</div>
            				<div class="col-xs-6">
            					<button type="button" id="allUse" class="btn btn-block btn-flat btn-warning">전부차감</button>
            				</div>
        				</div>
        			</div>
        		</div>
			</div>
			
			<div class="row">
				<div class="col-md-6">
        			<div class="form-group has-feedback">
        				<label>잔액</label>
        				<input type="text" id="remainPay" class="form-control" readonly="readonly" style="color: #d73925;"> 
        			</div>
    			</div>
			</div>
			
			<div class="row">
				<div class="col-md-12">
        			<div class="form-group has-feedback">
        				<label>메모</label>
        				<textarea id="memo" rows=3" class="form-control"></textarea>
        			</div>
    			</div>
    			
    			<div class="col-md-6">
        		</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-flat btn-default" data-dismiss="modal">닫기</button>
			<button type="button" id="btn-update-pay" class="btn btn-flat btn-primary">상납</button>
		</div>
	</div>
</div>

<input type="hidden" id="memberId" value="<?=$payDetail['memberId']?>">

<script>
$("#allUse").on("click", function() {
	$("#useMoney").val($("#payMoney").val());
	cal();
})

$("#useMoney").keyup(function(){
	cal();
});

function cal(){
	var payMoney = Number($("#payMoney").val());
	var useMoney = Number($("#useMoney").val()) * -1;
	
	$("#remainPay").val(payMoney+useMoney);
}

$("#btn-update-pay").on("click", function() {
	var memberId = $("#memberId").val();
	var useMoney = $("#useMoney").val();
	var nickname = $("#nickname").val();
	var memo = $("#memo").val();
	
	var data = {
		"useMoney": useMoney,
		"nickname": nickname,
		"memberId": memberId,
		"memo": memo,
	};

	if (confirm("상납하시겠습니까?")) {
		$.ajax({
			type: "POST",
			data: data,
			dataType: "json",
			url: "/fund/updatePay_ajax",
			success: function(result) {
				if (result.status == 200) {
					alert("상납 완료");
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