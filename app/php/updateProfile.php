
<?php
    // connect database
    require 'config.php';
    
    $mysqli = connect();
    
    $postdata = file_get_contents("php://input");

    if(isset($postdata) && !empty($postdata)){
        $request = json_decode($postdata);
        $new_password = $request->password;
        $uid = $request->userID;

        $result = $mysqli->query("SELECT uPswd FROM USER WHERE uID = '$uid'");
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $dup_pswd = $row['uPswd'];
            }
        }

        if($dup_pswd === $new_password) {
            // echo "email exist";
            echo "duplicated";
        } else {
            $sql = "UPDATE USER SET uPswd = '$new_password' WHERE uID = $uid";
            if ($mysqli->query($sql) === TRUE) {
                echo 1;
            } else {
                echo "Error updating password: " . $mysqli->error;
            }
        }
        
	}
?>
