<?php
require_once $ROOT_PATH . '../src/Config/rmcDBconfig.php';

class CourseDataAccess{
    private $TABLE_NAME = "COURSE";
    private $conn = null;
    private $ID;           

    // constructor with $db as database connection
    public function __construct(){
        $db = new Database();
        $this->conn = $db->connect();
        // date_default_timezone_set('America/Los_Angeles');
    }

    private function getID($id){
        return (string)$id;
    }
//****************************************************************************************

    public function readCourseBy ($id) {
        // SQL statements
        if ( $id ) {
            $query = "SELECT * FROM ".$this->TABLE_NAME." WHERE cID=" . $id ;
        } else {
            $query = "SELECT * FROM ".$this->TABLE_NAME." ";
        }
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $count = $stmt->rowCount();

        // check if more than 0 record found
        if($count>0){
            $course_arr = array();
            $course_arr[$this->TABLE_NAME]=array();

            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row);

                $items=array(
                    "cID"		=> $cID,
                    "creditNum"	=> $creditNum,
                    "diff"		=> $diff,
                    "RecLv" 	=> $RecLv,
                    "category"	=> $category,
                    "cDesc"     => $cDesc,
                    "cName"	    => $cName
                );
                array_push($course_arr[$this->TABLE_NAME], $items);
            }
            return json_encode($course_arr);

        } else {
            echo json_encode( array("message" => "No " . $id . " found.") );
        }
    }



//****************************************************************************************

    public function createCourse($data) {
        // $getMaxIdQuery = ""
        $query = "INSERT INTO 
                    " . $this->TABLE_NAME . " 
                SET
                    cID=:cID,
                    creditNum=:creditNum,
                    diff=:diff,
                    RecLv=:RecLv, 
                    category=:category, 
                    cDesc=:cDesc, 
                    cName=:cName
                ";

        if($stmt = $this->conn->prepare($query)){
            $stmt->bindParam(":cID", $this->getID("null"));
            $stmt->bindParam(":creditNum",  $data->creditNum);
            $stmt->bindParam(":diff",  $data->diff);
            $stmt->bindParam(":RecLv",  $data->RecLv);
            $stmt->bindParam(":category",  $data->category);
            $stmt->bindParam(":cDesc", $data->cDesc);
            $stmt->bindParam(":cName",  $data->cName);

            if($stmt->execute()){
                return true;
            }
        }
        return false;
    }

//****************************************************************************************

    public function updateCourse($data) {

        $query = "UPDATE 
                    " . $this->TABLE_NAME . " 
                SET
                    creditNum=:creditNum,
                    diff=:diff,
                    RecLv=:RecLv, 
                    category=:category, 
                    cDesc=:cDesc, 
                    cName=:cName
                WHERE
                    cID = :cID"; 

        if ($stmt = $this->conn->prepare($query)) {
            $stmt->bindParam(":cID", $this->getID("null"));
            $stmt->bindParam(":creditNum",  $data->creditNum);
            $stmt->bindParam(":diff",  $data->diff);
            $stmt->bindParam(":RecLv",  $data->RecLv);
            $stmt->bindParam(":category",  $data->category);
            $stmt->bindParam(":cDesc", $data->cDesc);
            $stmt->bindParam(":cName",  $data->cName);

            if($stmt->execute()){
                return true;
            }
            $stmt->close();
        }
        return false;

    }

//****************************************************************************************

    public function deleteCourse($data) {
        $query = "DELETE FROM 
                    " . $this->TABLE_NAME . " 
                WHERE cID = :cID";

        if ($stmt = $this->conn->prepare($query)) {

            $stmt->bindParam(":cID",  $this->getID($data->ID));
            
            if($stmt->execute()){

                return true;
            }
            $stmt->close();
        }
        return false;
    }


};

?>
