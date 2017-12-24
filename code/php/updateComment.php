
<!-- UpdateComment -->



<?php
    require_once 'config.php';
    
    $mysqli = connect();
    
    $postdata = file_get_contents("php://input");

    date_default_timezone_set('America/Los_Angeles');
    $cur_time = date("Y-m-d");


    if(isset($postdata) && !empty($postdata)){
        $request = json_decode($postdata);
        $commentId = $request->comment_id;

        if($request->action == 'delete'){

            $sql = "DELETE FROM COMMENT WHERE cmID = '$commentId'";
            if ($mysqli->query($sql) === TRUE) {
                echo 1;
            } else {
                echo "Error deleting record: " . $conn->error;
            }

        } else if ($request->action == 'edit'){
            $term = $request->term;
            $year = $request->year;
            $instructor = $request->instructor;
            $reclv = $request->reclv;
            $diff = $request->diff;
            $text = $request->text;

            $sql = "UPDATE COMMENT SET cmDiff = '$diff', cmRecLv = '$reclv',cmText = '$text', cmInst = '$instructor', cmTermTook = '$term', cmYearTook = '$year', cmTime = '$cur_time' WHERE cmID = '$commentId'";
            
        	if ($mysqli->query($sql) === TRUE) {
                echo 1;
            } else {
                echo "Error updating record: " . $conn->error;
            }
        }
    }
?>