<div class="content-wrapper">
	<section class="content-header">
		<h1 id="serverTime" style="text-align: center; font-size: 42px;">
			<span class="fa fa-clock-o"></span> <?=date("Y-m-d H:i:s", time()); ?>
		</h1>
	</section>

	<div id="boss-list-ajax">
		<!-- INSERT BOSS LIST AJAX -->
	</div>
</div>



<script>
getBossList();

function getBossList() {
	$.ajax({
		type: "GET",
		url: "/boss/getBossList_ajax",
		success: function(result) {
			$("#boss-list-ajax").html(result);
		},
		error: function(xhr, status, error) {
			console.log(xhr);
			console.log(status);
			console.log(error);
		}
	});
}

var serverDateTime = "<?=date("F d, Y H:i:s", time()); ?>";
var nowDateTime = new Date(serverDateTime);
setInterval("serverTime()", 1000);
	
function serverTime() {
	nowDateTime.setSeconds(nowDateTime.getSeconds()+1);
	var year = nowDateTime.getFullYear();
	var month = leadingZeros(nowDateTime.getMonth() + 1, 2);
	var date = leadingZeros(nowDateTime.getDate(), 2);
	var hours = leadingZeros(nowDateTime.getHours(), 2);
	var minutes = leadingZeros(nowDateTime.getMinutes(), 2);
	var seconds = leadingZeros(nowDateTime.getSeconds(), 2);
	var html = "";
	html += "<span class='fa fa-clock-o'></span> ";
	html += year + "-" + month + "-" + date + " " + hours + ":" + minutes + ":" + seconds;
	$("#serverTime").html(html);
}

function leadingZeros(number, width) {
	number = number + '';
	
	return number.length >= width ? number : new Array(width - number.length + 1).join('0') + number;
};
</script>
