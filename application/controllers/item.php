<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item extends CI_Controller {
	
	function __construct() {
		parent::__construct();
	
		$this->load->model('itemlist_model');
		
		$this->load->helper('header_footer_helper');
		$this->load->helper('alert_helper');
		$this->load->helper('location_helper');
	}
	
	public function index() {
	    common_header();
	    
	    $itemList = $this->itemlist_model->getList(2);
	    
	    $data = array(
	        "itemList" => $itemList,
	    );
	    
	    $this->load->view("item/list.view.php", $data);
	    
	    common_footer();
	}
	
	public function updateItemModal_ajax() {
        $itemId = $this->input->get("itemId");
        
        $itemDetail = $this->itemlist_model->getItemDetailById($itemId);
	    $data = array(
	        "itemDetail" => $itemDetail,
	    );
	    
	    $this->load->view("item/modal/update.modal.view.php", $data);
	}
	
	public function updateItem_ajax() {
	    $itemId = $this->input->post("itemId");
	    $itemName = $this->input->post("itemName");
	    $itemLevel = $this->input->post("itemLevel");
	    $itemPrice = $this->input->post("itemPrice");
	    
	    $resultUpdate = $this->itemlist_model->updateItem($itemName, $itemPrice, $itemLevel, $itemId);
	    
	    if ($resultUpdate > 0) {
	        $jsonResult['status'] = 200;
	        $jsonResult['data'] = $resultUpdate;
	    } else {
	        $jsonResult['status'] = 404;
	        $jsonResult['data'] = $resultUpdate;
	    }
	    
	    echo json_encode($jsonResult);
	}
}
