<div class="content-wrapper">
	<section class="content">
		<div class="row">
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
		</div>
	</section>
</div>
		
