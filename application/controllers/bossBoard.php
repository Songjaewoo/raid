<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL);
ini_set("display_errors", 1);

class BossBoard extends CI_Controller {
	
	function __construct(){
		parent::__construct();
	
		$this->load->model('member_model');
		$this->load->model('boss_model');
		$this->load->model('bossboard_model');
		$this->load->model('bossboardparticipant_model');
		$this->load->model('bossboardattachfile_model');
		$this->load->model('bossboarditem_model');
		$this->load->model('itemlist_model');
		$this->load->model('group_model');
		
		$this->load->helper('header_footer_helper');
		$this->load->helper('alert_helper');
		$this->load->helper('location_helper');
	}
	
	public function index() {
		common_header();
		
		$bossBoardList = $this->bossboard_model->getBossBoardList();
		$data = array(
			"bossBoardList" => $bossBoardList,
		);
		
		$this->load->view("bossBoard/list.view.php", $data);
		
		common_footer();
	}
	
	public function detail() {
		common_header();
	
		$bossBoardList = $this->bossboard_model->getList();
	
		$data = array(
			"bossBoardList" => $bossBoardList,
		);
	
		$this->load->view("bossBoard/list.view.php", $data);
	
		common_footer();
	}
	
	public function write() {
		common_header();
		$bossList = $this->boss_model->getBossNameList();
		$groupMemberList = $this->member_model->getMemberListByGroup();
		$itemList = $this->itemlist_model->getList();
		
		$data = array(
			"bossList" => $bossList,
			"groupMemberList" => $groupMemberList,
			"itemList" => $itemList,
		);
		
		$this->load->view("bossBoard/write.view.php", $data);
		
		common_footer();
	}
	
	public function write_submit_ajax() {
		$writerId = LOGIN_ID;
		$writerNickname = LOGIN_NICKNAME;
		$killDateTime = $this->input->post("killDateTime");
		$bossName = $this->input->post("bossName");
		$bossManageName = $this->input->post("bossManageName");
		$etc = $this->input->post("etc");
		$participantList = $this->input->post("participantList");
		$bossItemList = $this->input->post("bossItemList");
		$attachFile1 = $_FILES['attachFile1'];
		$attachFile2 = $_FILES['attachFile2'];
		
		$resultInsertBossBoardId = $this->bossboard_model->insertBossBoard($writerId, $writerNickname, $killDateTime, $bossName, $etc, $bossManageName);
		if ($resultInsertBossBoardId > 0) {
			//INSERT PARTICIPANT
			$decodeParticipantList = json_decode($participantList, true);
			foreach ($decodeParticipantList as $key => $value) {
				$bossBoardId = $resultInsertBossBoardId;
				$memberId = $value['memberId'];
				$memberNickname = $value['nickname'];
				$dividend = $value['dividend'];
				
				$this->bossboardparticipant_model->insertBossParticipant($bossBoardId, $memberId, $memberNickname, $dividend);
			}
			
			$decodeBossItemList = json_decode($bossItemList, true);
			foreach ($decodeBossItemList as $key => $value) {
				$bossBoardId = $resultInsertBossBoardId;
				$memberId = $value['memberId'];
				$memberNickname = $value['nickname'];
				$itemId = $value['itemId'];
				$itemPrice = $value['price'];
			
				$this->bossboarditem_model->insertBossBoardItem($bossBoardId, $itemId, $itemPrice, $memberId, $memberNickname);
			}
			
			//INSERT ATTACHFILE
			if ($attachFile1['size'] > 0) {
				$uploadConfig['upload_path'] = './uploads';
				$uploadConfig['allowed_types'] = 'gif|jpg|png|bmp';
				$uploadConfig['max_size'] = 10240;
				$uploadConfig['file_name'] = time() + mt_rand(1, 100);
				$this->load->library('upload', $uploadConfig);
				
				if (!$this->upload->do_upload('attachFile1')) {
					echo $this->upload->display_errors(); exit;
				} else {
					$fileInfo = $this->upload->data();
					$fileFullPath = $fileInfo['full_path'];
				}
			}
			
			if ($attachFile2['size'] > 0) {
				$uploadConfig['upload_path'] = './uploads';
				$uploadConfig['allowed_types'] = 'gif|jpg|png|bmp';
				$uploadConfig['max_size'] = 10240;
				$uploadConfig['file_name'] = time() + mt_rand(1, 100);
				$this->load->library('upload', $uploadConfig);
			
				if (!$this->upload->do_upload('attachFile2')) {
					echo $this->upload->display_errors(); exit;
				} else {
					$fileInfo = $this->upload->data();
					$fileFullPath = $fileInfo['full_path'];
				}
			}
			
			$jsonResult['status'] = 200;
		} else {
			$jsonResult['status'] = 400;
		}
		
		echo json_encode($jsonResult);
	}
	
	public function groupMemberList_ajax() {
		$groupId = $this->input->get("groupId");
		
		if ($groupId == 0) {
			$groupId = null;
		}
		
		$groupMemberList = $this->member_model->getMemberListByGroup($groupId);
		
		echo json_encode($groupMemberList);
	}
	
	private function makeDirectories($sPath) {
		$aPath = explode('/', $sPath);
		$sTemp = '';
	
		foreach ($aPath as $sVal) {
			if(trim($sVal) == '') {
				continue;
			}
	
			$sTemp .= '/' . $sVal;
			if (!file_exists($sTemp)) {
				mkdir($sTemp);
			}
		}
	}
}
