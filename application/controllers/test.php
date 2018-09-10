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
		
		$this->load->library('s3');
	}
	
	public function index() {
	    $filepath = "./uploads/abc.jpg";
	    $saveFileName = "aaaaa.jpg";
	    $mime = "image/jpeg";
	    
	    $fileUrl = $this->s3->s3Upload($filepath, $saveFileName, $mime);
	    
	    echo $fileUrl;
	}
	
	public function ckeditorFileUpload() {
		$fileInfo = $_FILES['upload'];
		$funcNum = $_GET['CKEditorFuncNum'];
		
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
