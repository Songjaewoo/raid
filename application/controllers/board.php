<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Board extends CI_Controller {
	
	function __construct(){
		parent::__construct();
	
		$this->load->model('member_model');
		$this->load->model('boss_model');
		$this->load->model('bossboard_model');
		$this->load->model('board_model');
		$this->load->model('boardcomment_model');
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
		
		$category = $this->input->get('category') == null ? 1 : $this->input->get('category');
		$pageNum = $this->input->get('pageNum') == null ? 1 : $this->input->get('pageNum');
		$limit = $this->input->get('limit') == null ? 10 : $this->input->get('limit');
		$offset = ($pageNum - 1) * $limit;
		
		$boardList = $this->board_model->getList($category, $offset, $limit);
		$countBoardList = $this->board_model->countList();
		$pagination = $this->paging_info->getPagingInfo($pageNum, $countBoardList, $limit, 10);
        
		$data = array(
		    "category" => $category,
		    "boardList" => $boardList,
			"pagination" => $pagination,
		);
		
		$this->load->view("board/list.view.php", $data);
		
		common_footer();
	}
	
	public function write() {
		common_header();
	
		$category = $this->input->get('category') == null ? 1 : $this->input->get('category');
	
		$data = array(
			"category" => $category,
		);
	
		$this->load->view("board/write.view.php", $data);
	
		common_footer();
	}
	
	public function write_submit() {
		$writerId = LOGIN_ID;
		$title = $this->input->post("title");
		$content = $this->input->post("editorText");
		$category = $this->input->post('category') == null ? 1 : $this->input->post('category');
		
		if ($writerId > 0 && $title != "" && $content != "" && $category > 0) {
			$result = $this->board_model->insertBoard($writerId, $category, $title, $content);
			if ($result > 0) {
				alert("글 등록 성공.", "/board?category=". $category);
			} else {
				alert("글 등록 실패.");
			}
		} else {
			alert("글 등록 실패.");
		}
	}
	
	public function detail() {
		common_header();
	
		$boardId = $this->input->get('boardId');
		
		if ($boardId > 0) {
			$boardDetail = $this->board_model->getDetail($boardId);
			if ($boardDetail != null) {
				$this->board_model->updateBoardCount($boardId);
				$commentList = $this->boardcomment_model->getList($boardId);
				$category = $boardDetail['category'];
				
				$data = array(
					"boardDetail" => $boardDetail,
					"commentList" => $commentList,
					"category" => $category,
				);
				
				$this->load->view("board/detail.view.php", $data);
			} else {
				alert("글 정보가 없습니다.");				
			}
		} else {
			alert("잘못된 요청 입니다.");
		}
	
		common_footer();
	}
	
	public function edit() {
		common_header();
	
		$boardId = $this->input->get('boardId');
	
		if ($boardId > 0) {
			$boardDetail = $this->board_model->getDetail($boardId);
			$category = $boardDetail['category'];
				
			$data = array(
				"boardDetail" => $boardDetail,
				"category" => $category,
			);
				
			$this->load->view("board/edit.view.php", $data);
				
		} else {
			alert("잘못된 요청 입니다.");
		}
	
		common_footer();
	}
	
	public function edit_submit() {
		$boardId = $this->input->post("boardId");
		$title = $this->input->post("title");
		$content = $this->input->post("editorText");
	
		if ($boardId > 0 && $title != "" && $content != "") {
			$result = $this->board_model->updateBoard($title, $content, $boardId);
			if ($result > 0) {
				alert("글 수정 성공.", "/board/detail?boardId=". $boardId);
			} else {
				alert("글 수정 실패.");
			}
		} else {
			alert("글 수정 실패.");
		}
	}
	
	public function writeComment_ajax() {
		$boardId = $this->input->post("boardId");
		$writerId = LOGIN_ID;
		$content = $this->input->post("comment");
	
		if ($boardId > 0 && $writerId > 0 && $content != "") {
			$result = $this->boardcomment_model->insertComment($boardId, $writerId, $content);
			if ($result > 0) {
				$jsonResult['status'] = 200;
			} else {
				$jsonResult['status'] = 400;
			}
		} else {
			$jsonResult['status'] = 400;
		}
		
		echo json_encode($jsonResult);
	}
	
	public function deleteComment_ajax() {
		$commentId = $this->input->post("commentId");
	
		if ($commentId > 0) {
			$result = $this->boardcomment_model->deleteComment($commentId);
			if ($result > 0) {
				$jsonResult['status'] = 200;
			} else {
				$jsonResult['status'] = 400;
			}
		} else {
			$jsonResult['status'] = 400;
		}
	
		echo json_encode($jsonResult);
	}
	
	public function delete_ajax() {
		$boardId = $this->input->post("boardId");
		 
		$result = $this->board_model->deleteBoard($boardId);
		 
		if ($result > 0) {
			$jsonResult['status'] = 200;
		} else {
			$jsonResult['status'] = 400;
		}
		 
		echo json_encode($jsonResult);
	}
	
	public function ckeditorFileUpload() {
		$fileInfo = $_FILES['upload'];
	
		$allowFileExtArray  = ["gif", "jpg", "jpeg", "png", "bmp"];
		if ($fileInfo['size'] > 0) {
			$filepath = $fileInfo['tmp_name'];
			$mime = $fileInfo['type'];
			$originFileName = $fileInfo['name'];
			$ext = strtolower(end(explode('.', $originFileName)));
			$saveFileName = $this->uuidgen() . "." . $ext;
	
			if (!in_array($ext, $allowFileExtArray)) {
				$jsonResult['filename'] = $saveFileName;
				$jsonResult['uploaded'] = 0;
				$jsonResult['error']['message'] = "허용 가능 확장자 gif, jpg, jpeg, png, bmp";
			} else {
				$fileUrl = $this->s3->s3Upload($filepath, $saveFileName, $mime);
	
				$jsonResult['filename'] = $saveFileName;
				$jsonResult['uploaded'] = 1;
				$jsonResult['url'] = $fileUrl;
			}
	
			echo json_encode($jsonResult);
		}
	}
	
	private function uuidgen() {
		return sprintf('%08x-%04x-%04x-%04x-%04x%08x',
				mt_rand(0, 0xffffffff),
				mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff),
				mt_rand(0, 0xffff), mt_rand(0, 0xffffffff)
		);
	}
}
