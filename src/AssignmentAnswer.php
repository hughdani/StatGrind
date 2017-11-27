<html>
<head>
    <title>Assignment Answer</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/main.css" />
</head>
<body>
<form method="POST">
    Assignment ID: <input type="text" name="assignment_id"><br>
    <input type="submit" name="submit" value="Search Answer">
</form>

<form action="index.php" method="post">
    <input type="submit" class="btn btn-default" value="Return Home">
</form>

<?php
	function GetAssignment(){
		$servername = "localhost";
		$username = "root";
		$password = "R0binson";
		$dbname = "CSCC01";

		// get assignment ID
		$assignment_id = $_POST['assignment_id'];
		echo "<p>Display Assignment $assignment_id</p><br>";
	
		// get filename for question
		$conn = new mysqli($servername, $username, $password, $dbname);
		$sqlquery = "SELECT location FROM in_assignment LEFT JOIN questions ON in_assignment.question_id=questions.question_id WHERE in_assignment.assignment_id = " . $assignment_id;
		$result = mysqli_query($conn, $sqlquery);
		
		if(mysqli_num_rows($result) > 0){
			$qNum = 1;
			// display each questions from their text file location
			while($row = mysqli_fetch_assoc($result)){
				echo "<p>Question $qNum</p>";
				$file = file_get_contents($row['location']);
				$question_text = explode("FORMULA:", $file);
				echo "ANSWER:" . $question_text[1] . "<br><br>";
				$qNum = $qNum + 1;
			}
		}
	}

	if(isset($_POST['submit']))
	{
		GetAssignment();
	}

    ?>
</body>
</html>
