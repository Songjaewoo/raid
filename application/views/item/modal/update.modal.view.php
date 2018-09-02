<div class="modal-dialog modal-sm" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">×</span></button>
			<h4 class="modal-title">아이템 정보 수정</h4>
		</div>
              
		<div class="modal-body">
			<div class="form-group has-feedback">
				<input type="text" id="item-name" class="form-control" placeholder="아이템명" value="<?=$itemDetail['name']?>"> 
			</div>
			
			<div class="form-group has-feedback">
				<select id="item-level" class="form-control">
					<option value="1" <?php if ($itemDetail['level'] == 1) echo "selected";?>>기타</option>
					<option value="2" <?php if ($itemDetail['level'] == 2) echo "selected";?>>희귀</option>
					<option value="3" <?php if ($itemDetail['level'] == 3) echo "selected";?>>영웅</option>
					<option value="4" <?php if ($itemDetail['level'] == 4) echo "selected";?>>전설</option>
				</select>
			</div>
			
			<div class="form-group has-feedback">
				<input type="number" id="item-price" class="form-control" placeholder="가격" value="<?=$itemDetail['price']?>"> 
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-flat btn-default" data-dismiss="modal">닫기</button>
			<button type="button" id="btn-update-item" class="btn btn-flat btn-primary">수정</button>
		</div>
	</div>
</div>

<input type="hidden" id="itemId" value="<?=$itemDetail['id']?>">

<script>
	$("#btn-update-item").on("click", function() {
		var itemId = $("#itemId").val();
		var itemName = $("#item-name").val();
		var itemLevel = $("#item-level option:selected").val();
		var itemPrice = $("#item-price").val();
		
		var data = {
			"itemId": itemId,
			"itemName": itemName,
			"itemLevel": itemLevel,
			"itemPrice": itemPrice,
		};

		if (confirm("아이템 정보를 수정하시겠습니까?")) {
    		$.ajax({
    			type: "POST",
    			data: data,
    			dataType: "json",
    			url: "/item/updateItem_ajax",
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