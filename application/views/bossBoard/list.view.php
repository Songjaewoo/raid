<div class="content-wrapper">
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-danger">
					<div class="box-header with-border">
    					<h3 class="box-title">보스탐 참여 정보</h3>
    				</div>
    				
					<div class="box-header">
						<a href="/bossBoard/write">
							<button type="button" class="btn btn-primary btn-flat pull-left" style="width: 100px;">등록</button>
						</a>
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
					
					<div class="box-footer">
					
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
