<html>
<head>
<title> View Question </title>
</head>
<body>
<?php
	// get question ID
	$questionID = $_POST['questionID'];
	
	// get filename for question
	$mysqli = new mysqli("localhost", "root", "R0binson", "CSCC01");
	$result = $mysqli->query("SELECT * FROM questions WHERE question_id = " . $questionID);
	
	// get question text from file
	$file = fopen($result->location, "r") or die("Unable to open file!");
	echo fread($file, filesize($result->location));
	fclose($file);
?>
</body>
</html>
