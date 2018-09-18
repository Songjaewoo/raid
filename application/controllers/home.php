<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
	
	function __construct(){
		parent::__construct();
	
		$this->load->model('bossboardparticipant_model');
		$this->load->model('funduse_model');
		$this->load->model('payment_model');
		$this->load->model('tax_model');
		$this->load->model('board_model');
		$this->load->model('bossboarditem_model');
		$this->load->model('group_model');
		$this->load->model('member_model');
		
		$this->load->helper('header_footer_helper');
		$this->load->helper('alert_helper');
		$this->load->helper('location_helper');
	}
	
	public function index() {
		common_header();
		
		$allPayment = $this->payment_model->getAllPayment();
		$currentGroupFund = $this->funduse_model->getCurrentGroupFund();
		$allNotFinishDividend = $this->bossboardparticipant_model->getAllDiviend("N");
		$countNotFinishDividendMember = $this->bossboardparticipant_model->countMemberDiviend("N");
		
		$groupTaxPercent = $this->tax_model->getTax(2);
		
		$expectGroupFund = floor(($allPayment * ((100 - $groupTaxPercent) / 100) - $allNotFinishDividend) + $currentGroupFund);
		
		$noticeBoardList = $this->board_model->getList(1, 0, 5);
		$freeBoardList = $this->board_model->getList(2, 0, 5);
		
		$classPieChartInfo = $this->member_model->getClassPieChartInfo();
		$dropItemChartInfo1 = $this->bossboarditem_model->getDropItemChart(20);
		$dropItemChartInfo2 = $this->bossboarditem_model->getDropItemChart(53);
		
		$data = array(
		    "allPayment" => $allPayment,
		    "expectGroupFund" => $expectGroupFund,
		    "allNotFinishDividend" => $allNotFinishDividend,
		    "countNotFinishDividendMember" => $countNotFinishDividendMember,
			"noticeBoardList" => $noticeBoardList,
			"freeBoardList" => $freeBoardList,
			"classPieChartInfo" => htmlspecialchars(json_encode($classPieChartInfo)), 
			"dropItemChartInfo1" => htmlspecialchars(json_encode($dropItemChartInfo1)),
			"dropItemChartInfo2" => htmlspecialchars(json_encode($dropItemChartInfo2)),
		);
		
		$this->load->view("home.view.php", $data);
		
		common_footer();
	}
}
