
<?php 
	require_once 'config.php';

	$mysqli = connect();

	$postdata = file_get_contents("php://input");

	if (isset($postdata) && !empty($postdata)){
		$request = json_decode($postdata);
		if ($request->action === 'question'){
			$cId = $request->cId;

			$sql = "SELECT Q.*, U.uEmail 
					FROM QUESTION AS Q, USER AS U
					WHERE Q.courseID ='$cId'
					AND Q.userID = U.uID
					ORDER BY Q.qID DESC";

			if($result = mysqli_query($mysqli, $sql)){
				$count = mysqli_num_rows($result);

				$question = array();
				
				$n = 0;

				while($row = mysqli_fetch_assoc($result)){
					$question[$n]['qId'] = $row['qID'];
					$question[$n]['qText'] = $row['question'];
					$question[$n]['qTime'] = $row['qTime'];
					$question[$n]['qCid'] = $row['courseID'];
					$question[$n]['qUid'] = $row['userID'];
					$question[$n]['qUser'] = $row['uEmail'];
					$question[$n]['answer'] = loadAnswer($mysqli,$row['qID']);
					$n++;
				}
				mysqli_free_result($result);

				$json = json_encode($question);
				echo $json;
			} else {
				echo 0;
			}
		} 
	}

	function loadAnswer($mysqli , $qId){
		$sql = "SELECT A.*, U.uEmail
				FROM ANSWER As A, USER AS U
				WHERE quesID = '$qId'
				AND A.userID = U.uID
				ORDER BY A.aID DESC";

		if($result = mysqli_query($mysqli, $sql)){
			$count = mysqli_num_rows($result);

			$answer = array();
			$n = 0;

			while($row = mysqli_fetch_assoc($result)){
				$answer[$n]['aId'] = $row['aID'];
				$answer[$n]['aText'] = $row['answer'];
				$answer[$n]['aTime'] = $row['aTime'];
				$answer[$n]['aUid'] = $row['userID'];
				$answer[$n]['aQid'] = $row['quesID'];
				$answer[$n]['aUser'] = $row['uEmail'];
				$n++;
			} 
			mysqli_free_result($result);
            header('Content-type:application/json;charset=utf-8');
			$json = json_encode($answer);

		} else {
			echo 0;
		}

		return $json;
	}

	mysqli_close($mysqli);
 ?>


