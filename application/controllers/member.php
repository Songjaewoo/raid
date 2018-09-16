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
	    if (LOGIN_LEVEL < 4) {
	        alert("접근 권한이 없습니다.");
	    }
	    
		common_header();
		
		$groupId = $this->input->get("groupId") != 0 ? $this->input->get("groupId") : null;
		$level = $this->input->get("level") != 0 ? $this->input->get("level") : null;
		$className = $this->input->get("className") != "" ? $this->input->get("className") : null;
		$approval = $this->input->get("approval") == null ? 1: $this->input->get("approval");
		$nickname = $this->input->get("nickname") != "" ? $this->input->get("nickname") : null;

		$memberList = $this->member_model->getMemberList($groupId, $level, 
                                                		    $className, $approval,
                                                		    $nickname);
		$groupList = $this->group_model->getList();
		
		$groupApprovalList0 = $this->group_model->getGroupChartInfo(0); // 미승인
		$groupApprovalList1 = $this->group_model->getGroupChartInfo(1); // 가입
		$groupApprovalList2 = $this->group_model->getGroupChartInfo(2); // 탈퇴
		
		$data = array(
		    "memberList" => $memberList,
		    "groupList" => $groupList,
		    "groupId" => $groupId,
		    "level" => $level,
		    "className" => $className,
		    "approval" => $approval,
		    "nickname" => $nickname,
		    "groupApprovalList0" => $groupApprovalList0,
		    "groupApprovalList1" => $groupApprovalList1,
		    "groupApprovalList2" => $groupApprovalList2,
		);
		
		$this->load->view("member/list.view.php", $data);
		
		common_footer();
	}
	
	public function approval() {
	    if (LOGIN_LEVEL < 4) {
	        alert("접근 권한이 없습니다.");
	    }
	    
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
	
	public function headerMemberUpdateModal_ajax() {
		 
		$memberDetail = $this->member_model->getMemberDetailById(LOGIN_ID);
		$groupList = $this->group_model->getList();

		$data = array(
			"memberDetail" => $memberDetail,
			"groupList" => $groupList,
		);
		 
		$this->load->view("common/modal/update.modal.view.php", $data);
	}
	
	public function headerMemberPasswordUpdateModal_ajax() {
		 
		$this->load->view("common/modal/updatePassword.modal.view.php");
	}
	
	public function headerUpdateMemberPassword_ajax() {
		$currentPassword = $this->input->post("currentPassword");
		$password = $this->input->post("password");
		$passwordConfirm = $this->input->post("passwordConfirm");
		
		$result = $this->member_model->getMemberDetailByMemberId(LOGIN_MEMBER_ID);
		$hashedPassword = $result['password'];
		
		if ($this->verify($password, $hashedPassword)) {
			if ($password != $passwordConfirm) {
				$jsonResult['status'] = 401;
				$jsonResult['data'] = "변경할 비밀번호가 일치하지 않습니다.";
				echo json_encode($jsonResult);
				exit;
			}
			
			$resultUpdate = $this->member_model->updateMemberPassword($password, LOGIN_ID);
			
			if ($resultUpdate > 0) {
				$jsonResult['status'] = 200;
				$jsonResult['data'] = "비밀번호가 변경되었습니다.";
			} else {
				$jsonResult['status'] = 404;
				$jsonResult['data'] = "오류";
			}
		} else {
			$jsonResult['status'] = 401;
			$jsonResult['data'] = "현재 비밀번호를 다시 확인해주세요.";
			echo json_encode($jsonResult);
			exit;
		}
		 
		echo json_encode($jsonResult);
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
	    
	    if ($memberId != "" && $nickname != "" && $className != "" && $level != "" && $groupId != "") {
	        
// 	        $isExistMemberNickname = $this->member_model->isExistMemberNickname($nickname);
// 	        if ($isExistMemberNickname != null) {
// 	            $jsonResult['status'] = 404;
// 	            echo json_encode($jsonResult);
// 	            exit;
// 	        }
	        
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
	
	public function headerMemberUpdate_submit_ajax() {
		$nickname = $this->input->post("nickname");
		$className = $this->input->post("className");
		$groupId = $this->input->post("groupId");
		
		$memberDetail = $this->member_model->getMemberDetailById(LOGIN_ID);
		
		if ($memberDetail != null && $nickname != "" && $className != "" && $groupId != "") {
			$level = $memberDetail['level'];
			
// 			$isExistMemberNickname = $this->member_model->isExistMemberNickname($nickname);
// 			if ($isExistMemberNickname != null) {
// 			    $jsonResult['status'] = 404;
// 			    echo json_encode($jsonResult);
// 			    exit;
// 			}
			
			$resultUpdate = $this->member_model->updateMemberBaseInfo($nickname, $className, $level, $groupId, LOGIN_ID);
			 
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
	
	private function verify($password , $hashedPassword) {
		return password_verify($password, $hashedPassword);
	}
}
