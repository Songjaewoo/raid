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
            ORDER BY 
            	fu.createdDateTime DESC
		";
	
		$resultQuery = $this->db->query($sql)->result_array();
		
		return $resultQuery;
	}
	
	function insertFundUse($writerId, $money, $memo) {
	    $sql = "
    		INSERT INTO
    			fundUse
    		SET
                writerId = ?,
                money = ?,
                memo = ?,
                useDate = now(),
                createdDateTime = now()
    	";
	    
	    $resultQuery = $this->db->query($sql, array($writerId, $money, $memo));
	    
	    return $this->db->insert_id();
	}
	
	function getCurrentGroupFund() {
	    $sql = "
			SELECT 
            	(SELECT
            		SUM(bi.itemPrice) as groupMoney
            	FROM
            		bossBoardItem bi
            	WHERE
            		(SELECT
            			COUNT(bp.id)
            		FROM
            			bossBoardParticipant bp
            		WHERE bp.bossBoardId = bi.bossBoardId) = 0)

            	+

                (SELECT 
            		SUM(money) as useMoney 
            	FROM 
            		fundUse) AS remainFund
		";
	    
	    $resultQuery = $this->db->query($sql)->row_array();
	    
	    return $resultQuery['remainFund'];
	}
}