<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Itemlist_model extends CI_Model {
	
	function __construct() {
		parent::__construct ();
	}
	
	function getList(){
		$sql = "
			SELECT
				id,
				name,
				price,
				level
			FROM
				itemList
            ORDER BY
                level ASC, name ASC
		";
	
		$resultQuery = $this->db->query($sql)->result_array();
		
		return $resultQuery;
	}
}