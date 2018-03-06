<?php
class Database{
 
    // specify your own database credentials
    private $host = "127.0.0.1:9000";
    private $username = "root";
    private $password = "roger8169";
    private $db_name = "rmc_db";

    public $mysqli;
 
    // get the database connection
    public function connect(){
        $this->conn = null;
        
        $mysql_conn_str = "mysql:host=$this->host; dbname=$this->db_name";

        $this->conn = new PDO($mysql_conn_str, $this->username, $this->password);
        $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
        return $this->conn;
    }
};

?>
