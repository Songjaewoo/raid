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
				b.bossId,
                bs.name AS bossName,
				b.etc,
				b.createdDateTime,
				b.updatedDateTime,
                (SELECT COUNT(bp.id) FROM bossBoardParticipant bp WHERE bp.bossBoardId = b.id) AS participantCount,
                (SELECT SUM(bp.dividend) FROM bossBoardParticipant bp WHERE bossBoardId = b.id AND isFinish = 'N') AS dividend

			FROM
				bossBoard b
                LEFT JOIN boss bs ON (b.bossId = bs.id)
			ORDER BY
				b.killDateTime DESC, b.id DESC
		";
	    
	    $resultQuery = $this->db->query($sql)->result_array();
	    
	    return $resultQuery;
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