<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bossboardattachfile_model extends CI_Model {
	
	function __construct() {
		parent::__construct ();
	}

	function getList(){
	    $sql = "
			SELECT
				id,
				bossBoardId,
				originFileName,
				fileUrl,
				createdDate
			FROM
				bossBoardAttachFile
		";
	    
	    $resultQuery = $this->db->query($sql)->result_array();
	    
	    return $resultQuery;
	}
	
	function getDetailListByBossBoardId($bossBoardId){
	    $sql = "
			SELECT
				id,
				bossBoardId,
				originFileName,
				fileUrl,
				createdDate
			FROM
				bossBoardAttachFile
			WHERE
				bossBoardId = ?
		";
	    
	    $resultQuery = $this->db->query($sql, array($bossBoardId))->result_array();
	    
	    return $resultQuery;
	}
	
	function insertBossAttachFile($bossBoardId, $originFileName, $fileUrl){
	    $sql = "
			INSERT INTO
				bossBoardAttachFile
			SET
				bossBoardId = ?,
				originFileName = ?,
				fileUrl = ?,
				createdDate = now()
		";
	    
	    $resultQuery = $this->db->query($sql, array($bossBoardId, $originFileName, $fileUrl));
	    
	    return $this->db->insert_id();
	}
	
	function updateBossAttachFile($originFileName, $fileUrl, $id){
	    $sql = "
			UPDATE
				bossBoardAttachFile
			SET
				originFileName = ?,
				fileUrl = ?
			WHERE
				id = ?
		";
	    
	    $resultQuery = $this->db->query($sql, array($originFileName, $fileUrl, $id));
	    
	    return $this->db->affected_rows();
	}
	
	function deleteBossAttachFile($id){
	    $sql = "
			DELETE FROM
				bossBoardAttachFile
			WHERE
				id = ?
		";
	    
	    $resultQuery = $this->db->query($sql, array($id));
	    
	    return $this->db->affected_rows();
	}
}