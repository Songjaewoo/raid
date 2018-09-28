<div class="content-wrapper">
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box box-danger">
					<div class="box-header with-border">
    					<h3 class="box-title">아이템 리스트</h3>
    					
    					<?php if (LOGIN_LEVEL >= 3) { ?>
    					<button type="button" id="btn-sort-item" class="btn btn-sm btn-primary btn-flat pull-right">
    						<i class="fa fa-ellipsis-v"></i> <i class="fa fa-ellipsis-v"></i> 순서변경 적용</button>
    					<button type="button" class="btn btn-sm btn-primary btn-flat pull-right" data-toggle="modal" data-target=".add-item-modal" style="margin-right: 12px;">추가</button>
    					<?php } ?>
    				</div>
    				
					<div class="box-body table-responsive no-padding">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>-</th>
									<th>종류</th>
									<th>아이템명</th>
									<th>가격</th>
									<th>-</th>
								</tr>
							</thead>
							<tbody <?php if (LOGIN_LEVEL >= 3) { echo 'class="todo-list"';}?>>
								<?php foreach ($itemList as $key => $value) { ?>
								<tr style="color: <?=$value['levelColor']?>" data-id="<?=$value['id']?>">
									<td>
										<span class="handle">
											<i class="fa fa-ellipsis-v"></i>
											<i class="fa fa-ellipsis-v"></i>
										</span>
									</td>
									<td><?=$value['levelName']?></td>
									<td><?=$value['name']?></td>
									<td><?=number_format($value['price'])?></td>
									<td>
										<?php if (LOGIN_LEVEL >= 3) { ?>
										<button type="button" data-id="<?=$value['id']?>" class="btn-update-item-modal btn btn-sm btn-primary btn-flat">
                        					수정
                        				</button>
                        				
                        				<button type="button" data-id="<?=$value['id']?>" class="btn-remove-item btn btn-sm btn-danger btn-flat">
                        					삭제
                        				</button>
                        				<?php } else { ?>
                        				-
                        				<?php } ?>
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

<div id="update-item-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	<!-- INSERT AJAX -->
</div>

<div class="modal fade add-item-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
    			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
    			<span aria-hidden="true">×</span></button>
    			<h4 class="modal-title">아이템 추가</h4>
    		</div>
			<div class="modal-body">
				<input type="text" id="item-name" class="form-control input-sm" placeholder="아이템명">
				<br>
				<input type="number" id="item-price" class="form-control input-sm" placeholder="아이템 가격">
				<br>
				<select id="item-level" class="form-control input-sm">
					<option value="1">기타</option>
					<option value="2">희귀</option>
					<option value="3">영웅</option>
					<option value="4">전설</option>
				</select>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-flat btn-default" data-dismiss="modal">닫기</button>
				<button type="button" id="btn-add-item" class="btn btn-flat btn-primary">추가</button>
			</div>
		</div>
	</div>
</div>

<script>
$('.todo-list').sortable({
	placeholder         : 'sort-highlight',
	handle              : '.handle',
	forcePlaceholderSize: true,
	zIndex              : 999999
});

$("#btn-sort-item").on("click", function() {
	var idArray = [];
	var sortArray = [];
	$(".todo-list tr").each(function(i, v) {
		var id = $(this).data("id");
		idArray.push(id);
		sortArray.push(i);
	})

	$.ajax({
		type: "POST",
		data: {"idArray": idArray, "sortArray": sortArray},
		url: "/item/updateItemSort_ajax",
		dataType: "json",
		success: function(result) {
			if (result.status == 200) {
				alert("순서 적용 완료");
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
});

$("#btn-add-item").on("click", function() {
	var itemName = $("#item-name").val();
	var itemPrice = $("#item-price").val();
	var itemLevel = $("#item-level option:selected").val();
	
	$.ajax({
		type: "POST",
		data: {"itemName": itemName, "itemPrice": itemPrice, "itemLevel": itemLevel},
		url: "/item/addItem_ajax",
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

$(".btn-remove-item").on("click", function() {
	var itemId = $(this).data("id");

	if (confirm("삭제 하시겠습니까?")) {
    	$.ajax({
    		type: "POST",
    		data: {"itemId": itemId},
    		dataType: "json",
    		url: "/item/updateIsUse_ajax",
    		success: function(result) {
    			if (result.status == 200) {
    				alert("삭제 완료");
    			} else {
    				alert("삭제 오류");
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

$(".btn-update-item-modal").on("click", function() {
	var itemId = $(this).data("id");
	$.ajax({
		type: "GET",
		data: {"itemId": itemId},
		url: "/item/updateItemModal_ajax",
		success: function(result) {
			$("#update-item-modal").html(result);
			$('#update-item-modal').modal('show');
		},
		error: function(xhr, status, error) {
			console.log(xhr);
			console.log(status);
			console.log(error);
		}
	});
});
</script>
