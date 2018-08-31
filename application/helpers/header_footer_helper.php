<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function common_header($headerParam = null) {
	$CI =& get_instance();
	
	$CI->load->view('common/header.view.php');
}

function common_footer($footerParam = null) {
	$CI =& get_instance();
	
	$CI->load->view('common/footer.view.php');
}
