<div class="content-wrapper">
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box box-danger">
					<div class="box-header with-border">
    					<h3 class="box-title">아이템 리스트</h3>
    				</div>
    				
					<div class="box-body table-responsive no-padding">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>종류</th>
									<th>아이템명</th>
									<th>가격</th>
									<th>-</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($itemList as $key => $value) { ?>
								<tr style="color: <?=$value['levelColor']?>">
									<td><?=$value['levelName']?></td>
									<td><?=$value['name']?></td>
									<td><?=number_format($value['price'])?></td>
									<td>
										<button type="button" id="btn-update-item" data-id="<?=$value['id']?>" class="btn btn-sm btn-primary btn-flat">
                        					수정
                        				</button>
									</td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
					</div>
			</div>
		</div>
	</section>
</div>
