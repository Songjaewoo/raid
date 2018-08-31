<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tax_model extends CI_Model {
	
	function __construct() {
		parent::__construct ();
	}
	
	function getTax() {
	    $sql = "
			SELECT
				percent
			FROM
				tax
		";
	    
	    $resultQuery = $this->db->query($sql)->row_array();
	    
	    return $resultQuery['percent'];
	}
	
	function updateTax($percent) {
	    $sql = "
    		UPDATE
    			tax
    		SET
    			percent = ?
	   ";
	    
	    $resultQuery = $this->db->query($sql, array($percent));
	    
	    return $this->db->affected_rows();
	}
	
}