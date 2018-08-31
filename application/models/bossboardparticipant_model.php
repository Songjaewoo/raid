<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bossboardparticipant_model extends CI_Model {
	
	function __construct() {
		parent::__construct ();
	}
	
	function getList(){
	    $sql = "
			SELECT
				bp.id,
				bp.bossBoardId,
				bp.memberId,
				m.nickname AS memberNickname,
				bp.dividend,
				bp.isFinish
			FROM
				bossBoardParticipant bp
                INNER JOIN member m ON (m.id = bp.memberId)
		";
	    
	    $resultQuery = $this->db->query($sql)->result_array();
	    
	    return $resultQuery;
	}
	
	function getBoardParticipantByBossBoardId($bossBoardId){
	    $sql = "
			SELECT
				bp.id,
				bp.bossBoardId,
				bp.memberId,
				m.nickname AS memberNickname,
                gn.name AS groupName,
				bp.dividend,
				bp.isFinish
			FROM
				bossBoardParticipant bp
                INNER JOIN member m ON (m.id = bp.memberId)
                INNER JOIN groupName gn ON (gn.id = m.groupNameId)
			WHERE
				bp.bossBoardId = ?
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
	
	function insertBossParticipant($bossBoardId, $memberId, $dividend, $isFinish = "N"){
	    $sql = "
			INSERT INTO
				bossBoardParticipant
			SET
				bossBoardId = ?,
				memberId = ?,
				dividend = ?,
				isFinish = ?
		";
	    
	    $resultQuery = $this->db->query($sql, array($bossBoardId, $memberId, $dividend, $isFinish));
	    
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