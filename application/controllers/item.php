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
}
