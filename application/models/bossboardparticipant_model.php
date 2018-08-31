<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bossboardparticipant_model extends CI_Model {
	
	function __construct() {
		parent::__construct ();
	}
	
	function getList(){
	    $sql = "
			SELECT
				id,
				bossBoardId,
				memberId,
				memberNickname,
				dividend,
				isFinish
			FROM
				bossBoardParticipant
		";
	    
	    $resultQuery = $this->db->query($sql)->result_array();
	    
	    return $resultQuery;
	}
	
	function getBoardParticipantByBossBoardId($bossBoardId){
	    $sql = "
			SELECT
				id,
				bossBoardId,
				memberId,
				memberNickname,
				dividend,
				isFinish
			FROM
				bossBoardParticipant
			WHERE
				bossBoardId = ?
		";
	    
	    $resultQuery = $this->db->query($sql, array($bossBoardId))->result_array();
	    
	    return $resultQuery;
	}
	
	function getMyDiviend($memberId, $isFinish = "N") {
	    $sql = "
			SELECT
				SUM(dividend) AS dividend
			FROM
				bossBoardParticipant
			WHERE
				memberId = ?
				AND isFinish = ?
		";
	    
	    $resultQuery = $this->db->query($sql, array($memberId, $isFinish))->row_array();
	    
	    return $resultQuery;
	}
	
	function insertBossParticipant($bossBoardId, $memberId, $memberNickname, $dividend, $isFinish = "N"){
	    $sql = "
			INSERT INTO
				bossBoardParticipant
			SET
				bossBoardId = ?,
				memberId = ?,
				memberNickname = ?,
				dividend = ?,
				isFinish = ?
		";
	    
	    $resultQuery = $this->db->query($sql, array($bossBoardId, $memberId, $memberNickname, $dividend, $isFinish));
	    
	    return $this->db->insert_id();
	}
	
	function deleteBossParticipantByBossBoardId($bossBoardId){
	    $sql = "
			DELETE FROM
				bossBoardParticipant
			WHERE
				bossBoardId = ?
		";
	    
	    $resultQuery = $this->db->query($sql, array($bossBoardId));
	    
	    return $this->db->affected_rows();
	}
}