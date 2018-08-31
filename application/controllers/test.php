<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller {
	
	function __construct() {
		parent::__construct();
	
		$this->load->model('member_model');
		$this->load->model('boss_model');
		$this->load->model('bossboard_model');
		$this->load->model('bossboardparticipant_model');
		$this->load->model('bossboardattachfile_model');
		$this->load->model('bossboarditem_model');
		$this->load->model('itemlist_model');
		$this->load->model('group_model');
	}
	
	public function delete() {
	    $bossBoardId = 89;
	    $this->bossboard_model->deleteBossBoard($bossBoardId);
        $this->bossboardattachfile_model->deleteBossAttachFileByBossBoardId($bossBoardId);
        $this->bossboarditem_model->deleteBossBoardItemByBossBoardId($bossBoardId);
        $this->bossboardparticipant_model->deleteBossParticipantByBossBoardId($bossBoardId);
	}
	
	public function register_submit() {
		$memberId = $this->input->post("memberId");
		$nickname = $this->input->post("nickname");
		$className = $this->input->post("className");
		$password = $this->input->post("password");
		$passwordConfirm = $this->input->post("passwordConfirm");
		$groupNameId = $this->input->post("groupNameId");
		
		if ($memberId != "" && $nickname != "" && $className != "" && $password != "" && $passwordConfirm != "" && $groupNameId != "") {
			$isExistMemberId = $this->member_model->isExistMemberId($memberId);
			if ($isExistMemberId != null) {
				alert("이미 존재하는 아이디 입니다.");
			}
			
			$isExistMemberNickname = $this->member_model->isExistMemberNickname($nickname);
			if ($isExistMemberNickname != null) {
				alert("이미 존재하는 캐릭터명 입니다.");
			}
			
			if ($password === $passwordConfirm) {
				$result = $this->member_model->insertMember($memberId, $nickname, $className, $password, $groupNameId);
				alert("회원가입 완료.", "/auth/login");
			} else {
				alert("비밀번호가 일치하지 않습니다.");
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
		
		if ($memberId != "" && $password != "") {
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
		} else {
			alert("아이디 또는 비밀번호를 입력해주세요.");
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
