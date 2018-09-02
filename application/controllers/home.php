<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
	
	function __construct(){
		parent::__construct();
	
		$this->load->model('bossboardparticipant_model');
		
		$this->load->helper('header_footer_helper');
		$this->load->helper('alert_helper');
		$this->load->helper('location_helper');
	}
	
	public function index() {
		common_header();
		
		$allNotFinishDividend = $this->bossboardparticipant_model->getAllDiviend("N");
		$countNotFinishDividendMember = $this->bossboardparticipant_model->countMemberDiviend("N");
		
		$data = array(
		    "allNotFinishDividend" => $allNotFinishDividend,
		    "countNotFinishDividendMember" => $countNotFinishDividendMember,
		);
		
		$this->load->view("home.view.php", $data);
		
		common_footer();
	}
}
