<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Boss_model extends CI_Model {
	
	function __construct() {
		parent::__construct ();
	}
	
	function getList(){
	    $sql = "
			SELECT
				id,
				name,
				killDateTime,
				genTime,
				ADDTIME(killDateTime, genTime) as nextTime
			FROM
				boss
			ORDER BY
				nextTime ASC
		";
	    
	    $resultQuery = $this->db->query($sql)->result_array();
	    
	    return $resultQuery;
	}
	
	function getBossNameList(){
	    $sql = "
			SELECT
				id,
				name
			FROM
				boss
			ORDER BY
				name ASC
		";
	    
	    $resultQuery = $this->db->query($sql)->result_array();
	    
	    return $resultQuery;
	}
	
	function updateKillDateTime($id){
	    $sql = "
			UPDATE
				boss
			SET
				killDateTime = now()
			WHERE
				id = ?
		";
	    
	    $resultQuery = $this->db->query($sql, array($id));
	    
	    return $this->db->affected_rows();
	}
	
	function updateKillPass($id){
	    $sql = "
			UPDATE
				boss
			SET
				killDateTime = ADDTIME(killDateTime, genTime)
			WHERE
				id = ?
		";
	    
	    $resultQuery = $this->db->query($sql, array($id));
	    
	    return $this->db->affected_rows();
	}
	
	function updateDirectDateTime($id, $dateTime){
	    $sql = "
			UPDATE
				boss
			SET
				killDateTime = ?
			WHERE
				id = ?
		";
	    
	    $resultQuery = $this->db->query($sql, array($dateTime, $id));
	    
	    return $this->db->affected_rows();
	}
}