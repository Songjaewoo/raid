<div class="content-wrapper">
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-danger">
					<div class="box-header with-border">
    					<h3 class="box-title">
    						<a href="/dividend/my">나의 미정산금 리스트</a>
    						<small>(검색결과: <?=number_format($countBossBoardList)?> 건)</small>
    					</h3>
    				</div>
            
					<div class="box-body table-responsive no-padding">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>날짜</th>
									<th>보스이름</th>
									<th>드랍아이템</th>
									<th>참여인원</th>
									<th>비고</th>
									<th>미정산금</th>
									<th>작성자</th>
									<th>-</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($bossBoardList as $key => $value) { ?>
								<tr>
									<td><?=date("Y-m-d", strtotime($value['killDateTime']))?></td>
									<td><?=$value['bossName']?></td>
									<td>
										<?php foreach ($value['itemList'] as $key1 => $value1) { ?>
											<span style="color: <?=$value1['itemLevelColor']?>">
												<?=$value1['itemName']?><br>
											</span>
										<?php } ?>
									</td>
									<td><?=$value['participantCount']?></td>
									<td><?=$value['etc']?></td>
									<td><?=number_format($value['dividend'])?></td>
									<td><?=$value['writerNickname']?></td>
									<td>
										<a href="/bossBoard/detail?id=<?=$value['id']?>" class="btn btn-sm btn-primary btn-flat">
											상세보기
										</a>
									</td>
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
										<a href="/dividend/my?<?=$pagination['pageDelQueryString']?>&pageNum=<?=$pagination['prevPage']?>">«</a>
									</li>
								<?php } ?>
								
								<?php for ($i = $pagination['startPage']; $i <= $pagination['endPage']; $i++) { ?>
									<?php if ($i == $pagination['curPage']) { ?>
										<li data-lp="1" class="active">
											<a href="javascript:void(0);"><?=$i?></a>
										</li>
									<?php } else { ?>
										<li data-lp="<?=$i?>">
											<a href="/dividend/my?<?=$pagination['pageDelQueryString']?>&pageNum=<?=$i?>"><?=$i?></a>
										</li>
									<?php } ?>
								<?php } ?>
								
								<?php if ($pagination['nextPage'] > 0) { ?>
									<li data-lp="<?=$pagination['nextPage']?>" class="next">
										<a href="/dividend/my?<?=$pagination['pageDelQueryString']?>&pageNum=<?=$pagination['nextPage']?>">»</a>
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
