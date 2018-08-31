<?php if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
	
function locationHrefBlank($url = '') {
	$CI = & get_instance ();
	
	echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=" . $CI->config->item ( 'charset' ) . "\">";
	echo "<script type='text/javascript'>";
	echo "	window.open('" . $url . "', '_blank');";
	echo "</script>";
	exit ();
}

function locationHref($url = '') {
	$CI = & get_instance ();

	echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=" . $CI->config->item ( 'charset' ) . "\">";
	echo "<script type='text/javascript'>";
	echo "	location.href = '" . $url . "';";
	echo "</script>";
	exit ();
}
