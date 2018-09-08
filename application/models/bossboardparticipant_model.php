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
	
	function getDetailDiviend($id) {
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
			WHERE
				bp.id = ?
		";
		 
		$resultQuery = $this->db->query($sql, array($id))->row_array();
		 
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
	    
	    return $resultQuery['dividend'];
	}
	
	function countMemberDiviend($isFinish = "N") {
	    $sql = "
			SELECT
            	COUNT(DISTINCT memberId) AS count
            FROM
            	bossBoardParticipant
            WHERE
            	isFinish = ?
		";
	    
	    $resultQuery = $this->db->query($sql, array($isFinish))->row_array();
	    
	    return $resultQuery['count'];
	}
	
	function getAllDiviend($isFinish = "N") {
	    $sql = "
			SELECT
				IFNULL(SUM(dividend), 0) AS dividend
			FROM
				bossBoardParticipant
			WHERE
				isFinish = ?
		";
	    
	    $resultQuery = $this->db->query($sql, array($isFinish))->row_array();
	    
	    return $resultQuery['dividend'];
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
	
	function updateDividendFinish($id, $isFinish) {
	    $sql = "
			UPDATE
				bossBoardParticipant
			SET
				isFinish = 'Y'
			WHERE
				id = ?
		";
	    
	    $resultQuery = $this->db->query($sql, array($id, $isFinish));
	    
	    return $this->db->affected_rows();
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
	
	function getDividendListWithMember($s = null) {
	    $paramArray = array();
	    $whereClause = "";
	    if ($s != null) {
	        $whereClause = "AND m.nickname LIKE ?";
	        $paramArray[] = "%$s%";
	    }
	    
	    $sql = "
			SELECT 
            	bp.id,
                bp.memberId,
                m.level AS level,
                (CASE 
            		WHEN level = 1 THEN '일반'
            		WHEN level = 2 THEN '보탐'
                    WHEN level = 3 THEN '수호'
                    WHEN level = 4 THEN '군주'
                    WHEN level = 99 THEN '관리자'
                END) AS levelName,
                gn.name AS groupName,
                m.className AS className,
                m.nickname AS nickname,
                SUM(bp.dividend) AS dividend,
                bp.isFinish
            FROM 
            	bossBoardParticipant bp
                INNER JOIN member m ON (m.id = bp.memberId)
                INNER JOIN groupName gn ON (gn.id = m.groupNameId)
            WHERE
            	bp.isFinish = 'N'
                $whereClause
            GROUP BY
            	bp.memberId
            ORDER BY
            	m.nickname ASC
		";
	    
        $resultQuery = $this->db->query($sql, $paramArray)->result_array();
	    
	    return $resultQuery;
	}
	
	function getDividendDetailWithMember($memberId) {
	    $sql = "
			SELECT 
            	bp.id,
                bp.bossBoardId,
                bp.memberId,
                bp.dividend,
                bp.isFinish,
                bb.writerNickName,
                bb.killDateTime,
                bb.bossId,
                b.name AS bossName,
                bb.etc    
            FROM 
            	bossBoardParticipant bp
                INNER JOIN bossBoard bb ON (bb.id = bp.bossBoardId)
                INNER JOIN boss b ON (b.id = bb.bossId)
            WHERE
            	bp.isFinish = 'N'
                AND bp.memberId = ?
            ORDER BY
                bb.killDateTime DESC, bb.id DESC
        ";
                
	    $resultQuery = $this->db->query($sql, array($memberId))->result_array();
        
        return $resultQuery;
	}
}