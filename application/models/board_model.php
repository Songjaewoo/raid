<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Board_model extends CI_Model {
	
	function __construct() {
		parent::__construct ();
	}
	
	function getList($category, $offset, $limit) {
	    $sql = "
			SELECT 
                b.id,
                b.writerId, 
                gn.name AS groupName,
                m.nickname,
                b.category, 
                b.title, 
                b.content, 
                b.createdDateTime, 
                b.updatedDateTime,
                b.count
            FROM 
                board b
                INNER JOIN member m ON (m.id = b.writerId)
                INNER JOIN groupName gn ON (gn.id = m.groupNameId)
            WHERE
                b.category = ?
    		ORDER BY
	    		b.id DESC
            LIMIT 
	    		?, ?
	    	
		";
	    
	    $resultQuery = $this->db->query($sql, array($category, $offset, $limit))->result_array();
	    
	    return $resultQuery;
	}
	
	function countList($category){
	    $sql = "
			SELECT 
                COUNT(b.id) as count
            FROM 
                board b
                INNER JOIN member m ON (m.id = b.writerId)
                INNER JOIN groupName gn ON (gn.id = m.groupNameId)
            WHERE
                b.category = ?
		";
	    
	    $resultQuery = $this->db->query($sql, array($category))->row_array();
	    
	    return $resultQuery['count'];
	}
	
	function getDetail($id){
		$sql = "
			SELECT
                b.id,
                b.writerId,
                gn.name AS groupName,
                m.nickname,
                b.category,
                b.title,
                b.content,
                b.createdDateTime,
                b.updatedDateTime,
                b.count
            FROM
                board b
                INNER JOIN member m ON (m.id = b.writerId)
                INNER JOIN groupName gn ON (gn.id = m.groupNameId)
            WHERE
				b.id = ?
	
		";
		 
		$resultQuery = $this->db->query($sql, array($id))->row_array();
		 
		return $resultQuery;
	}
	
	function insertBoard($writerId, $category, $title, $content){
	    $sql = "
			INSERT INTO
				board
			SET
				writerId = ?,
				category = ?,
                title = ?,
                content = ?,
                createdDateTime = now(),
                count = 0
		";
	    
	    $resultQuery = $this->db->query($sql, array($writerId, $category, $title, $content));
	    
	    return $this->db->insert_id();
	}
	
	function updateBoard($title, $content, $id) {
	    $sql = "
			UPDATE
				board
			SET
                title = ?,
                content = ?,
                updatedDateTime = now()
			WHERE
				id = ?
		";
	    
	    $resultQuery = $this->db->query($sql, array($title, $content, $id));
	    
	    return $this->db->affected_rows();
	}
	
	function updateBoardCount($id) {
	    $sql = "
			UPDATE
				board
			SET
                count = count + 1
			WHERE
				id = ?
		";
	    
	    $resultQuery = $this->db->query($sql, array($id));
	    
	    return $this->db->affected_rows();
	}
	
	function deleteBoard($id){
	    $sql = "
    		DELETE FROM
    			board
    		WHERE
    			id = ?
    	";
	    
	    $resultQuery = $this->db->query($sql, array($id));
	    
	    return $this->db->affected_rows();
	}
	
}