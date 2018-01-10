

<?php 
	require_once 'config.php';

	$mysqli = connect();

	$postdata = file_get_contents("php://input");

	if (isset($postdata) && !empty($postdata)){
		$request = json_decode($postdata);
		$cid = $request->id;

		$sql = "SELECT C.*, U.uEmail 
				FROM COMMENT AS C, USER AS U
				WHERE C.courseID ='$cid'
				AND C.userID = U.uID
				ORDER BY C.cmID DESC";

		if($result = mysqli_query($mysqli, $sql)){
			$count = mysqli_num_rows($result);

			$comment = array();
			$n = 0;

			while($row = mysqli_fetch_assoc($result)){
				$comment[$n]['cmID'] = $row['cmID'];
				$comment[$n]['cmDiff'] = $row['cmDiff'];
				$comment[$n]['cmRecLv'] = $row['cmRecLv'];
				$comment[$n]['cmText'] = $row['cmText'];
				$comment[$n]['cmInst'] = $row['cmInst'];
				$comment[$n]['cmVote'] = $row['cmVote'];
				$comment[$n]['cmTermTook'] = $row['cmTermTook'];
				$comment[$n]['cmYearTook'] = $row['cmYearTook'];
				$comment[$n]['uEmail'] = $row['uEmail'];
				$comment[$n]['uID'] = $row['userID'];
				$comment[$n]['courseID'] = $row['courseID'];
				$comment[$n]['cmTime'] = $row['cmTime'];

				$n++;
			}
			mysqli_free_result($result);
		}
	}
    header('Content-type:application/json;charset=utf-8');
	$json = json_encode($comment);
	echo $json;

	mysqli_close($mysqli);
 ?>


