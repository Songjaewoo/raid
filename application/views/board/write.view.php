<div class="content-wrapper">
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-group">
							<label>제목</label>

							<input type="text" name="title" id="title" class="form-control pull-right">
						</div>
						
						<div class="form-group">
							<label></label>

							<textarea name="editor-text" id="editor-text"></textarea>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12" style="text-align: center;">
				<button type="button" class="btn btn-primary btn-flat" style="width: 100px;">
					등록
				</button>
				
				<a href="/board/list">
					<button type="button" class="btn btn-default btn-flat" style="width: 100px;">
						취소
					</button>
				</a>
			</div>
		</div>
	</section>
</div>

<script>
CKEDITOR.replace("editor-text");
</script>