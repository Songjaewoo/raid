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
		$this->load->model('tax_model');
		$this->load->model('payment_model');
		
		$this->load->library('upload');
		$this->load->library('paging_info');
		$this->load->library('s3');
		
		$this->load->helper('header_footer_helper');
		$this->load->helper('alert_helper');
		$this->load->helper('location_helper');
	}
	
	public function index() {
		common_header();
		
		$serachType = $this->input->get('serachType') == null ? null : $this->input->get('serachType');
		$s = $this->input->get('s') == null ? null : $this->input->get('s');
		$pageNum = $this->input->get('pageNum') == null ? 1 : $this->input->get('pageNum');
		$limit = $this->input->get('limit') == null ? 10 : $this->input->get('limit');
		$offset = ($pageNum - 1) * $limit;
		
		$bossBoardList = $this->bossboard_model->getBossBoardList($offset, $limit, $serachType, $s);
		$countBossBoardList = $this->bossboard_model->countBossBoardList($serachType, $s);
		$pagination = $this->paging_info->getPagingInfo($pageNum, $countBossBoardList, $limit, 10);
		
		$data = array(
			"serachType" => $serachType,
			"s" => $s,
			"bossBoardList" => $bossBoardList,
			"pagination" => $pagination,
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
        if (LOGIN_LEVEL < 2) {
	        alert("접근 권한이 없습니다.");
	        exit;
	    }
	    
	    
		common_header();
		$bossList = $this->boss_model->getBossNameList();
		$groupMemberList = $this->member_model->getMemberList(null, null, null, 1, null);
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
	    if (LOGIN_LEVEL < 2) {
	        alert("접근 권한이 없습니다.");
	        exit;
	    }
	    
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
			$itemTaxPercent = $this->tax_model->getTax(1);
			$groupTaxPercent = $this->tax_model->getTax(2);
			$totalTaxPercent = $itemTaxPercent + $groupTaxPercent;
			
		    if ($totalParticipantMember > 0 && $totalItemPrice > 0) {
    		    $dividend = floor(($totalItemPrice * ((100 - $totalTaxPercent) / 100)) / $totalParticipantMember);
    		    
				//INSERT PARTICIPANT
				$decodeParticipantList = json_decode($participantList, true);
				foreach ($decodeParticipantList as $key => $value) {
					$bossBoardId = $resultInsertBossBoardId;
					$memberId = $value['memberId'];
					
					$this->bossboardparticipant_model->insertBossParticipant($bossBoardId, $memberId, $dividend);
				}
		    }
		    
		    //INSERT PAYMENT
		    if ($totalItemPrice > 0) {
		    	$memberId = LOGIN_ID;
		    	$pay = $totalItemPrice;
// 		    	$pay = floor($totalItemPrice * ((100 - $groupTaxPercent) / 100));
		    	
		    	$isExistPayment = $this->payment_model->isExistPaymentByMemberId($memberId);
		    	
		    	if ($isExistPayment != null) {
		    		$this->payment_model->updatePayment($pay, $memberId);
		    	} else {
		    		$this->payment_model->insertPayment($memberId, $pay);
		    	}
		    }
		    
			
			//INSERT BOSS ITEM LIST
			$decodeBossItemList = json_decode($bossItemList, true);
			foreach ($decodeBossItemList as $key => $value) {
				$bossBoardId = $resultInsertBossBoardId;
				$memberId = $value['memberId'];
				$itemId = $value['itemId'];
				$itemPrice = $value['price'];
			
				$this->bossboarditem_model->insertBossBoardItem($bossBoardId, $itemId, $itemPrice, $memberId);
			}

			//INSERT ATTACHFILE
			$allowFileExtArray  = ["gif", "jpg", "jpeg", "png", "bmp"];
			if ($attachFile1['size'] > 0) {
			    $bossBoardId = $resultInsertBossBoardId;
			    
			    $filepath = $attachFile1['tmp_name'];
			    $mime = $attachFile1['type'];
			    $originFileName = $attachFile1['name'];
			    $ext = strtolower(end(explode('.', $originFileName))); 
			    $saveFileName = $this->uuidgen() . "." . $ext;
			    
				if (!in_array($ext, $allowFileExtArray)) {
					$jsonResult['status'] = 400;
					$jsonResult['data'] = null;
					echo json_encode($jsonResult); 
					exit;
				}
				
				$fileUrl = $this->s3->s3Upload($filepath, $saveFileName, $mime);
				$this->bossboardattachfile_model->insertBossAttachFile($bossBoardId, $originFileName, $fileUrl);
			}
			
			if ($attachFile2['size'] > 0) {
			    $bossBoardId = $resultInsertBossBoardId;
			    
			    $filepath = $attachFile2['tmp_name'];
			    $mime = $attachFile2['type'];
			    $originFileName = $attachFile2['name'];
			    $ext = strtolower(end(explode('.', $originFileName))); 
			    $saveFileName = $this->uuidgen() . "." . $ext;
			    
				if (!in_array($ext, $allowFileExtArray)) {
					$jsonResult['status'] = 400;
					$jsonResult['data'] = null;
					echo json_encode($jsonResult); 
					exit;
				}
				
				$fileUrl = $this->s3->s3Upload($filepath, $saveFileName, $mime);
				$this->bossboardattachfile_model->insertBossAttachFile($bossBoardId, $originFileName, $fileUrl);
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
	    if (LOGIN_LEVEL < 2) {
	        alert("접근 권한이 없습니다.");
	        exit;
	    }
	    
	    $bossBoardId = $this->input->post("bossBoardId");
	    
	    $resultDeleteBossBoard = $this->bossboard_model->deleteBossBoard($bossBoardId);
	    
	    if ($resultDeleteBossBoard > 0) {
	    	$resultItemPrice = $this->bossboarditem_model->getBossBoardItemSumByBossBoardId($bossBoardId);
	    	$groupTaxPercent = $this->tax_model->getTax(2);
	    	$pay = $resultItemPrice * -1;
// 	    	$pay = floor($resultItemPrice * ((100 - $groupTaxPercent) / 100)) * -1;
	    	$this->payment_model->updatePayment($pay, LOGIN_ID);
	    	
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
