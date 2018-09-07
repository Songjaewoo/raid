<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function common_header($headerParam = null) {
	$CI =& get_instance();
	$CI->load->model('bossboardparticipant_model');
	$CI->load->model('payment_model');
	$CI->load->helper('url');
	
	$myDividend = $CI->bossboardparticipant_model->getMyDiviend(LOGIN_ID, "N");
	$myPayment = $CI->payment_model->getMyPayment(LOGIN_ID);
	$uriSegment1 = $CI->uri->segment(1);
	$uriSegment2 = $CI->uri->segment(2);
	
	$data = array(
	    "myDividend" => $myDividend,
	    "myPayment" => $myPayment,
		"uriSegment1" => $uriSegment1,
		"uriSegment2" => $uriSegment2,
	);
	
	$CI->load->view('common/header.view.php', $data);
}

function common_footer($footerParam = null) {
	$CI =& get_instance();
	
	$CI->load->view('common/footer.view.php');
}
