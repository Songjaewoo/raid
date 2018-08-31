<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bossboard_model extends CI_Model {
	
	function __construct() {
		parent::__construct ();
		
		$this->load->model('bossboarditem_model');
	}
	
	function getBossBoardList() {
	    $resultBossBoardList = $this->getList();
	    
	    foreach ($resultBossBoardList as $key => $value) {
	        $id = $value['id'];
	        $resultBossItemList = $this->bossboarditem_model->getBossItemListbyBossBoardId($id);
	        $resultBossBoardList[$key]['itemList'] = $resultBossItemList;
	    }
	    
	    return $resultBossBoardList;
	}
	
	function getList() {
	    $sql = "
			SELECT
				b.id,
				b.writerId,
				b.writerNickname,
				b.killDateTime,
				b.bossName,
				b.etc,
				b.createdDateTime,
				b.updatedDateTime,
                (SELECT COUNT(bp.id) FROM bossBoardParticipant bp WHERE bp.bossBoardId = b.id) AS participantCount,
                (SELECT SUM(bp.dividend) FROM bossBoardParticipant bp WHERE bossBoardId = b.id AND isFinish = 'N') AS dividend
			FROM
				bossBoard b
			ORDER BY
				killDateTime DESC
		";
	    
	    $resultQuery = $this->db->query($sql)->result_array();
	    
	    return $resultQuery;
	}
	
	function getDetail($id){
	    $sql = "
			SELECT
				id,
				writerId,
				writerNickname,
				killDateTime,
				bossName,
				etc,
				createdDateTime,
				updatedDateTime
			FROM
				bossBoard
			WHERE
				id = ?
		";
	    
	    $resultQuery = $this->db->query($sql, array($id))->row_array();
	    
	    return $resultQuery;
	}
	
	function insertBossBoard($writerId, $writerNickname, $killDateTime, $bossName, $etc){
	    $sql = "
			INSERT INTO
				bossBoard
			SET
				writerId = ?,
				writerNickname = ?,
				killDateTime = ?,
				bossName = ?,
				etc = ?,
				createdDateTime = now(),
				updatedDateTime = now()
		";
	    
	    $resultQuery = $this->db->query($sql, array($writerId, $writerNickname, $killDateTime, $bossName, $etc));
	    
	    return $this->db->insert_id();
	}
	
	function updateBossBoard($killDateTime, $bossName, $etc, $id){
	    $sql = "
			UPDATE
				bossBoard
			SET
				killDateTime = ?,
				bossName = ?,
				etc = ?,
				updatedDateTime = now()
			WHERE
				id = ?
		";
	    
	    $resultQuery = $this->db->query($sql, array($killDateTime, $bossName, $etc, $id));
	    
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