<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fund extends CI_Controller {
	
	function __construct(){
		parent::__construct();
	
		$this->load->model('funduse_model');
		
		$this->load->helper('header_footer_helper');
		$this->load->helper('alert_helper');
		$this->load->helper('location_helper');
	}
	
	public function useList() {
		common_header();
		
		$fundUseList = $this->funduse_model->getList();
		$currentGroupFund = $this->funduse_model->getCurrentGroupFund();
		
		$data = array(
		    "fundUseList" => $fundUseList,
		    "currentGroupFund" => $currentGroupFund,
		);
		
		$this->load->view("fund/fundUse.view.php", $data);
		
		common_footer();
	}
	
	public function addFundUse_ajax() {
	    $writerId = LOGIN_ID;
	    $useMoney = $this->input->post("useMoney");
	    $memo = $this->input->post("memo");
	    
	    if ($writerId != "" && $useMoney != "") {
	        $result = $this->funduse_model->insertFundUse($writerId, $useMoney, $memo);
    	    
    	    if ($result > 0) {
    	        $jsonResult['status'] = 200;
    	        $jsonResult['data'] = $result;
    	    } else {
    	        $jsonResult['status'] = 404;
    	        $jsonResult['data'] = $result;
    	    }
	    } else {
	        $jsonResult['status'] = 404;
	        $jsonResult['data'] = $result;
	    }
	    
	    echo json_encode($jsonResult);
	}
}
