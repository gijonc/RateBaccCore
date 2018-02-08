

<?php
    require_once 'config.php';
    
    $mysqli = connect();
    
    $postdata = file_get_contents("php://input");

    date_default_timezone_set('America/Los_Angeles');
    $cur_time = date("Y-m-d");


    if(isset($postdata) && !empty($postdata)){
        $request = json_decode($postdata);

        $sql = "INSERT INTO COMMENT (cmDiff, cmRecLv, cmText, cmInst, cmTermTook, cmYearTook, userID, courseID, cmTime) VALUES (?,?,?,?,?,?,?,?,?)";
        if($stmt = $mysqli->prepare($sql)){

            $stmt->bind_param("sssssssss", $cmDiff, $cmRecLv, $cmText, $cmInst, $cmTermTook, $cmYearTook, $userID, $courseID, $cmTime);

            $cmDiff = $request->diff;
            $cmRecLv = $request->reclv;
            $cmText = $request->text;
            $cmInst = $request->instructor;
            $cmTermTook = $request->term;
            $cmYearTook = $request->year;
            $userID = $request->userId;
            $courseID = $request->courseId;
            $cmTime = $cur_time;

            if($stmt->execute()){
                echo 1;
            }else{
                echo 0;
            }
            $stmt->close();
        }else{
            die("Failed to insert");
        }
    }
    mysqli_close($mysqli);
    
?>
