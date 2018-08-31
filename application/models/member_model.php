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
	
	function getMemberListByGroup($groupNameId = null) {
	    $paramArray = array();
	    $whereClause = "";
	    if ($groupNameId != null) {
	        $whereClause = "AND groupNameId = ?";
	        $paramArray[] = $groupNameId;
	    }
	    
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
				1=1
				$whereClause
			ORDER BY
				nickname ASC
	   ";
				
				$resultQuery = $this->db->query($sql, $paramArray)->result_array();
				
				return $resultQuery;
	}
	
	function insertMember($memberId, $nickname, $password, $groupNameId) {
	    $salt = '$2a$07$R.gJb2U2N.FmZ4hPp1y2CN$';
	    $encryptPassword = crypt($password, $salt);
	    
	    $sql = "
			INSERT INTO
				member
			SET
				memberId = ?,
				nickname = ?,
				password = ?,
				createdDateTime = now(),
				updatedDateTime = now(),
				level = 1,
				approval = 0,
				groupNameId = ?
		";
	    
	    $resultQuery = $this->db->query($sql, array($memberId, $nickname, $encryptPassword, $groupNameId));
	    
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
	
	function updateMemberBaseInfo($nickname, $groupNameId, $id) {
	    $sql = "
			UPDATE
				member
			SET
				nickname = ?,
				updatedDateTime = now(),
				groupNameId = ?
			WHERE
				id = ?
		";
	    
	    $resultQuery = $this->db->query($sql, array($nickname, $groupNameId, id));
	    
	    return $this->db->affected_rows();
	}
	
	function updateMemberPassword($password, $id) {
	    $salt = '$2a$07$R.gJb2U2N.FmZ4hPp1y2CN$';
	    $encryptPassword = crypt($password, $salt);
	    
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
	    $salt = '$2a$07$R.gJb2U2N.FmZ4hPp1y2CN$';
	    $encryptPassword = crypt($password, $salt);
	    
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