<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fund extends CI_Controller {
	
	function __construct(){
		parent::__construct();
	
		$this->load->model('funduse_model');
		$this->load->model('payment_model');
		$this->load->model('tax_model');
		
		$this->load->helper('header_footer_helper');
		$this->load->helper('alert_helper');
		$this->load->helper('location_helper');
	}
	
	public function useList() {
		common_header();
		
		$fundUseList = $this->funduse_model->getList();
		$currentGroupFund = $this->funduse_model->getCurrentGroupFund();
		$groupTaxPercent = $this->tax_model->getTax(2);
		$allNotFinishDividend = $this->bossboardparticipant_model->getAllDiviend("N");
		
		$allPayment = $this->payment_model->getAllPayment();
		$expectGroupFund = floor(($allPayment * ((100 - $groupTaxPercent) / 100) - $allNotFinishDividend) + $currentGroupFund);

		$data = array(
		    "fundUseList" => $fundUseList,
		    "currentGroupFund" => $currentGroupFund,
		    "expectGroupFund" => $expectGroupFund,
		    "allNotFinishDividend" => $allNotFinishDividend,
		    "taxPercent" => $groupTaxPercent,
		);
		
		$this->load->view("fund/fundUse.view.php", $data);
		
		common_footer();
	}
	
	public function back() {
	    if (LOGIN_LEVEL < 4) {
	        alert("접근 권한이 없습니다.");
	    }
	    
	    common_header();
	    
	    $paymentList = $this->payment_model->getList();

	    $data = array(
	        "paymentList" => $paymentList,
	    );
	    
	    $this->load->view("fund/back.view.php", $data);
	    
	    common_footer();
	}
	
	public function updatePayModal_ajax() {
	    $payId = $this->input->get("payId");
	    
	    $payDetail = $this->payment_model->getDetailPayment($payId);
	    $data = array(
	        "payDetail" => $payDetail,
	    );
	    
	    $this->load->view("fund/modal/payment.modal.view.php", $data);
	}
	
	public function updatePay_ajax() {
	    $useMoney = $this->input->post("useMoney");
	    $nickname = $this->input->post("nickname");
	    $memberId = $this->input->post("memberId");
	    $memo = $this->input->post("memo");
	    
	    $resultUpdate = $this->payment_model->updatePayment(($useMoney * -1), $memberId);
	    
	    if ($resultUpdate > 0) {
	        $itemTaxPercent = $this->tax_model->getTax(1);
	        $useMoney = floor($useMoney * ((100 - $itemTaxPercent) / 100));
	        
	        $autoMemo = "$nickname 상납금  $useMoney 정산완료";
	        if ($memo != "") {
	        	$memo = $memo . " [$autoMemo]";
	        } else {
	        	$memo = $autoMemo;
	        }
	        
	        $this->funduse_model->insertFundUse(LOGIN_ID, $useMoney, $memo, "N", 1);
	        
	        $jsonResult['status'] = 200;
	        $jsonResult['data'] = $resultUpdate;
	    } else {
	        $jsonResult['status'] = 404;
	        $jsonResult['data'] = $resultUpdate;
	    }
	    
	    echo json_encode($jsonResult);
	}
	
	public function addFundUse_ajax() {
	    $writerId = LOGIN_ID;
	    $useMoney = $this->input->post("useMoney");
	    $memo = $this->input->post("memo");
	    
	    if ($writerId != "" && $useMoney != "") {
	        $result = $this->funduse_model->insertFundUse($writerId, $useMoney, $memo, "Y", 1);
    	    
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
	
	public function deleteFundUse_ajax() {
	    $id = $this->input->post("id");
	    
	    $result = $this->funduse_model->deleteFundUse($id);
        
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
		$result = $this->tax_model->updateTax($taxPercent, 2);
		 
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
