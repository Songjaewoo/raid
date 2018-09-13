<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bossmemo_model extends CI_Model {
	
	function __construct() {
		parent::__construct ();
	}
	
	function getList() {
	    $sql = "
			SELECT 
                b.id,
                b.writerId, 
                gn.name AS groupName,
                m.nickname,
                b.content, 
                b.createdDateTime
            FROM 
                bossMemo b
                INNER JOIN member m ON (m.id = b.writerId)
                INNER JOIN groupName gn ON (gn.id = m.groupNameId)
    		ORDER BY
	    		b.id DESC
            LIMIT 
	    		0, 1
	    	
		";
	    
	    $resultQuery = $this->db->query($sql)->result_array();
	    
	    return $resultQuery;
	}
	
	function insertBossMemo($writerId, $content){
	    $sql = "
			INSERT INTO
				bossMemo
			SET
				writerId = ?,
                content = ?,
                createdDateTime = now()
		";
	    
	    $resultQuery = $this->db->query($sql, array($writerId, $content));
	    
	    return $this->db->insert_id();
	}
}