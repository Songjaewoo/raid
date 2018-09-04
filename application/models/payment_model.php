<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment_model extends CI_Model {
	
	function __construct() {
		parent::__construct ();
	}
	
	function getList() {
	    $sql = "
    		SELECT
    			p.id,
	    		p.memberId,
                gn.name AS groupName,
                m.nickname,
                m.level,
                (CASE 
            		WHEN m.level = 1 THEN '일반'
            		WHEN m.level = 2 THEN '보탐'
            		WHEN m.level = 3 THEN '수호'
            		WHEN m.level = 4 THEN '군주'
            		WHEN m.level = 99 THEN '관리자'
            	END) AS levelName,
                m.className,
	    		p.pay
    		FROM
    			payment p
                INNER JOIN member m ON (p.memberId = m.id)
                INNER JOIN groupName gn ON (gn.id = m.groupNameId)
    	";
	    
	    $resultQuery = $this->db->query($sql)->result_array();
	    
	    return $resultQuery;
	}
	
	function getDetailPayment($id) {
	    $sql = "
    		SELECT
    			p.id,
	    		p.memberId,
                gn.name AS groupName,
                m.nickname,
                m.level,
                (CASE
            		WHEN m.level = 1 THEN '일반'
            		WHEN m.level = 2 THEN '보탐'
            		WHEN m.level = 3 THEN '수호'
            		WHEN m.level = 4 THEN '군주'
            		WHEN m.level = 99 THEN '관리자'
            	END) AS levelName,
                m.className,
	    		p.pay
    		FROM
    			payment p
                INNER JOIN member m ON (p.memberId = m.id)
                INNER JOIN groupName gn ON (gn.id = m.groupNameId)
            WHERE
                p.id = ?
    	";
	    
	    $resultQuery = $this->db->query($sql, array($id))->row_array();
	    
	    return $resultQuery;
	}
	
	function getMyPayment($memberId) {
	    $sql = "
    		SELECT 
                pay 
            FROM 
                payment 
            WHERE 
                memberId = ?
    	";
	    
	    $resultQuery = $this->db->query($sql, array($memberId))->row_array();
	    
	    return $resultQuery['pay'];
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
	
	function getAllPayment() {
	    $sql = "
    		SELECT 
            	IFNULL(SUM(pay), 0) AS pay
            FROM 
            	payment
    	";
	    
	    $resultQuery = $this->db->query($sql)->row_array();
	    
	    return $resultQuery['pay'];
	}
}