<?php
class Database {
    private $host = "thatbitcoinguy.com";
    private $user = "root";
    private $pass = "iKCC2YFyUxr7qBhk";
    private $db = "CSCC01";

    private $mysqli;

    function __construct(){
        $this->mysqli = new mysqli($this->host, $this->user, $this->pass, $this->db);
    }

    function __destruct(){
        $this->mysqli->close();
    }

    function &getconn() {
        return $this->mysqli;
    }

    function query($query) {
        return $this->mysqli->query($query);
    }

    /*
    Return integer based on result of credential check:
    Correct user/password: 0
    Account doesn't exist: 1
    Incorrect password: 2
    */
    function login($username, $password) {
        $sql = "SELECT username, password FROM users WHERE username = '$username'";
        $result = $this->query($sql);
        if ($result->num_rows == 0) {
            return 1;
        } else if (strcmp($result->fetch_row() [1], $password) != 0) {
            return 2;
        } else {
            return 0;
        }
    }

    // Function that gets assignment title from id
    function getAssignmentTitle($id){
	global $db;
	$sql = "SELECT assignment_id, title FROM assignments WHERE assignment_id = $id";
	$result = $db->query($sql)->fetch_assoc();
	$title = $result['title'];
	if ($title == ""){ $title = "Assignment $id"; }
	return $title;
    }
}
?>

