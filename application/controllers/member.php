<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member extends CI_Controller {
	
	function __construct(){
		parent::__construct();
	
		$this->load->model('member_model');
		$this->load->model('group_model');
		
		$this->load->helper('header_footer_helper');
		$this->load->helper('alert_helper');
		$this->load->helper('location_helper');
	}
	
	public function index() {
		common_header();
		
		$groupId = $this->input->get("groupId") != 0 ? $this->input->get("groupId") : null;
		$level = $this->input->get("level") != 0 ? $this->input->get("level") : null;
		$className = $this->input->get("className") != "" ? $this->input->get("className") : null;
		$approval = $this->input->get("approval") != 1 ? $this->input->get("approval") : 1;
		$nickname = $this->input->get("nickname") != "" ? $this->input->get("nickname") : null;

		$memberList = $this->member_model->getMemberList($groupId, $level, 
                                                		    $className, $approval,
                                                		    $nickname);
		$groupList = $this->group_model->getList();
		
		$data = array(
		    "memberList" => $memberList,
		    "groupList" => $groupList,
		    "groupId" => $groupId,
		    "level" => $level,
		    "className" => $className,
		    "approval" => $approval,
		    "nickname" => $nickname,
		);
		
		$this->load->view("member/list.view.php", $data);
		
		common_footer();
	}
	
	public function approval() {
	    common_header();
	    
	    $groupId = null;
	    $level = null;
	    $className = null;
	    $approval = "0";
	    $nickname = null;
	    $memberList = $this->member_model->getMemberList($groupId, $level,
                                                        $className, $approval,
                                            	        $nickname);
	    
	    $data = array(
	        "memberList" => $memberList,
	    );
	    
	    $this->load->view("member/approval.view.php", $data);
	    
	    common_footer();
	}
	
	public function memberUpdateModal_ajax() {
	    $memberId = $this->input->get("memberId");
	    
	    $memberDetail = $this->member_model->getMemberDetailById($memberId);
	    $groupList = $this->group_model->getList();
	    
	    $data = array(
	        "memberDetail" => $memberDetail,
	        "groupList" => $groupList,
	    );
	    
	    $this->load->view("member/modal/update.modal.view.php", $data);
	}
	
	public function memberPasswordUpdateModal_ajax() {
	    $memberId = $this->input->get("memberId");
	    
	    $data = array(
	        "memberId" => $memberId,
	    );
	    
	    $this->load->view("member/modal/updatePassword.modal.view.php", $data);
	}
	
	public function memberUpdate_submit_ajax() {
	    $memberId = $this->input->post("memberId");
	    $nickname = $this->input->post("nickname");
	    $className = $this->input->post("className");
	    $level = $this->input->post("level");
	    $groupId = $this->input->post("groupId");
	    
	    if ($memberId != "" && $nickname != "" && $className != "" && $level != "" && $groupId) {
	        $resultUpdate = $this->member_model->updateMemberBaseInfo($nickname, $className, $level, $groupId, $memberId);
	        
	        if ($resultUpdate > 0) {
                $jsonResult['status'] = 200;
	        } else {
                $jsonResult['status'] = 404;
	        }
	    } else {
	        $jsonResult['status'] = 404;
	    }
	    
	    echo json_encode($jsonResult);
	}
	
	public function updateMemberPassword_ajax() {
	    $memberId = $this->input->post("memberId");
	    $password = $this->input->post("password");
	    
	    if ($memberId > 0 && $password != "") {
	        $resultUpdate = $this->member_model->updateMemberPassword($password, $memberId);
	        
	        if ($resultUpdate > 0) {
	            $jsonResult['status'] = 200;
	        } else {
	            $jsonResult['status'] = 404;
	        }
	    } else {
	        $jsonResult['status'] = 404;
	    }
	    
	    echo json_encode($jsonResult);
	}
	
	public function updateMemberApproval_ajax() {
	    $memberId = $this->input->post("memberId");
	    $approval = $this->input->post("approval");
	    
	    if ($memberId != "" && $approval != "") {
	        $resultUpdate = $this->member_model->updateMemberApproval($approval, $memberId);
	        
	        if ($resultUpdate > 0) {
	            $jsonResult['status'] = 200;
	        } else {
	            $jsonResult['status'] = 404;
	        }
	    } else {
	        $jsonResult['status'] = 404;
	    }
	    
	    echo json_encode($jsonResult);
	}
}