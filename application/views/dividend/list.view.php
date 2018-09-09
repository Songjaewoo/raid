<div class="content-wrapper">
	<section class="content">
		<div class="row">
			<div class="col-md-6">
				<div class="box box-danger">
					<div class="box-header with-border">
    					<h3 class="box-title">정산 관리</h3>
    				</div>
    				
    				<form action="/dividend" method="get">
        				<div class="box-header">
        					<div class="input-group input-group" style="width: 250px;">
        						<input type="text" name="s" class="form-control" placeholder="캐릭터명" value="<?=$s?>">
        
        						<div class="input-group-btn">
        							<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
        						</div>
        					</div>
        				</div>
					</form>
            
					<div class="box-body table-responsive no-padding">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>혈맹</th>
									<th>등급</th>
									<th>클래스</th>
									<th>캐릭터명</th>
									<th>미정산금</th>
									<th>-</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($dividendList as $key => $value) { ?>
    								<tr>
    									<td><?=$value['groupName']?></td>
    									<td><?=$value['levelName']?></td>
    									<td><?=$value['className']?></td>
    									<td><?=$value['nickname']?></td>
    									<td><?=number_format($value['dividend'])?></td>
    									<td>
    										<a href="/dividend/detail?memberId=<?=$value['memberId']?>">
    											<button type="button" class="btn btn-primary btn-sm btn-flat">상세보기</button>
    										</a>
    									</td>
    								</tr>
									<?php $totalDividend += $value['dividend'];?>
								<?php } ?>
								<tr>
									<td colspan="4">합계</td>
    								<td colspan="2"><?=number_format($totalDividend)?></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
