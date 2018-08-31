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
				bi.buyerMemberNickname,
                il.name AS itemName
			FROM
				bossBoardItem bi
                INNER JOIN itemList il ON (bi.itemId = il.id)
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
				bi.buyerMemberNickname,
                il.name AS itemName
			FROM
				bossBoardItem bi
                INNER JOIN itemList il ON (bi.itemId = il.id)
			WHERE
				bi.bossBoardId = ?
		";
	    
	    $resultQuery = $this->db->query($sql, array($bossBoardId))->result_array();
	    
	    return $resultQuery;
	}
	
	function insertBossBoardItem($bossBoardId, $itemId, $itemPrice, $buyerMemberId, $buyerMemberNickname){
	    $sql = "
			INSERT INTO
				bossBoardItem
			SET
				bossBoardId = ?,
				itemId =?,
				itemPrice = ?,
				buyerMemberId = ?,
				buyerMemberNickname = ?
		";
	    
	    $resultQuery = $this->db->query($sql, array($bossBoardId, $itemId, $itemPrice, $buyerMemberId, $buyerMemberNickname));
	    
	    return $this->db->insert_id();
	}
	
	function updateBossBoardItem($itemId, $itemPrice, $buyerMemberId, $buyerMemberNickname, $id){
	    $sql = "
			UPDATE
				bossBoardItem
			SET
				itemId = ?,
				itemPrice = ?,
				buyerMemberId = ?,
				buyerMemberNickname = ?
			WHERE
				id = ?
		";
	    
	    $resultQuery = $this->db->query($sql, array($itemId, $itemPrice, $buyerMemberId, $buyerMemberNickname, $id));
	    
	    return $this->db->affected_rows();
	}
	
	function deleteBossBoardItemByBossBoardId($id){
	    $sql = "
			DELETE FROM
				bossBoardItem
			WHERE
				bossBoardId = ?
		";
	    
	    $resultQuery = $this->db->query($sql, array($id));
	    
	    return $this->db->affected_rows();
	}
}