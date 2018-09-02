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
								<input type="text" class="form-control pull-right" id="kill-date-time" value="<?=date("Y-m-d")?>">
							</div>
						</div>
						
						<div class="form-group">
							<label>보스</label>

                        	<select id="select-boss" class="form-control">
								<?php foreach ($bossList as $key => $value) { ?>
									<option value="<?=$value['id']?>"><?=$value['name']?></option>
								<?php } ?>
							</select>
						</div>
						
						<div class="form-group" style="margin-bottom: 0px;">
							<label>드랍 아이템 +입찰자 추가</label>
							
							<div class="row">
								<div class="col-md-8">
									<div class="form-group">
										<select id="select-item-list" class="form-control">
    										<?php foreach ($itemList as $key => $value) { ?>
    											<option value="<?=$value['id']?>" data-itemprice="<?=$value['price']?>"><?=$value['name']?></option>
    										<?php } ?>
    									</select>
									</div>
								</div>
								
								<div class="col-md-4">
									<div class="form-group">
										<input id="item-price" class="form-control" type="number" placeholder="가격" value="<?=$itemList[0]['price']?>">
									</div>
								</div>
							</div>
						</div>
						
						<div class="form-group" style="margin-bottom: 0px;">
							<div class="row">
								<div class="col-md-8">
									<div class="form-group">
    									<select id="select-buyer-group-member" class="form-control">
											<option value="0">입찰자 없음</option>
											<?php foreach ($groupMemberList as $key => $value) { ?>
												<option value="<?=$value['id']?>" data-groupname="<?=$value['groupName']?>"><?=$value['nickname']?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								
								<div class="col-md-4">
									<div class="form-group">
										<button type="button" id="btn-add-item" class="btn btn-block btn-default btn-flat">
											추가 <span class="fa fa-long-arrow-down"></span>
										</button>
									</div>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label>드랍 아이템 +입찰자</label>
							
							<table class="table table-bordered table-striped">
								<tbody id="boss-item-list">
									<tr>
										<th>드랍아이템</th>
										<th>가격</th>
										<th>입찰자</th>
										<th>-</th>
									</tr>
								</tbody>
							</table>
						</div>
						
						<div class="form-group">
							<label>사진</label>
							
							<div class="row">
								<div class="col-md-6">
									<label for="attach-file1" style="text-align: center;">
            							<img id="image-preview1" src="/asset/image/no-image-icon.png" style="width: 60%; height: auto; margin-bottom: 8px;">
        							</label>
        							<input type="file" id="attach-file1" />
								</div>
								
								<div class="col-md-6">
									<label for="attach-file2" style="text-align: center;">
            							<img id="image-preview2" src="/asset/image/no-image-icon.png" style="width: 60%; height: auto; margin-bottom: 8px;">
    								</label>
        							<input type="file" id="attach-file2" />
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label>비고</label>

							<textarea id="etc" class="form-control" rows="3"></textarea>
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-md-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-group">
							<label>참여인원 추가</label>

							<div class="row">
								<div class="col-md-8">
									<div class="form-group">
    									<select id="select-group-member" class="form-control" multiple="">
											<?php foreach ($groupMemberList as $key => $value) { ?>
											<option value="<?=$value['id']?>" data-groupname="<?=$value['groupName']?>"><?=$value['nickname']?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								
								<div class="col-md-4">
									<div class="form-group">
										<button type="button" id="btn-add-member" class="btn btn-block btn-default btn-flat">
											추가 <span class="fa fa-long-arrow-down"></span>
										</button>
									</div>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label>참여인원 <span id="count-participant">0</span>명</label>
							
							<table class="table table-bordered table-striped">
								<tbody id="participant-list">
									<tr>
										<th>혈맹</th>
										<th>혈맹원</th>
										<th>-</th>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12" style="text-align: center;">
				<button type="button" id="btn-write-boss-board" class="btn btn-primary btn-flat" style="width: 100px;">
					등록
				</button>
				
				<a href="/bossBoard">
					<button type="button" class="btn btn-default btn-flat" style="width: 100px;">
						취소
					</button>
				</a>
			</div>
		</div>
	</section>
</div>

<script>
$("#btn-write-boss-board").on("click", function() {
	var formData = new FormData();

	var killDateTime = $("#kill-date-time").val();
	var bossId = $("#select-boss option:selected").val();
	var etc = $("#etc").val();

	var attachFile1 = $("#attach-file1")[0].files[0];
	var attachFile2 = $("#attach-file2")[0].files[0];
	
	var participantList = [];
	var participantObj;
	$(".participant-member").each(function(i, v) {
		var memberId = $(this).data("id");
		var nickname = $(this).data("nickname");

		participantObj = {};
		participantObj.memberId = memberId;
		participantObj.nickname = nickname;

		participantList.push(participantObj);
	});

	var bossItemList = [];
	var bossItemObj;
	var totalItemPrice = 0;
	$(".boss-item").each(function(i, v) {
		var memberId = $(this).data("id");
		var itemId = $(this).data("itemid");
		var price = $(this).data("price");

		bossItemObj = {};
		bossItemObj.memberId = memberId;
		bossItemObj.itemId = itemId;
		bossItemObj.price = price;

		bossItemList.push(bossItemObj);

		totalItemPrice += price;
	});

	formData.append("killDateTime", killDateTime);
	formData.append("bossId", bossId);
	formData.append("etc", etc);
	formData.append("attachFile1", attachFile1);
	formData.append("attachFile2", attachFile2);
	formData.append("participantList", JSON.stringify(participantList));
	formData.append("bossItemList", JSON.stringify(bossItemList));
	formData.append("totalItemPrice", totalItemPrice);
	formData.append("totalParticipantMember", $(".participant-member").length);
	
	if (killDateTime == "") {
		alert("날짜를 입력해 주세요.");
		return;
	}

	if (bossItemList.length == 0) {
		alert("아이템을 추가해 주세요.");
		return;
	}

	if (confirm("등록 하시겠습니까?")) {
    	$.ajax({
    		type : "POST",
    		data : formData,
    		dataType : "json",
    		processData: false,
    		contentType: false,
    		url : "/bossBoard/write_submit_ajax",
    		success : function(result) {
    			if (result.status == 200) {
        			var resultId = result.data;
    				alert("등록 하였습니다.");
    				location.href = "/bossBoard/detail?id=" + resultId;
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
});

$("#attach-file1").change(function() {
	readURL1(this);
});

$("#attach-file2").change(function() {
	readURL2(this);
});

$("#select-boss").select2();
$("#select-item-list").select2();
$("#select-buyer-group-member").select2();

$("#select-group-member").select2({
	placeholder: "참여인원을 선택해주세요.",
});

$("#kill-date-time").datepicker({
	autoclose: false,
	format: "yyyy-mm-dd",
	todayBtn: "linked"
})

$("#select-item-list").change(function() {
	var itemPrice = $(this).find(":selected").data("itemprice");
	$("#item-price").val(itemPrice);
})

$("#btn-add-member").on("click", function() {
	var html = "";
	$("#select-group-member :selected").each(function(i, v){ 
		var memberId = $(this).val();
		var nickname = $(this).text();
		var groupName = $(this).data("groupname");
		
		html += "<tr class='participant-member' data-id='" + memberId + "' data-nickname='" + nickname + "'>";
		html += "	<td>" + groupName + "</td>";
		html += "	<td>" + nickname + "</td>";
		html += "	<td><button type='button' class='btn-del-participant btn btn-danger btn-flat btn-sm'>삭제</button></td>";
		html += "</tr>";
	});

	$("#participant-list").append(html);
	$("#select-group-member").val(null).trigger('change');

	var participantCount = $(".participant-member").length;
	$("#count-participant").text(participantCount);
});

$("#btn-add-item").on("click", function() {
	var memberId = $("#select-buyer-group-member option:selected").val();
	var itemId = $("#select-item-list option:selected").val();
	var itemName = $("#select-item-list option:selected").text();
	var price = $("#item-price").val();
	var nickname = $("#select-buyer-group-member option:selected").text();
	var html = "";

	if (memberId == 0) {
		memberId = "";	
		nickname = "";
	}
	
	html += "<tr class='boss-item' data-id='" + memberId + "' data-nickname='" + nickname + "' data-itemid='" + itemId + "' data-price='" + price + "'>";
	html += "	<td>" + itemName + "</td>";
	html += "	<td>" + price + "</td>";
	html += "	<td>" + nickname + "</td>";
	html += "	<td><button type='button' class='btn-del-boss-item btn btn-danger btn-flat btn-sm'>삭제</button></td>";
	html += "</tr>";

	$("#boss-item-list").append(html);
});

$(document).on("click", ".btn-del-boss-item", function() {
	$(this).closest("tr").remove();
});

$(document).on("click", ".btn-del-participant", function() {
	$(this).closest("tr").remove();
	
	var participantCount = $(".participant-member").length;
	$("#count-participant").text(participantCount);
});

function readURL1(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function(e) {
			$('#image-preview1').attr('src', e.target.result);
		}
		reader.readAsDataURL(input.files[0]);
	}
}

function readURL2(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function(e) {
			$('#image-preview2').attr('src', e.target.result);
		}
		reader.readAsDataURL(input.files[0]);
	}
}
</script>