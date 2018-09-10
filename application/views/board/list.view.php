<div class="content-wrapper">
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-danger">
					<div class="box-header with-border">
    					<h3 class="box-title">
    						<?php if ($category == 1) { ?>
    							공지사항
    						<?php } else if ($category == 2) { ?>
    							자유 게시판
    						<?php } ?>
    					</h3>
    				</div>
    				
    				<?php if (($category == 1 && LOGIN_LEVEL >= 3) || $category == 2) { ?>
					<div class="box-header">
						<a href="/board/write?category=<?=$category?>">
							<button type="button" class="btn btn-primary btn-flat pull-left" style="width: 100px;">등록</button>
						</a>
					</div>
					<?php } ?>
            		
					<div class="box-body table-responsive no-padding">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>번호</th>
									<th>제목</th>
									<th>작성자</th>
									<th>작성일</th>
									<th>조회수</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($boardList as $key => $value) { ?>
								<tr>
									<td><?=$value['id']?></td>
									<td>
										<a href="/board/detail?boardId=<?=$value['id']?>">
											<?=$value['title']?>
										</a>
									</td>
									<td>[<?=$value['groupName']?>] <?=$value['nickname']?></td>
									<td><?=date("Y-m-d", strtotime($value['createdDateTime']))?></td>
									<td><?=$value['count']?></td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
					
					<div class="box-footer clearfix text-center">
						<ul class="pagination pagination-sm no-margin" id="pagination">
							<ul class="pagination bootpag">
								<?php if ($pagination['prevPage'] > 0) { ?>
									<li data-lp="<?=$pagination['prevPage']?>" class="prev">
										<a href="/board?<?=$pagination['pageDelQueryString']?>&pageNum=<?=$pagination['prevPage']?>">«</a>
									</li>
								<?php } ?>
								
								<?php for ($i = $pagination['startPage']; $i <= $pagination['endPage']; $i++) { ?>
									<?php if ($i == $pagination['curPage']) { ?>
										<li data-lp="1" class="active">
											<a href="javascript:void(0);"><?=$i?></a>
										</li>
									<?php } else { ?>
										<li data-lp="<?=$i?>">
											<a href="/board?<?=$pagination['pageDelQueryString']?>&pageNum=<?=$i?>"><?=$i?></a>
										</li>
									<?php } ?>
								<?php } ?>
								
								<?php if ($pagination['nextPage'] > 0) { ?>
									<li data-lp="<?=$pagination['nextPage']?>" class="next">
										<a href="/board?<?=$pagination['pageDelQueryString']?>&pageNum=<?=$pagination['nextPage']?>">»</a>
									</li>
								<?php } ?>
							</ul>
						</ul>
		            </div>
				</div>
			</div>
		</div>
	</section>
</div>
