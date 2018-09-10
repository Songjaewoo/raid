<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Boardcomment_model extends CI_Model {
	
	function __construct() {
		parent::__construct ();
	}
	
	function getList($boardId){
	    $sql = "
			SELECT 
				bc.id,
			    bc.boardId,
			    bc.writerId,
			    gn.name AS groupName,
			    m.nickname AS nickname,
			    bc.content,
			    bc.createdDateTime,
			    bc.updatedDateTime
			FROM 
				boardComment bc
			    INNER JOIN member m ON (m.id = bc.writerId)
			    INNER JOIN groupName gn ON (gn.id = m.groupNameId)
	    	WHERE
	    		bc.boardId = ?
	    	ORDER BY
	    		bc.id ASC
	    	
		";
	    
	    $resultQuery = $this->db->query($sql, array($boardId))->result_array();
	    
	    return $resultQuery;
	}
	
	function countList($boardId){
	    $sql = "
			SELECT 
				COUNT(bc.id) AS count
			FROM 
				boardComment bc
			    INNER JOIN member m ON (m.id = bc.writerId)
			    INNER JOIN groupName gn ON (gn.id = m.groupNameId)
	    	WHERE
	    		bc.boardId = ?
		";
	    
	    $resultQuery = $this->db->query($sql, array($category))->row_array();
	    
	    return $resultQuery['count'];
	}
	
	function insertComment($boardId, $writerId, $content){
	    $sql = "
			INSERT INTO
				boardComment
			SET
			    boardId = ?,
			    writerId = ?,
			    content = ?,
			    createdDateTime = now()
		";
	    
	    $resultQuery = $this->db->query($sql, array($boardId, $writerId, $content));
	    
	    return $this->db->insert_id();
	}
	
	function deleteComment($id){
	    $sql = "
    		DELETE FROM
    			boardComment
    		WHERE
    			id = ?
    	";
	    
	    $resultQuery = $this->db->query($sql, array($id));
	    
	    return $this->db->affected_rows();
	}
	
}