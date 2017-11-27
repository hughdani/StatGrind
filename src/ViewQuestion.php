<html>
<head>
<title> View Question </title>
    <link rel="stylesheet" href="css/main.css" />
</head>
<body>
<?php
    require_once 'Database.php';
    $db = new Database();

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
