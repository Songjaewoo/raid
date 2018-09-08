<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Funduse_model extends CI_Model {
	
	function __construct() {
		parent::__construct ();
	}
	
	function getList() {
		$sql = "
			SELECT 
            	fu.id,
                fu.writerId,
                gn.name AS groupName,
                m.nickname AS memberNickname,
                fu.money,
                fu.memo,
                fu.useDate,
                fu.createdDateTime
            FROM 
            	fundUse fu
                LEFT JOIN member m ON (fu.writerId = m.id)
                LEFT JOIN groupName gn ON (gn.id = m.groupNameId)
            WHERE
                fu.display = 'Y'
            ORDER BY 
            	fu.createdDateTime DESC
		";
	
		$resultQuery = $this->db->query($sql)->result_array();
		
		return $resultQuery;
	}
	
	function insertFundUse($writerId, $money, $memo, $display = "Y", $type = 1) {
	    $sql = "
    		INSERT INTO
    			fundUse
    		SET
                writerId = ?,
                money = ?,
                memo = ?,
                display = ?,
                type = ?,
                useDate = now(),
                createdDateTime = now()
    	";
	    
	    $resultQuery = $this->db->query($sql, array($writerId, $money, $memo, $display, $type));
	    
	    return $this->db->insert_id();
	}
	
	function getCurrentGroupFund() {
	    $sql = "
			SELECT 
            	IFNULL(SUM(money), 0) AS remainFund 
            FROM 
            	fundUse
		";
	    
	    $resultQuery = $this->db->query($sql)->row_array();
	    
	    return $resultQuery['remainFund'];
	}
	
	function deleteFundUse($id){
	    $sql = "
    		DELETE FROM
    			fundUse
    		WHERE
    			id = ?
    	";
	    
	    $resultQuery = $this->db->query($sql, array($id));
	    
	    return $this->db->affected_rows();
	}
}