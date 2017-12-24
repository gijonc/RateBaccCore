<!-- listCourse -->


<?php 
	require_once 'config.php';

	$mysqli = connect();

	function getCourseCategory($n){
		$result = '';
		switch ($n) {
			case 'spi':
				$result = "Social Processes and Institutions";
				break;
			case 'l&a':
				$result = "Social Processes and Institutions";
				break;
			case 'wc':
				$result = "Western Culture";
				break;
			case 'dpd':
				$result = "Difference, Power and Discrimination Course";
				break;
			case 'cgi':
				$result = "Contemporary Global Issues";
				break;
			case 'cgi':
				$result = "Contemporary Global Issues";
				break;
			case 'sts':
				$result = "Science, Technology, and Society";
				break;
			case 'ps':
				$result = "Physical Science";
				break;
			case 'cd':
				$result = "Cultural Diversity";
				break;
			case 'bs':
				$result = "Biological Science";
				break;
			default:
				$result = "Unknown";
				break;
		}

		return $result;
	}

	function checkEmptyScore($s){
		$result = $s;
		if(is_null($s)){
			$result = "--";
		}
		return $result;
	}



	$postdata = file_get_contents("php://input");
	if (isset($postdata) && !empty($postdata)){
		$request = json_decode($postdata);
		$cid = $request->id;

		if ($cid == 'all'){	//return all courses
			$sql = "SELECT * FROM COURSE";
		}else{
			$sql = "SELECT * FROM COURSE WHERE cID = '$cid'";
		}

		if($result = mysqli_query($mysqli, $sql)){
			$count = mysqli_num_rows($result);

			$course = array();
			$n = 0;

			while($row = mysqli_fetch_assoc($result)){
				$textMatch = '';
				$numMatch = 0;
				preg_match('/[^\d]+/', $row['cID'], $textMatch);
				preg_match('/\d+/', $row['cID'], $numMatch);

				$course[$n]['c_num'] = $numMatch[0];

				$textMatch = strtoupper($textMatch[0]);
				$course[$n]['c_code'] = $textMatch;

				$course[$n]['name'] = $row['cName'];
				$course[$n]['credit'] = checkEmptyScore($row['creditNum']);
				$course[$n]['diff'] = checkEmptyScore($row['diff']);
				$course[$n]['recLv'] = checkEmptyScore($row['RecLv']);
				$course[$n]['category'] = getCourseCategory($row['category']);	//TODO: switch to full name
				$course[$n]['desc'] = $row['cDesc'];
				$course[$n]['id'] = $row['cID'];
				$n++;
			}
			mysqli_free_result($result);
		}
	}

	$json = json_encode($course);
	echo $json;

	mysqli_close($mysqli);

 ?>