<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bossboarditem_model extends CI_Model {
	
	function __construct() {
		parent::__construct ();
	}
	
	function getList() {
	    $sql = "
			SELECT
				bi.id,
				bi.bossBoardId,
				bi.itemId,
				bi.itemPrice,
				bi.buyerMemberId,
				m.nickname AS buyerMemberNickname,
                il.name AS itemName
			FROM
				bossBoardItem bi
                INNER JOIN itemList il ON (bi.itemId = il.id)
                LEFT JOIN member m ON (m.id = bi.buyerMemberId)
		";
	    
	    $resultQuery = $this->db->query($sql)->result_array();
	    
	    return $resultQuery;
	}
	
	function getBossItemListbyBossBoardId($bossBoardId){
	    $sql = "
			SELECT
				bi.id,
				bi.bossBoardId,
				bi.itemId,
				bi.itemPrice,
				bi.buyerMemberId,
				m.nickname AS buyerMemberNickname,
                il.name AS itemName,
                il.level AS itemLevel,
                (CASE 
            		WHEN il.level = 1 THEN '#000000'
            		WHEN il.level = 2 THEN '#1783b1'
                    WHEN il.level = 3 THEN '#e60000'
                    WHEN il.level = 4 THEN '#c841d9'
                END) AS itemLevelColor
			FROM
				bossBoardItem bi
                INNER JOIN itemList il ON (bi.itemId = il.id)
                LEFT join member m ON (m.id = bi.buyerMemberId)
			WHERE
				bi.bossBoardId = ?
		";
	    
	    $resultQuery = $this->db->query($sql, array($bossBoardId))->result_array();
	    
	    return $resultQuery;
	}
	
	function insertBossBoardItem($bossBoardId, $itemId, $itemPrice, $buyerMemberId){
	    $sql = "
			INSERT INTO
				bossBoardItem
			SET
				bossBoardId = ?,
				itemId =?,
				itemPrice = ?,
				buyerMemberId = ?
		";
	    
	    $resultQuery = $this->db->query($sql, array($bossBoardId, $itemId, $itemPrice, $buyerMemberId));
	    
	    return $this->db->insert_id();
	}
	
	function updateBossBoardItem($itemId, $itemPrice, $buyerMemberId, $id){
	    $sql = "
			UPDATE
				bossBoardItem
			SET
				itemId = ?,
				itemPrice = ?,
				buyerMemberId = ?
			WHERE
				id = ?
		";
	    
	    $resultQuery = $this->db->query($sql, array($itemId, $itemPrice, $buyerMemberId, $id));
	    
	    return $this->db->affected_rows();
	}
	
	function deleteBossBoardItemByBossBoardId($bossBoardId){
	    $sql = "
			DELETE FROM
				bossBoardItem
			WHERE
				bossBoardId = ?
		";
	    
	    $resultQuery = $this->db->query($sql, array($bossBoardId));
	    
	    return $this->db->affected_rows();
	}
}