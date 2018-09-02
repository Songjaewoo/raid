<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function common_header($headerParam = null) {
	$CI =& get_instance();
	$CI->load->model('bossboardparticipant_model');
	
	$myDividend = $CI->bossboardparticipant_model->getMyDiviend(LOGIN_ID, "N");
	$data = array(
	    "myDividend" => $myDividend,
	);
	
	$CI->load->view('common/header.view.php', $data);
}

function common_footer($footerParam = null) {
	$CI =& get_instance();
	
	$CI->load->view('common/footer.view.php');
}
