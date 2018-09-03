<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
		
		$this->load->library('upload');
		
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

		$id = $this->input->get("id");
        
		$transResult = array();
		$resultBossBoard = $this->bossboard_model->getDetail($id);
		$transResult = $resultBossBoard;
		
		$resultBossBoardItem = $this->bossboarditem_model->getBossItemListbyBossBoardId($id);
		$transResult['item'] = $resultBossBoardItem;
		$resultBossBoardParticipant = $this->bossboardparticipant_model->getBoardParticipantByBossBoardId($id);
		$transResult['participant'] = $resultBossBoardParticipant;
		$resultBossBoardAttachFile = $this->bossboardattachfile_model->getDetailListByBossBoardId($id);
		$transResult['attachFile'] = $resultBossBoardAttachFile;

		$data = array(
		    "bossBoardId" => $id,
		    "detailBossBoard" => $transResult,
		);
	
		$this->load->view("bossBoard/detail.view.php", $data);
	
		common_footer();
	}
	
	public function write() {
		common_header();
		$bossList = $this->boss_model->getBossNameList();
		$groupMemberList = $this->member_model->getMemberList();
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
		$bossId = $this->input->post("bossId");
		$bossManageName = $this->input->post("bossManageName");
		$etc = $this->input->post("etc");
		$participantList = $this->input->post("participantList");
		$bossItemList = $this->input->post("bossItemList");
		$totalItemPrice = $this->input->post("totalItemPrice");
		$totalParticipantMember = $this->input->post("totalParticipantMember");
		$attachFile1 = $_FILES['attachFile1'];
		$attachFile2 = $_FILES['attachFile2'];
		
		$resultInsertBossBoardId = $this->bossboard_model->insertBossBoard($writerId, $writerNickname, $killDateTime, $bossId, $etc, $bossManageName);
		if ($resultInsertBossBoardId > 0) {
		    if ($totalParticipantMember > 0) {
    		    $dividend = floor(($totalItemPrice * 0.92) / $totalParticipantMember);
		    }
		    
			//INSERT PARTICIPANT
			$decodeParticipantList = json_decode($participantList, true);
			foreach ($decodeParticipantList as $key => $value) {
				$bossBoardId = $resultInsertBossBoardId;
				$memberId = $value['memberId'];
				
				$this->bossboardparticipant_model->insertBossParticipant($bossBoardId, $memberId, $dividend);
			}
			
			$decodeBossItemList = json_decode($bossItemList, true);
			foreach ($decodeBossItemList as $key => $value) {
				$bossBoardId = $resultInsertBossBoardId;
				$memberId = $value['memberId'];
				$itemId = $value['itemId'];
				$itemPrice = $value['price'];
			
				$this->bossboarditem_model->insertBossBoardItem($bossBoardId, $itemId, $itemPrice, $memberId);
			}
			
			//INSERT ATTACHFILE
			if ($attachFile1['size'] > 0) {
			    $bossBoardId = $resultInsertBossBoardId;
			    
				$uploadConfig['upload_path'] = './uploads';
				$uploadConfig['allowed_types'] = 'gif|jpg|png|bmp';
				$uploadConfig['max_size'] = 10240;
				$uploadConfig['file_name'] = $this->uuidgen();
				$this->upload->initialize($uploadConfig);
				
				if (!$this->upload->do_upload('attachFile1')) {
					echo $this->upload->display_errors(); exit;
				} else {
					$fileInfo = $this->upload->data();
					$originFileName = $fileInfo['client_name'];
					$saveFileName = $fileInfo['file_name'];
					$fileUrl = SERVER_DOMAIN . "/uploads/" . $saveFileName;
					$this->bossboardattachfile_model->insertBossAttachFile($bossBoardId, $originFileName, $fileUrl);
				}
			}
			
			if ($attachFile2['size'] > 0) {
			    $bossBoardId = $resultInsertBossBoardId;
			    
				$uploadConfig['upload_path'] = './uploads';
				$uploadConfig['allowed_types'] = 'gif|jpg|png|bmp';
				$uploadConfig['max_size'] = 10240;
				$uploadConfig['file_name'] = $this->uuidgen();
				$this->upload->initialize($uploadConfig);
			
				if (!$this->upload->do_upload('attachFile2')) {
					echo $this->upload->display_errors(); exit;
				} else {
				    $fileInfo = $this->upload->data();
				    $originFileName = $fileInfo['client_name'];
				    $saveFileName = $fileInfo['file_name'];
				    $fileUrl = SERVER_DOMAIN . "/uploads/" . $saveFileName;
				    $this->bossboardattachfile_model->insertBossAttachFile($bossBoardId, $originFileName, $fileUrl);
				}
			}
			
			$jsonResult['status'] = 200;
			$jsonResult['data'] = $resultInsertBossBoardId;
		} else {
			$jsonResult['status'] = 400;
			$jsonResult['data'] = null;
		}
		
		echo json_encode($jsonResult);
	}
	
	public function delete_ajax() {
	    $bossBoardId = $this->input->post("bossBoardId");
	    
	    $resultDeleteBossBoard = $this->bossboard_model->deleteBossBoard($bossBoardId);
	    
	    if ($resultDeleteBossBoard > 0) {
    	    $this->bossboardattachfile_model->deleteBossAttachFileByBossBoardId($bossBoardId);
    	    $this->bossboarditem_model->deleteBossBoardItemByBossBoardId($bossBoardId);
    	    $this->bossboardparticipant_model->deleteBossParticipantByBossBoardId($bossBoardId);
    	    
    	    $jsonResult['status'] = 200;
	    } else {
	        $jsonResult['status'] = 400;
	    }
	    
	    echo json_encode($jsonResult);
	}
	
	private function uuidgen() {
        return sprintf('%08x-%04x-%04x-%04x-%04x%08x',
            mt_rand(0, 0xffffffff),
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff), mt_rand(0, 0xffffffff)
        );
	}
}
