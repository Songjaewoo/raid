<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment_model extends CI_Model {
	
	function __construct() {
		parent::__construct ();
	}
	
	function getList() {
	    $sql = "
    		SELECT
    			id,
	    		memberId,
	    		pay
    		FROM
    			payment
    	";
	    
	    $resultQuery = $this->db->query($sql)->result_array();
	    
	    return $resultQuery;
	}
	
	function isExistPaymentByMemberId($memberId) {
		$sql = "
    		SELECT
    			id,
	    		memberId,
	    		pay
    		FROM
    			payment
			WHERE
				memberId = ?
    	";
		 
		$resultQuery = $this->db->query($sql, array($memberId))->row_array();
		 
		return $resultQuery;
	}
	
	function insertPayment($memberId, $pay) {
	    $sql = "
    		INSERT INTO
    			payment
    		SET
	    		memberId = ?,
	    		pay = ?
    	";
	    
	    $resultQuery = $this->db->query($sql, array($memberId, $pay));
	    
	    return $this->db->insert_id();
	}
	
	function updatePayment($pay, $memberId) {
	    $sql = "
    		UPDATE
    			payment
    		SET
	    		pay = pay + ?
    		WHERE
    			memberId = ?
    	";
	    
	    $resultQuery = $this->db->query($sql, array($pay, $memberId));
	    
	    return $this->db->affected_rows();
	}
}