<?php
    require_once 'config.php';
    
    $mysqli = connect();
    
    $ENCRYPT = 0;
    $postdata = file_get_contents("php://input");
    if(isset($postdata) && !empty($postdata)){
        $request = json_decode($postdata);
        $lgemail = $request->username;
        $lgpswd	= $request->password;
        if ($ENCRYPT)
            $lgpswd = hash('sha512', $lgpswd);

        $sql = "SELECT uID,uEmail,uType,signup_t FROM USER WHERE uEmail = '$lgemail' AND uPswd = '$lgpswd'";

        if($result = mysqli_query($mysqli, $sql)){
            if($r = mysqli_fetch_assoc($result)){
                header('Content-type:application/json;charset=utf-8');
                echo json_encode($r);
            } else {
                echo 0;
            }
        }
        mysqli_free_result($result);

    }

    /* close connection */
    mysqli_close($mysqli);
?>
