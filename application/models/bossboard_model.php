<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bossboard_model extends CI_Model {
	
	function __construct() {
		parent::__construct ();
		
		$this->load->model('bossboarditem_model');
	}
	
	function getBossBoardList($offset, $limit, $serachType, $s) {
	    $resultBossBoardList = $this->getList($offset, $limit, $serachType, $s);
	    
	    foreach ($resultBossBoardList as $key => $value) {
	        $id = $value['id'];
	        $resultBossItemList = $this->bossboarditem_model->getBossItemListbyBossBoardId($id);
	        $resultBossBoardList[$key]['itemList'] = $resultBossItemList;
	    }
	    
	    return $resultBossBoardList;
	}
	
	function getList($offset, $limit, $serachType, $s) {
		$paramArray = array();
		
		$whereClause = "";
		if ($serachType == 1 && $s != "") {
			$whereClause .= "AND m.nickname LIKE ?";
	        $paramArray[] = "%$s%";
		} else if ($serachType == 2 && $s != "") {
			$whereClause .= "AND bs.name LIKE ?";
			$paramArray[] = "%$s%";
		} else if ($serachType == 3 && $s != "") {
			$whereClause .= "AND il.name LIKE ?";
			$paramArray[] = "%$s%";
		} else if ($serachType == 4 && $s != "") {
			$whereClause .= "AND DATE_FORMAT(b.killDateTime, '%Y-%m-%d') = ?";
			$paramArray[] = $s;
		}
		
	    $sql = "
			SELECT
				b.id,
				b.writerId,
				m.nickname AS writerNickname,
				b.killDateTime,
				b.bossId,
                bs.name AS bossName,
				b.etc,
				b.createdDateTime,
				b.updatedDateTime,
                (SELECT COUNT(bp.id) FROM bossBoardParticipant bp WHERE bp.bossBoardId = b.id) AS participantCount,
                (SELECT SUM(bp.dividend) FROM bossBoardParticipant bp WHERE bossBoardId = b.id AND isFinish = 'N') AS dividend,
                il.name AS itemName
			FROM
				bossBoard b
				LEFT JOIN member m ON (b.writerId = m.id)
                LEFT JOIN boss bs ON (b.bossId = bs.id)
                LEFT JOIN bossBoardItem bi ON (bi.bossBoardId = b.id)
				LEFT JOIN itemList il ON (bi.itemId = il.id)
    		WHERE
				1=1
				$whereClause
            GROUP BY
                b.id
			ORDER BY
				b.id DESC
	    	LIMIT 
	    		?, ?
		";
	    
	    $paramArray[] = $offset;
	    $paramArray[] = $limit;
	    $resultQuery = $this->db->query($sql, $paramArray)->result_array();
	    
	    return $resultQuery;
	}
	
	function countBossBoardList($serachType, $s) {
		$paramArray = array();
		
		$whereClause = "";
		if ($serachType == 1 && $s != "") {
			$whereClause .= "AND m.nickname LIKE ?";
			$paramArray[] = "%$s%";
		} else if ($serachType == 2 && $s != "") {
			$whereClause .= "AND bs.name LIKE ?";
			$paramArray[] = "%$s%";
		} else if ($serachType == 3 && $s != "") {
			$whereClause .= "AND il.name LIKE ?";
			$paramArray[] = "%$s%";
		} else if ($serachType == 4 && $s != "") {
			$whereClause .= "AND DATE_FORMAT(b.killDateTime, '%Y-%m-%d') = ?";
			$paramArray[] = $s;
		}
		
		$sql = "
			SELECT
				COUNT(DISTINCT b.id) as count
			FROM
				bossBoard b
				LEFT JOIN member m ON (b.writerId = m.id)
                LEFT JOIN boss bs ON (b.bossId = bs.id)
                LEFT JOIN bossBoardItem bi ON (bi.bossBoardId = b.id)
				LEFT JOIN itemList il ON (bi.itemId = il.id)
			WHERE
				1=1
				$whereClause
		";
		 
		$resultQuery = $this->db->query($sql, $paramArray)->row_array();
		 
		return $resultQuery['count'];
	}
	
	function getDetail($id){
	    $sql = "
			SELECT
				b.id,
				b.writerId,
				b.writerNickname,
				b.killDateTime,
				b.bossId,
                bs.name AS bossName,
				b.etc,
				b.createdDateTime,
				b.updatedDateTime
			FROM
				bossBoard b
                LEFT JOIN boss bs ON (b.bossId = bs.id)
			WHERE
				b.id = ?
		";
	    
	    $resultQuery = $this->db->query($sql, array($id))->row_array();
	    
	    return $resultQuery;
	}
	
	function insertBossBoard($writerId, $writerNickname, $killDateTime, $bossId, $etc){
	    $sql = "
			INSERT INTO
				bossBoard
			SET
				writerId = ?,
				writerNickname = ?,
				killDateTime = ?,
				bossId = ?,
				etc = ?,
				createdDateTime = now(),
				updatedDateTime = now()
		";
	    
	    $resultQuery = $this->db->query($sql, array($writerId, $writerNickname, $killDateTime, $bossId, $etc));
	    
	    return $this->db->insert_id();
	}
	
	function updateBossBoard($killDateTime, $bossId, $etc, $id){
	    $sql = "
			UPDATE
				bossBoard
			SET
				killDateTime = ?,
				bossId = ?,
				etc = ?,
				updatedDateTime = now()
			WHERE
				id = ?
		";
	    
	    $resultQuery = $this->db->query($sql, array($killDateTime, $bossId, $etc, $id));
	    
	    return $this->db->affected_rows();
	}
	
	function deleteBossBoard($id){
	    $sql = "
			DELETE FROM
				bossBoard
			WHERE
				id = ?
		";
	    
	    $resultQuery = $this->db->query($sql, array($id));
	    
	    return $this->db->affected_rows();
	}
}