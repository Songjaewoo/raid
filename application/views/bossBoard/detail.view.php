<div class="content-wrapper">
	<section class="content">
		<div class="row">
			<div class="col-md-6">
				<div class="box">
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
    										<td><?=$value['itemName']?></td>
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
								<?php foreach ($detailBossBoard['attachFile'] as $key => $value) { ?>
    								<div class="col-md-12">
            							<img src="<?=$value['fileUrl']?>" style="width: 100%;">
    								</div>
								<?php } ?>
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
				<div class="box">
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
												완료
												<?php } else { ?>
												미완료
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
				<button type="button" id="btn-write-boss-board" class="btn btn-primary btn-flat" style="width: 100px;">
					삭제
				</button>
				
				<a href="/bossBoard">
					<button type="button" class="btn btn-danger btn-flat" style="width: 100px;">
						목록
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
		var dividend = $(this).data("dividend");

		participantObj = {};
		participantObj.memberId = memberId;
		participantObj.nickname = nickname;
		participantObj.dividend = dividend;

		participantList.push(participantObj);
	});

	var bossItemList = [];
	var bossItemObj;
	$(".boss-item").each(function(i, v) {
		var memberId = $(this).data("id");
		var nickname = $(this).data("nickname");
		var itemId = $(this).data("itemid");
		var price = $(this).data("price");

		bossItemObj = {};
		bossItemObj.memberId = memberId;
		bossItemObj.nickname = nickname;
		bossItemObj.itemId = itemId;
		bossItemObj.price = price;

		bossItemList.push(bossItemObj);
	});
	
	formData.append("killDateTime", killDateTime);
	formData.append("bossId", bossId);
	formData.append("etc", etc);
	formData.append("attachFile1", attachFile1);
	formData.append("attachFile2", attachFile2);
	formData.append("participantList", JSON.stringify(participantList));
	formData.append("bossItemList", JSON.stringify(bossItemList));

	if (killDateTime == "") {
		alert("잡은 날짜를 입력해 주세요.");
		return;
	}
	
	$.ajax({
		type : "POST",
		data : formData,
		dataType : "json",
		processData: false,
		contentType: false,
		url : "/bossBoard/write_submit_ajax",
		success : function(result) {
			console.log(result);
			if (result.status == 200) {
				alert("등록 하였습니다.");
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
});

$('#is-check-buyer').change(function() {
	if ($(this).is(":checked")) {
		$("#select-buyer-group").attr("disabled", false);
		$("#select-buyer-group-member").attr("disabled", false);
	} else {
		$("#select-buyer-group").attr("disabled", true);
		$("#select-buyer-group-member").attr("disabled", true);
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

$("#select-group").change(function() {
	var groupId = $(this).val();
	
	$.ajax({
		type: "GET",
		data: {"groupId": groupId},
		url: "/bossBoard/groupMemberList_ajax",
		dataType: "json",
		success: function(result) {
			var html = "";
			$(result).each(function(i, v) {
				var id = v.id;
				var nickname = v.nickname;
				var groupName = v.groupName;
				html += "<option value='" + id + "' data-groupname='" + groupName + "'>" + nickname + "</option>";
			});

			$("#select-group-member").html(html);
		},
		error: function(xhr, status, error) {
			console.log(xhr);
			console.log(status);
			console.log(error);
		}
	});
})

$("#select-buyer-group").change(function() {
	var groupId = $(this).val();
	
	$.ajax({
		type: "GET",
		data: {"groupId": groupId},
		url: "/bossBoard/groupMemberList_ajax",
		dataType: "json",
		success: function(result) {
			var html = "";
			$(result).each(function(i, v) {
				var id = v.id;
				var nickname = v.nickname;
				var groupName = v.groupName;
				html += "<option value='" + id + "' data-groupname='" + groupName + "'>" + nickname + "</option>";
			});

			$("#select-buyer-group-member").html(html);
		},
		error: function(xhr, status, error) {
			console.log(xhr);
			console.log(status);
			console.log(error);
		}
	});
})

$("#btn-add-member").on("click", function() {
	var html = "";
	$("#select-group-member :selected").each(function(i, v){ 
		var memberId = $(this).val();
		var nickname = $(this).text();
		var groupName = $(this).data("groupname");
		var dividend = 1;
		
		html += "<tr class='participant-member' data-id='" + memberId + "' data-nickname='" + nickname + "' data-dividend='" + dividend + "'>";
		html += "	<td>" + groupName + "</td>";
		html += "	<td>" + nickname + "</td>";
		html += "	<td>" + dividend + "</td>";
		html += "	<td><button type='button' class='btn-del-participant btn btn-danger btn-flat btn-xs'>삭제</button></td>";
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
	html += "	<td><button type='button' class='btn-del-boss-item btn btn-danger btn-flat btn-xs'>삭제</button></td>";
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