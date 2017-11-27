<?php
    require_once 'Database.php';
    require_once 'User.php';
    require_once 'Utils.php';
    $db = new Database();

    if (!isset($_SESSION)) {
        session_start();
    }
    if (!isset($_SESSION['user'])) {
        header("Location: error.php?error_status=401");
        exit();
    } elseif (!$db->pagePermission(basename(__FILE__), $_SESSION['user'])) {
        header("Location: error.php?error_status=403");
        exit();
    }
?>
<html>
<head>
<title> View Question </title>
    <link rel="stylesheet" href="css/main.css" />
</head>
<body>
<?php
	// get question ID
	$questionID = $_POST['questionID'];
	
	// get filename for question
	$result = $db->query("SELECT * FROM questions WHERE question_id = " . $questionID);
	
	// get question text from file
	$file = fopen($result->location, "r") or die("Unable to open file!");
	echo fread($file, filesize($result->location));
	fclose($file);
?>
</body>
</html>
