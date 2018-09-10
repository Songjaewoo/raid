<div class="content-wrapper">
	<section class="content">
		<form action="/board/edit_submit" method="post" enctype="multipart/form-data">
			<div class="box box-danger">
				<div class="box-header with-border">
					<h3 class="box-title">
						<?php if ($category == 1) { ?>
							공지사항 글 수정
						<?php } else if ($category == 2) { ?>
							자유게시판 글 수정
						<?php } ?>
					</h3>
				</div>
            
				<div class="box-body">
					<div class="form-group">
						<label>제목</label>

						<input type="text" name="title" id="title" class="form-control" value="<?=$boardDetail['title']?>">
					</div>
						
					<div class="form-group">
						<label></label>

						<textarea name="editorText" id="editorText"><?=$boardDetail['content']?></textarea>
					</div>
				</div>
				
				<div class="box-footer" style="text-align: center;">
					<button type="submit" class="btn btn-primary btn-flat" style="width: 100px;">
						수정
					</button>
					
					<a href="/board/detail?boardId=<?=$boardDetail['id']?>">
						<button type="button" class="btn btn-default btn-flat" style="width: 100px;">
							취소
						</button>
					</a>
				</div>
			</div>
			
			<input type="hidden" name="boardId" value="<?=$boardDetail['id']?>">
		</form>
	</section>
</div>

<script>
	CKEDITOR.replace("editorText", {
		customConfig: "/asset/bower_components/ckeditor/custom_config.js"
	});
</script>