<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Itemlist_model extends CI_Model {
	
	function __construct() {
		parent::__construct ();
	}
	
	function getList($sort = 1) {
	    if ($sort == 1) {
	        $orderby = "sort DESC";
	    } else if ($sort == 2) {
	        $orderby = "sort ASC";
	    } else {
	        $orderby = "sort DESC";
	    }
	    
		$sql = "
			SELECT
				id,
				name,
				price,
				level,
                (CASE 
            		WHEN level = 1 THEN '기타'
            		WHEN level = 2 THEN '희귀'
                    WHEN level = 3 THEN '영웅'
                    WHEN level = 4 THEN '전설'
                END) AS levelName,
                (CASE 
            		WHEN level = 1 THEN '#000000'
            		WHEN level = 2 THEN '#1783b1'
                    WHEN level = 3 THEN '#e60000'
                    WHEN level = 4 THEN '#c841d9'
                END) AS levelColor
			FROM
				itemList
            WHERE
                isUse = 'Y'
            ORDER BY
                $orderby
		";
	
		$resultQuery = $this->db->query($sql)->result_array();
		
		return $resultQuery;
	}
	
	function getItemDetailById($id) {
	    $sql = "
			SELECT
				id,
				name,
				price,
				level,
                (CASE
            		WHEN level = 1 THEN '기타'
            		WHEN level = 2 THEN '희귀'
                    WHEN level = 3 THEN '영웅'
                    WHEN level = 4 THEN '전설'
                END) AS levelName,
                (CASE
            		WHEN level = 1 THEN '#000000'
            		WHEN level = 2 THEN '#1783b1'
                    WHEN level = 3 THEN '#e60000'
                    WHEN level = 4 THEN '#c841d9'
                END) AS levelColor
			FROM
				itemList
            WHERE
                id = ?
		";
                
        $resultQuery = $this->db->query($sql, array($id))->row_array();
        
        return $resultQuery;
	}
	
	function updateItem($name, $price, $level, $id){
	    $sql = "
    		UPDATE
    			itemList
    		SET
    			name = ?,
    			price = ?,
    			level = ?
    		WHERE
    			id = ?
    	";
	    
	    $resultQuery = $this->db->query($sql, array($name, $price, $level, $id));
	    
	    return $this->db->affected_rows();
	}
	
	function updateSortItem($sort, $id){
		$sql = "
    		UPDATE
    			itemList
    		SET
    			sort = ?
    		WHERE
    			id = ?
    	";
		 
		$resultQuery = $this->db->query($sql, array($sort, $id));
		 
		return $this->db->affected_rows();
	}
	
	function updateIsUse($isUse, $id){
	    $sql = "
    		UPDATE
    			itemList
    		SET
    			isUse = ?
    		WHERE
    			id = ?
    	";
	    
	    $resultQuery = $this->db->query($sql, array($isUse, $id));
	    
	    return $this->db->affected_rows();
	}
	
	function insertItem($name, $price, $level){
		$sql = "
    		INSERT INTO
    			itemList
    		SET
				name = ?,
				price = ?,
				level = ?
    	";
		 
		$resultQuery = $this->db->query($sql, array($name, $price, $level));
		 
		return $this->db->insert_id();
	}
}