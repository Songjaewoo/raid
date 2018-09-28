<style>
img {
	max-width: 100%;
}
</style>

<div class="content-wrapper">
	<section class="content">
		<form action="/board/write_submit" method="post" enctype="multipart/form-data">
			<div class="box box-danger">
				<div class="box-header with-border">
					<h3 class="box-title">
						<?php if ($category == 1) { ?>
							공지사항
						<?php } else if ($category == 2) { ?>
							자유게시판
						<?php } ?>
					</h3>
				</div>
				
				<div class="box-body">
					<table class="table table-bordered">
						<tr>
							<th style="width: 70%"><?=htmlspecialchars($boardDetail['title'])?></th>
						</tr>
						<tr>
							<td>
								<div style="float: right">
									<span style="margin-right: 8px;"><b style="margin-right: 4px;">작성자</b> [<?=$boardDetail['groupName']?>] <?=$boardDetail['nickname']?></span>
									<span style="margin-right: 8px;"><b style="margin-right: 4px;">작성일</b> <?=$boardDetail['createdDateTime']?></span>
									<span style="margin-right: 8px;"><b style="margin-right: 4px;">조회</b> <?=$boardDetail['count']?></span>
								</div>
							</td>
						</tr>
						<tr>
							<td style="padding: 32px 8px;"><?=$boardDetail['content']?></td>
						</tr>
						<tr>
							<th>댓글 [<?=COUNT($commentList)?>]</th>
						</tr>
						<tr>
							<td>
								<div class="input-group">
									<textarea id="comment" class="form-control"></textarea>

									<div class="input-group-btn">
										<button type="button" id="btn-add-comment" data-id="<?=$boardDetail['id']?>" class="btn btn-success" style="height: 54px;"><i class="fa fa-plus"></i></button>
									</div>
								</div>
				
							</td>
						</tr>
						<tr>
							<td>
								<div class="chat" id="chat-box">
									<?php foreach ($commentList as $key => $value) { ?>
									<div class="item">
										<img src="/asset/dist/img/avatar.png" alt="user image" class="online">
					
										<p class="message">
											<a href="javascript:void(0);" class="name">
												<small class="text-muted pull-right"><i class="fa fa-clock-o"></i> <?=$value['createdDateTime']?></small>
												<?php if ($value['writerId'] == LOGIN_ID) { ?>
													<small data-id="<?=$value['id']?>" class="btn-del-comment text-muted pull-right" style="margin-right: 8px;"><i class="fa fa-trash-o"></i> 삭제</small>
												<?php } ?>
												
												[<?=$value['groupName']?>] <?=$value['nickname']?>
											</a>
											<?=nl2br(htmlspecialchars($value['content']))?>
										</p>
									</div>
									<?php } ?>
					            </div>
							</td>
						</tr>
					</table>
				</div>
		            
				<div class="box-footer">
					<div style="float: left;">
						<a href="/board?category=<?=$category?>">
							<button type="button" class="btn btn-default btn-flat" style="width: 100px;">
								목록
							</button>
						</a>
					</div>
					
					<?php if ($boardDetail['writerId'] == LOGIN_ID) { ?>
					<div style="float: right;">
						<a href="/board/edit?boardId=<?=$boardDetail['id']?>">
							<button type="button" class="btn btn-primary btn-flat" style="width: 100px;">
								수정
							</button>
						</a>
						
						<button type="button" id="btn-del-board" data-id="<?=$boardDetail['id']?>" class="btn btn-danger btn-flat" style="width: 100px;">
							삭제
						</button>
					</div>
					<?php } else if (LOGIN_LEVEL >= 4) { ?>
					<div style="float: right;">
						<button type="button" id="btn-del-board" data-id="<?=$boardDetail['id']?>" class="btn btn-danger btn-flat" style="width: 100px;">
							삭제
						</button>
					</div>
					<?php } ?>
				</div>
			</div>
		</form>
	</section>
</div>
<input type="hidden" id="category" value="<?=$category?>">

<script>
$("#btn-add-comment").on("click", function() {
	var boardId = $(this).data("id");
	var comment = $("#comment").val();

	if (confirm("댓글을 등록 하시겠습니까?")) {
	    $.ajax({
	    	type : "POST",
	    	data : {"boardId": boardId, "comment": comment},
	    	dataType : "json",
	    	url : "/board/writeComment_ajax",
	    	success : function(result) {
	    		if (result.status == 200) {
	    			alert("댓글을 등록하였습니다.");
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
});

$(".btn-del-comment").on("click", function() {
	var commentId = $(this).data("id");

	if (confirm("댓글을 삭제 하시겠습니까?")) {
	    $.ajax({
	    	type : "POST",
	    	data : {"commentId": commentId},
	    	dataType : "json",
	    	url : "/board/deleteComment_ajax",
	    	success : function(result) {
	    		if (result.status == 200) {
	    			alert("댓글을 삭제하였습니다.");
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
});

$("#btn-del-board").on("click", function() {
	if (confirm("삭제하시겠습니까?")) {
		var boardId = $(this).data("id");
		var category = $("#category").val();
		
        $.ajax({
        	type : "POST",
        	data : {"boardId": boardId},
        	dataType : "json",
        	url : "/board/delete_ajax",
        	success : function(result) {
        		if (result.status == 200) {
        			alert("삭제 하였습니다.");
        			location.href = "/board?category=" + category;
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