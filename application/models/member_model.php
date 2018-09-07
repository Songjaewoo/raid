<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member_model extends CI_Model {
	
	function __construct() {
		parent::__construct ();
	}
	
	function getMemberDetailByMemberId($memberId) {
	    $sql = "
			SELECT
				m.id,
				m.memberId,
				m.nickname,
				m.password,
				m.createdDateTime,
				m.updatedDateTime,
				m.level,
				m.approval,
				m.groupNameId,
				g.name AS groupName
			FROM
				member m
				INNER JOIN groupName g ON (m.groupNameId = g.id)
			WHERE
				memberId = ?
		";
	    
	    $resultQuery = $this->db->query($sql, array($memberId))->row_array();
	    
	    return $resultQuery;
	}
	
	function getMemberDetailById($id) {
	    $sql = "
			SELECT
				m.id,
				m.memberId,
				m.nickname,
				m.password,
				m.createdDateTime,
				m.updatedDateTime,
				m.level,
                (CASE 
            		WHEN m.level = 1 THEN '일반'
            		WHEN m.level = 2 THEN '보탐'
            		WHEN m.level = 3 THEN '수호'
            		WHEN m.level = 4 THEN '군주'
            		WHEN m.level = 99 THEN '관리자'
            	END) AS levelName,
                m.className,
				m.approval,
				m.groupNameId,
				g.name AS groupName
			FROM
				member m
				INNER JOIN groupName g ON (m.groupNameId = g.id)
			WHERE
				m.id = ?
		";
	    
	    $resultQuery = $this->db->query($sql, array($id))->row_array();
	    
	    return $resultQuery;
	}
	
	function isExistMemberId($memberId) {
		$sql = "
			SELECT
				m.memberId
			FROM
				member m
			WHERE
				memberId = ?
		";
		 
		$resultQuery = $this->db->query($sql, array($memberId))->row_array();
		 
		return $resultQuery;
	}
	
	function isExistMemberNickname($nickname) {
		$sql = "
			SELECT
				m.nickname
			FROM
				member m
			WHERE
				nickname = ?
		";
			
		$resultQuery = $this->db->query($sql, array($nickname))->row_array();
			
		return $resultQuery;
	}
	
	function getMemberListByLevel($level) {
	    $sql = "
			SELECT
				m.id,
				m.memberId,
				m.nickname,
				m.createdDateTime,
				m.updatedDateTime,
				m.level,
				m.approval,
				m.groupNameId,
				g.name AS groupName
			FROM
				member m
				INNER JOIN groupName g ON (m.groupNameId = g.id)
			WHERE
				level = ?
		";
	    
	    $resultQuery = $this->db->query($sql, array($level))->result_array();
	    
	    return $resultQuery;
	}
	
	function getMemberList($groupNameId = null, $level = null, 
                           $className = null, $approval = null,
                           $nickname = null) {
	    
	    $paramArray = array();
	    $whereClause = "";
	    if ($groupNameId != null) {
	        $whereClause .= "AND m.groupNameId = ?";
	        $paramArray[] = $groupNameId;
	    }
	    
	    if ($level != null) {
	        $whereClause .= "AND m.level = ?";
	        $paramArray[] = $level;
	    }
	    
	    if ($className != null) {
	        $whereClause .= "AND m.className = ?";
	        $paramArray[] = $className;
	    }
	    
	    if ($approval != "") {
	        $whereClause .= "AND m.approval = ?";
	        $paramArray[] = $approval;
	    }
	    
	    if ($nickname != null) {
	        $whereClause .= "AND m.nickname = ?";
	        $paramArray[] = "%$nickname%";
	    }
	    
	    $sql = "
			SELECT
            	m.id,
            	m.memberId,
            	m.nickname,
            	m.password,
            	m.createdDateTime,
            	m.updatedDateTime,
            	m.level,
                (CASE 
            		WHEN m.level = 1 THEN '일반'
            		WHEN m.level = 2 THEN '보탐'
            		WHEN m.level = 3 THEN '수호'
            		WHEN m.level = 4 THEN '군주'
            		WHEN m.level = 99 THEN '관리자'
            	END) AS levelName,
                m.className,
            	m.approval,
            	m.groupNameId,
            	g.name AS groupName
            FROM
            	member m
            	INNER JOIN groupName g ON (m.groupNameId = g.id)
			WHERE
				1=1
				$whereClause
			ORDER BY
				g.id ASC, m.nickname ASC
	   ";

		$resultQuery = $this->db->query($sql, $paramArray)->result_array();
		
		return $resultQuery;
	}
	
	function insertMember($memberId, $nickname, $className, $password, $groupNameId) {
	    $encryptPassword = password_hash($password, PASSWORD_BCRYPT);
	    
	    $sql = "
			INSERT INTO
				member
			SET
				memberId = ?,
				nickname = ?,
	    		className = ?,
				password = ?,
				createdDateTime = now(),
				updatedDateTime = now(),
				level = 1,
				approval = 0,
				groupNameId = ?
		";
	    
	    $resultQuery = $this->db->query($sql, array($memberId, $nickname, $className, $encryptPassword, $groupNameId));
	    
	    return $this->db->insert_id();
	}
	
	function updateMemberApproval($approval, $id) {
	    $sql = "
			UPDATE
				member
			SET
				approval = ?
			WHERE
				id = ?
		";
	    
	    $resultQuery = $this->db->query($sql, array($approval, $id));
	    
	    return $this->db->affected_rows();
	}
	
	function updateMemberBaseInfo($nickname, $className, $level, $groupNameId, $id) {
	    $sql = "
			UPDATE
				member
			SET
				nickname = ?,
                className = ?,
                level = ?,
				groupNameId = ?,
				updatedDateTime = now()
			WHERE
				id = ?
		";
	    
	    $resultQuery = $this->db->query($sql, array($nickname, $className, $level, $groupNameId, $id));
	    
	    return $this->db->affected_rows();
	}
	
	function updateMemberPassword($password, $id) {
	    $encryptPassword = password_hash($password, PASSWORD_BCRYPT);
	    
	    $sql = "
			UPDATE
				member
			SET
				password = ?,
				updatedDateTime = now()
			WHERE
				id = ?
		";
	    
	    $resultQuery = $this->db->query($sql, array($encryptPassword, $id));
	    
	    return $this->db->affected_rows();
	}
	
	function updateMemberLevel($level, $id) {
	    $sql = "
			UPDATE
				member
			SET
				updatedDateTime = now(),
				level = 1
			WHERE
				id = ?
		";
	    
	    $resultQuery = $this->db->query($sql, array($level, $id));
	    
	    return $this->db->affected_rows();
	}
	
	function deleteMember($id){
	    $sql = "
			DELETE FROM
				member
			WHERE
				id = ?
		";
	    
	    $resultQuery = $this->db->query($sql, array($id));
	    
	    return $this->db->affected_rows();
	}
}