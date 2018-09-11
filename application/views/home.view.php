<style>
.chart-legend li {
    display: block;
}

.chart-legend li span {
    display: inline-block;
    width: 12px;
    height: 12px;
    margin-right: 5px;
}
</style>

<div class="content-wrapper">
	<section class="content">
		<div class="row">
			<?php if (LOGIN_LEVEL >= 4) { ?>
			<div class="col-lg-3 col-xs-6">
				<div class="small-box bg-aqua">
					<div class="inner">
						<h3><?=number_format($allPayment)?></h3>

						<p>미상납금</p>
					</div>
    				<div class="icon">
    					<i class="ion ion-calculator"></i>
    				</div>
					<a href="/fund/back" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				</div>
			</div>
			<?php } ?>
			
			<div class="col-lg-3 col-xs-6">
				<div class="small-box bg-green">
					<div class="inner">
						<h3><?=number_format($expectGroupFund)?></h3>

						<p>예상 혈비</p>
					</div>
    				<div class="icon">
    					<i class="ion ion-calculator"></i>
    				</div>
					<a href="fund/useList" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				</div>
			</div>
			
			<?php if (LOGIN_LEVEL >= 4) { ?>
			<div class="col-lg-3 col-xs-6">
				<div class="small-box bg-yellow">
					<div class="inner">
						<h3>
							<?=number_format($allNotFinishDividend)?> 
							<small><?=number_format($countNotFinishDividendMember)?>명</small>
						</h3>
						
						<p>정산해줘야 할 금액</p>
					</div>
    				<div class="icon">
    					<i class="ion ion-calculator"></i>
    				</div>
					<a href="/dividend" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				</div>
			</div>
			<?php } ?>
		</div>
		
		<div class="row">
			<div class="col-md-12">
				<div class="box box-danger">
					<div class="box-header with-border">
    					<h3 class="box-title">
	    					공지사항
	    					<a href="/board?category=1">
	    						<small>더보기 <i class="fa fa-arrow-circle-right"></i></small>
	    					</a>
    					</h3>
    				</div>
    				            		
					<div class="box-body table-responsive no-padding">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th style="width: 5%">번호</th>
									<th style="width: 60%">제목</th>
									<th style="width: 15%">작성자</th>
									<th style="width: 13%">작성일</th>
									<th style="width: 7%">조회수</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($noticeBoardList as $key => $value) { ?>
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
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12">
				<div class="box box-danger">
					<div class="box-header with-border">
    					<h3 class="box-title">
	    					자유게시판 
	    					<a href="/board?category=2">
	    						<small>더보기 <i class="fa fa-arrow-circle-right"></i></small>
	    					</a>
    					</h3>
    				</div>
    				            		
					<div class="box-body table-responsive no-padding">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th style="width: 5%">번호</th>
									<th style="width: 60%">제목</th>
									<th style="width: 15%">작성자</th>
									<th style="width: 13%">작성일</th>
									<th style="width: 7%">조회수</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($freeBoardList as $key => $value) { ?>
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
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-3">
				<div class="box box-danger">
					<div class="box-header with-border">
    					<h3 class="box-title">
	    					혈맹 클래스 통계 
    					</h3>
    				</div>
    				            		
					<div class="box-body">
						<div class="row">
							<div class="col-md-6">
								<div class="chart-responsive">
									<canvas id="pieChart"></canvas>
								</div>
							</div>
							<div class="col-md-6 chart-legend"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

<input type="hidden" id="classPieChartInfo" value="<?=$classPieChartInfo?>">

<script>
var classPieChartInfo = $("#classPieChartInfo").val();
var color = ["#f56954", "#00a65a", "#f39c12", "#00c0ef", "#3c8dbc", "#d2d6de", "#dd4b39"];
var pieDataArray = [];
$.each(JSON.parse(classPieChartInfo), function(key, value) {
	var pieDataObj = {};
	pieDataObj.label = value.className;
	pieDataObj.value = value.classNameCount;
	pieDataObj.color = color[key];
	pieDataObj.highlight = color[key];
	
	pieDataArray.push(pieDataObj);
});

var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
var pieChart       = new Chart(pieChartCanvas);
var pieData = pieDataArray;
var pieOptions     = {
	segmentShowStroke    : true,
	segmentStrokeColor   : '#fff',
	segmentStrokeWidth   : 1,
	responsive           : true,
	maintainAspectRatio  : false,
	tooltipTemplate      : '<%=value %> <%=label%>'
};
pieChart = pieChart.Doughnut(pieData, pieOptions);
$(".chart-legend").html(pieChart.generateLegend());
</script>
