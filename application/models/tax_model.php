<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tax_model extends CI_Model {
	
	function __construct() {
		parent::__construct ();
	}
	
	function getTax($type) {
	    $sql = "
			SELECT
				percent
			FROM
				tax
	    	WHERE
	    		type = ?
		";
	    
	    $resultQuery = $this->db->query($sql, array($type))->row_array();
	    
	    return $resultQuery['percent'];
	}
	
	function updateTax($percent, $type) {
	    $sql = "
    		UPDATE
    			tax
    		SET
    			percent = ?
	    	WHERE
	    		type = ?
	   ";
	    
	    $resultQuery = $this->db->query($sql, array($percent, $type));
	    
	    return $this->db->affected_rows();
	}
	
}