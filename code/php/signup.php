
<?php
    require_once 'config.php';
    
    $mysqli = connect();
    
    $ENCRYPT = 0;


    function isValid($str) {
        return !preg_match('/[^A-Za-z0-9.#\\-$]/', $str);
    }


    $postdata = file_get_contents("php://input");

    date_default_timezone_set('America/Los_Angeles');
    $cur_time = date("Y-m-d");

    if(isset($postdata) && !empty($postdata)){
        $request = json_decode($postdata);
        $new_user = $request->email;

        $exist_email = $mysqli->query("SELECT uEmail FROM USER WHERE uEmail = '$new_user'");
        if($exist_email->num_rows != 0) {
            // echo "email exist";
            echo 0;
        }else {

            $sql = "INSERT INTO USER (uEmail, uPswd, signup_t, uType) VALUES (?,?,?,?)";

            if($stmt = $mysqli->prepare($sql)){
                $stmt->bind_param("ssss", $uEmail, $uPswd, $signup_t, $uType);

                $uType = $request->role;
                $uEmail = $request->email;
                $uPswd = $request->password;
                if ($ENCRYPT)
                    $uPswd = hash('sha512', $uPswd);

                $signup_t = $cur_time;

                if($stmt->execute()){
                    $stmt->close();
                    echo 1;
                }else{
                    echo 0;
                }

            }else{
                die("Failed to insert");
            }
        }
    }
    mysqli_close($mysqli);
    
?>
