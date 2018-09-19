<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Boss extends CI_Controller {
	
	function __construct(){
		parent::__construct();
	
		$this->load->model('boss_model');
		$this->load->model('bossmemo_model');
		$this->load->model('tax_model');
		
		$this->load->helper('header_footer_helper');
		$this->load->helper('alert_helper');
		$this->load->helper('location_helper');
	}
	
	public function index() {
		if (LOGIN_LEVEL < 2) {
			alert("접근 권한이 없습니다.");
		}
		
		common_header();
		
		$this->load->view("boss/boss.view.php");
		
		common_footer();
	}
	
	public function getBossList_ajax() {
		$currentDateTime = date("Y-m-d H:i");
		$bossList = $this->boss_model->getList();
		$taxPercent = $this->tax_model->getTax(1);
		$bossMemoList = $this->bossmemo_model->getList();
		
		$data = array(
			"currentDateTime" => $currentDateTime,
			"bossList" => $bossList,
		    "taxPercent" => $taxPercent,
			"bossMemoList" => $bossMemoList,
		);
		
		$this->load->view("boss/list.view.php", $data);
	}
	
	public function addBoss_ajax() {
	    $bossName = $this->input->post("bossName");
	    $genTime = $this->input->post("genTime");
	    
	    if ($bossName != "" && $genTime != "") {
	        $genTime = $genTime . ":00:00";
    	    $result = $this->boss_model->insertBoss($bossName, $genTime);
    	    
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
	
	public function addBossMemo_ajax() {
		$writerId = LOGIN_ID;
		$content = $this->input->post("content");
		 
		$result = $this->bossmemo_model->insertBossMemo($writerId, $content);
		if ($result > 0) {
			$jsonResult['status'] = 200;
			$jsonResult['data'] = $result;
		} else {
			$jsonResult['status'] = 404;
			$jsonResult['data'] = $result;
		}
		 
		echo json_encode($jsonResult);
	}
	
	public function updateKillDateTime_ajax() {
		$id = $this->input->post("id");
		$result = $this->boss_model->updateKillDateTime($id);
	
		if ($result > 0) {
			$jsonResult['status'] = 200;
			$jsonResult['data'] = $result;
		} else {
			$jsonResult['status'] = 404;
			$jsonResult['data'] = $result;
		}
		
		echo json_encode($jsonResult);
	}
	
	public function updateKillPass_ajax() {
		$id = $this->input->post("id");
		$result = $this->boss_model->updateKillPass($id);
	
		if ($result > 0) {
			$jsonResult['status'] = 200;
			$jsonResult['data'] = $result;
		} else {
			$jsonResult['status'] = 404;
			$jsonResult['data'] = $result;
		}
	
		echo json_encode($jsonResult);
	}
	
	public function updateDirectDateTime_ajax() {
		$id = $this->input->post("id");
		$updateTime = $this->input->post("updateTime");
		$result = $this->boss_model->updateDirectDateTime($id, $updateTime);
	
		if ($result > 0) {
			$jsonResult['status'] = 200;
			$jsonResult['data'] = $result;
		} else {
			$jsonResult['status'] = 404;
			$jsonResult['data'] = $result;
		}
	
		echo json_encode($jsonResult);
	}
	
	public function updateTaxPercent_ajax() {
	    $taxPercent = $this->input->post("taxPercent");
	    $result = $this->tax_model->updateTax($taxPercent, 1);
	    
	    if ($result > 0) {
	        $jsonResult['status'] = 200;
	        $jsonResult['data'] = $result;
	    } else {
	        $jsonResult['status'] = 404;
	        $jsonResult['data'] = $result;
	    }
	    
	    echo json_encode($jsonResult);
	}
}
