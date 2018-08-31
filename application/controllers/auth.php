<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {
	
	function __construct() {
		parent::__construct();
	
		$this->load->model('member_model');
		$this->load->model('group_model');
		
		$this->load->helper('alert_helper');
		$this->load->helper('location_helper');
	}
	
	public function register() {
		$groupNameList = $this->group_model->getList();
		
		$data = array(
			"groupNameList" => $groupNameList,	
		);
		
		$this->load->view("auth/register.view.php", $data);
		
	}
	
	public function register_submit() {
		$memberId = $this->input->post("memberId");
		$nickname = $this->input->post("nickname");
		$password = $this->input->post("password");
		$passwordConfirm = $this->input->post("passwordConfirm");
		$groupNameId = $this->input->post("groupNameId");
		
		if ($memberId != "" && $nickname != "" && $password != "" && $passwordConfirm != "" && $groupNameId != "") {
			if ($password === $passwordConfirm) {
				$result = $this->member_model->insertMember($memberId, $nickname, $password, $groupNameId);
				alert("회원가입 완료.", "/auth/login");
			} else {
				alert("패스워드가 일치하지 않습니다.");
			}
		} else {
			alert("모든 정보를 입력해 주세요.");
		}
	}
	
	public function login() {
		$this->session->sess_destroy();
		
		$this->load->view("auth/login.view.php");
	}
	
	public function login_submit() {
		$memberId = $this->input->post("memberId");
		$password = $this->input->post("password");
		
		$result = $this->member_model->getMemberDetailByMemberId($memberId);
		$hashedPassword = $result['password'];
		
		if ($this->verify($password, $hashedPassword)) {
			if ($result['approval'] == 1) {
				$sessionData = array(
					"id" => $result['id'],
					"memberId" => $result['memberId'],
					"nickname" => $result['nickname'],
					"level" => $result['level'],
					"groupName" => $result['groupName'],
					"isLogin" => true,
				);
				$this->session->set_userdata($sessionData);
				
				locationHref("/");
			} else {
				alert("관리자 승인 요청이 필요합니다.");
			}
		} else {
			alert("아이디 또는 비밀번호를 다시 확인하세요.");
		}
	}
	
	public function logout() {
		$this->session->sess_destroy();
		
		locationHref("/auth/login");
	}
	
	private function verify($password , $hashedPassword) {
		return crypt($password, $hashedPassword) == $hashedPassword;
	}
}
