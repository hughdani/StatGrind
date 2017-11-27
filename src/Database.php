<?php
class Database
{
    const LOGIN_FAIL = -1;
    const LOGIN_DNE = -2;

    private $host = "thatbitcoinguy.com";
    private $user = "root";
    private $pass = "iKCC2YFyUxr7qBhk";
    private $db = "CSCC01";

    private $mysqli;

    public function __construct()
    {
        $this->mysqli = new mysqli($this->host, $this->user, $this->pass, $this->db);
    }

    public function __destruct()
    {
        $this->mysqli->close();
    }

    public function &getconn()
    {
        return $this->mysqli;
    }

    public function query($query)
    {
        return $this->mysqli->query($query);
    }

    public function login($username, $password)
    {
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = $this->query($sql);
        $row = $result->fetch_assoc();
        if ($result->num_rows == 0) {
            return self::LOGIN_DNE;
        } elseif (strcmp($row['password'], $password) != 0) {
            return self::LOGIN_FAIL;
        } else {
            return $row;
        }
    }
    
    public function pagePermission($page_file, $user)
    {
        $account_type = $user->getAccountType();
        $sql = "";
        $sql = $sql . "SELECT COUNT(*) AS permission ";
        $sql = $sql . "FROM pages INNER JOIN permissions ON pages.page_id = permissions.page_id ";
        $sql = $sql . "WHERE permissions.account_type=$account_type ";
        $sql = $sql . "AND pages.filename='$page_file'";
        $result = $this->query($sql)->fetch_assoc();
        return $result['permission'];
    }

    // Function that gets account type code from ID
    function getAccountType($id){
        $sql = "SELECT account_type FROM users WHERE user_id = $id";
	$result = $this->query($sql)->fetch_assoc();
	return $result['account_type'];
    }
    
    // Function that gets assignment title from id
    function getAssignmentTitle($id){
        $sql = "SELECT assignment_id, title FROM assignments WHERE assignment_id = $id";
        $result = $this->query($sql)->fetch_assoc();
        $title = $result['title'];
        if ($title == ""){ $title = "Assignment $id"; }
        return $title;

    }
}
?>