<?php 
//GROUP MODEL
function getList(){
	$sql = "
		SELECT
			id,
			name
		FROM
			groupName
	";

	$resultQuery = $this->db->query($sql)->result_array();
	
	return $resultQuery;
}

function insertGroup($name){
	$sql = "
		INSERT INTO
			groupName
		SET
			name = ?
	";

	$resultQuery = $this->db->query($sql, array($name));

	return $this->db->insert_id();
}

function updateGroup($id, $name){
	$sql = "
		UPDATE
			groupName
		SET
			name = ?
		WHERE
			id = ?
	";

	$resultQuery = $this->db->query($sql, array($name, $id));

	return $this->db->affected_rows();
}

function deleteGroup($id){
	$sql = "
		DELETE FROM
			groupName
		WHERE
			id = ?
	";

	$resultQuery = $this->db->query($sql, array($id));

	return $this->db->affected_rows();
}






//BOSS MODEL
function getList(){
	$sql = "
			SELECT
				id,
				name,
				killDateTime,
				genTime,
				ADDTIME(killDateTime, genTime) as nextTime
			FROM
				boss
			ORDER BY
				nextTime ASC
		";

	$resultQuery = $this->db->query($sql)->result_array();

	return $resultQuery;
}

function getBossNameList(){
	$sql = "
			SELECT
				id,
				name
			FROM
				boss
			ORDER BY
				name ASC
		";

	$resultQuery = $this->db->query($sql)->result_array();

	return $resultQuery;
}

function updateKillDateTime($id){
	$sql = "
			UPDATE
				boss
			SET
				killDateTime = now()
			WHERE
				id = ?
		";

	$resultQuery = $this->db->query($sql, array($id));

	return $this->db->affected_rows();
}

function updateKillPass($id){
	$sql = "
			UPDATE
				boss
			SET
				killDateTime = ADDTIME(killDateTime, genTime)
			WHERE
				id = ?
		";

	$resultQuery = $this->db->query($sql, array($id));

	return $this->db->affected_rows();
}

function updateDirectDateTime($id, $dateTime){
	$sql = "
			UPDATE
				boss
			SET
				killDateTime = ?
			WHERE
				id = ?
		";

	$resultQuery = $this->db->query($sql, array($dateTime, $id));

	return $this->db->affected_rows();
}

//BOSS BOARD
function getList(){
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
				b.bossManageName,
				(SELECT GROUP_CONCAT(bt.itemName SEPARATOR ', ') FROM bossBoardItem bt WHERE bt.bossBoardId = b.id) AS itemName
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
				updatedDateTime,
				bossManageName
			FROM
				bossBoard
			WHERE
				id = ?
		";

	$resultQuery = $this->db->query($sql, array($id))->row_array();

	return $resultQuery;
}

function insertBossBoard($writerId, $writerNickname, $killDateTime, $bossName, $etc, $bossManageName){
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
				updatedDateTime = now(),
				bossManageName = ?
		";

	$resultQuery = $this->db->query($sql, array($writerId, $writerNickname, $killDateTime, $bossName, $etc, $bossManageName));

	return $this->db->insert_id();
}

function updateBossBoard($killDateTime, $bossName, $etc, $bossManageName, $id){
	$sql = "
			UPDATE
				bossBoard
			SET
				killDateTime = ?,
				bossName = ?,
				etc = ?,
				updatedDateTime = now(),
				bossManageName = ?
			WHERE
				id = ?
		";

	$resultQuery = $this->db->query($sql, array($killDateTime, $bossName, $etc, $bossManageName, $id));

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


//BOSS ATTACH FILE
function getList(){
	$sql = "
			SELECT
				id,
				bossBoardId,
				originFileName,
				fileUrl,
				createdDate
			FROM
				bossBoardAttachFile
		";

	$resultQuery = $this->db->query($sql)->result_array();

	return $resultQuery;
}

function getDetailListByBossBoardId($bossBoardId){
	$sql = "
			SELECT
				id,
				bossBoardId,
				originFileName,
				fileUrl,
				createdDate
			FROM
				bossBoardAttachFile
			WHERE
				bossBoardId = ?
		";

	$resultQuery = $this->db->query($sql, array($bossBoardId))->result_array();

	return $resultQuery;
}

function insertBossAttachFile($bossBoardId, $originFileName, $fileUrl){
	$sql = "
			INSERT INTO
				bossBoardAttachFile
			SET
				bossBoardId = ?,
				originFileName = ?,
				fileUrl = ?,
				createdDate = now()
		";

	$resultQuery = $this->db->query($sql, array($bossBoardId, $originFileName, $fileUrl));

	return $this->db->insert_id();
}

function updateBossAttachFile($originFileName, $fileUrl, $id){
	$sql = "
			UPDATE
				bossBoardAttachFile
			SET
				originFileName = ?,
				fileUrl = ?
			WHERE
				id = ?
		";

	$resultQuery = $this->db->query($sql, array($originFileName, $fileUrl, $id));

	return $this->db->affected_rows();
}

function deleteBossAttachFile($id){
	$sql = "
			DELETE FROM
				bossBoardAttachFile
			WHERE
				id = ?
		";

	$resultQuery = $this->db->query($sql, array($id));

	return $this->db->affected_rows();
}

//BOASS BOARD ITEM
function getList(){
	$sql = "
			SELECT
				id,
				bossBoardId,
				itemId,
				itemName,
				itemPrice,
				buyerMemberId,
				buyerMemberNickname
			FROM
				bossBoardItem
		";

	$resultQuery = $this->db->query($sql)->result_array();

	return $resultQuery;
}

function getDetailbyBossBoardId($bossBoardId){
	$sql = "
			SELECT
				id,
				bossBoardId,
				itemId,
				itemName,
				itemPrice,
				buyerMemberId,
				buyerMemberNickname
			FROM
				bossBoardItem
			WHERE
				bossBoardId = ?
		";

	$resultQuery = $this->db->query($sql, array($bossBoardId))->result_array();

	return $resultQuery;
}

function insertBossBoardItem($bossBoardId, $itemId, $itemName, $itemPrice, $buyerMemberId, $buyerMemberNickname){
	$sql = "
			INSERT INTO
				bossBoardItem
			SET
				bossBoardId = ?,
				itemId =?,
				itemName = ?,
				itemPrice = ?,
				buyerMemberId = ?,
				buyerMemberNickname = ?
		";

	$resultQuery = $this->db->query($sql, array($bossBoardId, $itemId, $itemName, $itemPrice, $buyerMemberId, $buyerMemberNickname));

	return $this->db->insert_id();
}

function updateBossBoardItem($itemId, $itemName, $itemPrice, $buyerMemberId, $buyerMemberNickname, $id){
	$sql = "
			UPDATE
				bossBoardItem
			SET
				itemId = ?,
				itemName = ?,
				itemPrice = ?,
				buyerMemberId = ?,
				buyerMemberNickname = ?
			WHERE
				id = ?
		";

	$resultQuery = $this->db->query($sql, array($itemId, $itemName, $itemPrice, $buyerMemberId, $buyerMemberNickname, $id));

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


//BOSS PARTICIPANT LIST
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


//ITEM LIST
function getList(){
	$sql = "
			SELECT
				id,
				name,
				price,
				level
			FROM
				itemList
		";

	$resultQuery = $this->db->query($sql)->result_array();

	return $resultQuery;
}

function insertItemList($name){
	$sql = "
			INSERT INTO
				itemList
			SET
				name = ?,
				price = ?,
				level = ?
		";

	$resultQuery = $this->db->query($sql, array($name));

	return $this->db->insert_id();
}

function updateItemList($name, $price, $level, $id){
	$sql = "
			UPDATE
				itemList
			SET
				name = ?,
				price = ?,
				level = ?
			WHERE
				id = ?
		";

	$resultQuery = $this->db->query($sql, array($name, $price, $level, $id));

	return $this->db->affected_rows();
}

function deleteItemList($id){
	$sql = "
			DELETE FROM
				itemList
			WHERE
				id = ?
		";

	$resultQuery = $this->db->query($sql, array($id));

	return $this->db->affected_rows();
}


//MEMBER
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
	//1: �Ϲ�, 2:����������, 3:ȸ�����ΰ�����, 99:�ý��۰�����
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


//GET BOSS BOARD DETAIL LOGIC
$transResult = array();
$resultBossBoard = $this->bossBoard_model->getDetail(42);
$transResult = $resultBossBoard;

$resultBossBoardItem = $this->bossBoardItem_model->getDetailbyBossBoardId(42);
$transResult['item'] = $resultBossBoardItem;

$resultBossBoardParticipant = $this->bossBoardParticipant_model->getBoardParticipantByBossBoardId(42);
$transResult['participant'] = $resultBossBoardParticipant;

$resultBossBoardAttachFile = $this->bossBoardAttachFile_model->getDetailListByBossBoardId(42);
$transResult['attachFile'] = $resultBossBoardAttachFile;

$data['transResult'] = $transResult;
?>

<!-- SERVER GET TIME  -->
<div id="serverTime"><?=date("Y-m-d H:i:s", time()); ?></div>

<script>
	var serverDateTime = "<?=date("F d, Y H:i:s", time()); ?>";
	var nowDateTime = new Date(serverDateTime);
	setInterval("serverTime()", 1000);
		
	function serverTime() {
		nowDateTime.setSeconds(nowDateTime.getSeconds()+1);
		var year = nowDateTime.getFullYear();
		var month = leadingZeros(nowDateTime.getMonth() + 1, 2);
		var date = leadingZeros(nowDateTime.getDate(), 2);
		var hours = leadingZeros(nowDateTime.getHours(), 2);
		var minutes = leadingZeros(nowDateTime.getMinutes(), 2);
		var seconds = leadingZeros(nowDateTime.getSeconds(), 2);
			
		$("#serverTime").html(year + "-" + month + "-" + date + " " + hours + ":" + minutes + ":" + seconds);
	}

	function leadingZeros(number, width) {
		number = number + '';
		
		return number.length >= width ? number : new Array(width - number.length + 1).join('0') + number;
	};
</script>
