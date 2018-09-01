<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dividend extends CI_Controller {
	
	function __construct() {
		parent::__construct();
	
		$this->load->model('member_model');
		$this->load->model('bossboardparticipant_model');
		
		$this->load->helper('header_footer_helper');
		$this->load->helper('alert_helper');
		$this->load->helper('location_helper');
	}
	
	public function index() {
	    common_header();
	    
	    $s = $this->input->get("s");
	    
	    $dividendList = $this->bossboardparticipant_model->getDividendListWithMember($s);
		$data = array(
		    "dividendList" => $dividendList,
		    "s" => $s,
		);
		
		$this->load->view("dividend/list.view.php", $data);
		
		common_footer();
	}
	
	public function detail() {
	    common_header();
	    
	    $memberId = $this->input->get("memberId");
	    $memberDetail = $this->member_model->getMemberDetailById($memberId);
	    $dividendDetailList = $this->bossboardparticipant_model->getDividendDetailWithMember($memberId);

	    $data = array(
	        "memberDetail" => $memberDetail,
	        "dividendDetailList" => $dividendDetailList,
	    );
	    
	    $this->load->view("dividend/detail.view.php", $data);
	    
	    common_footer();
	}
	
	public function updateDividendFinish_ajax() {
	    $id = $this->input->post("id");
	    
	    $resultUpdate = $this->bossboardparticipant_model->updateDividendFinish($id, "Y");
	    
	    if ($resultUpdate > 0) {
	        $jsonResult['status'] = 200;
	    } else {
	        $jsonResult['status'] = 400;
	    }
	    
	    echo json_encode($jsonResult);
	}
	
	public function updateCheckDividendFinish_ajax() {
	    $checkIdArray = $this->input->post("checkIdArray");
	    if ($checkIdArray != null) {
	        foreach ($checkIdArray as $key => $value) {
	            $resultUpdate = $this->bossboardparticipant_model->updateDividendFinish($value, "Y");
	        }
    	    
    	    if ($resultUpdate > 0) {
    	        $jsonResult['status'] = 200;
    	    } else {
    	        $jsonResult['status'] = 400;
    	    }
	    } else {
	        $jsonResult['status'] = 400;
	    }
	    
	    echo json_encode($jsonResult);
	}
}
