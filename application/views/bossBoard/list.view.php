<div class="content-wrapper">
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header with-border">
    					<h3 class="box-title">보스탐 참여 정보</h3>
    				</div>
    				
					<div class="box-header">
						<a href="/bossBoard/write">
							<button type="button" class="btn btn-sm btn-primary btn-flat pull-left">등록</button>
						</a>
						
						<!-- 
						<div class="box-tools">
							<div class="input-group input-group-sm" style="width: 200px;">
								<input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

								<div class="input-group-btn">
									<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
								</div>
							</div>
						</div>
						 -->
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
								</tr>
							</thead>
							<tbody>
								<?php foreach ($bossBoardList as $key => $value) { ?>
								<tr>
									<td><?=date("Y-m-d", strtotime($value['killDateTime']))?></td>
									<td><?=$value['bossName']?></td>
									<td>
										<?php foreach ($value['itemList'] as $key1 => $value1) { ?>
											<?=$value1['itemName']?><br>
										<?php } ?>
									</td>
									<td><?=$value['participantCount']?></td>
									<td><?=$value['etc']?></td>
									<td><?=$value['dividend']?></td>
									<td><?=$value['writerNickname']?></td>
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
