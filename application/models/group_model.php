<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Group_model extends CI_Model {
	
	function __construct() {
		parent::__construct ();
	}
	
	function getList(){
	    $sql = "
		SELECT
			id,
			name
		FROM
			groupName
	";
	    
	    $resultQuery = $this->db->query($sql)->result_array();
	    
	    return $resultQuery;
	}
	
	function insertGroup($name){
	    $sql = "
		INSERT INTO
			groupName
		SET
			name = ?
	";
	    
	    $resultQuery = $this->db->query($sql, array($name));
	    
	    return $this->db->insert_id();
	}
	
	function updateGroup($id, $name){
	    $sql = "
		UPDATE
			groupName
		SET
			name = ?
		WHERE
			id = ?
	";
	    
	    $resultQuery = $this->db->query($sql, array($name, $id));
	    
	    return $this->db->affected_rows();
	}
	
	function deleteGroup($id){
	    $sql = "
		DELETE FROM
			groupName
		WHERE
			id = ?
	";
	    
	    $resultQuery = $this->db->query($sql, array($id));
	    
	    return $this->db->affected_rows();
	}
}