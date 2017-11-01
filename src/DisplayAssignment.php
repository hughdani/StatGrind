<html>
<head>
<title> View Assignment </title>
</head>
<body>
	<form method="POST">
		Assignment ID: <input type="text" name="AssignmentID"><br>
		<input type="submit" name="submit" value="Submit">
	</form>
<?php
	function GetAssignment(){
		$servername = "localhost";
		$username = "root";
		$password = "R0binson";
		$dbname = "CSCC01";

		// get assignment ID
		$assignmentID = $_POST['AssignmentID'];
		echo "<p>Display Assignment $assignmentID</p><br>";
	
		// get filename for question
		$conn = new mysqli($servername, $username, $password, $dbname);
		$sqlquery = "SELECT * FROM questions WHERE assignment_id = " . $assignmentID;
		$result = mysqli_query($conn, $sqlquery);
		
		if(mysqli_num_rows($result) > 0){
			$qNum = 1;
			// display each questions from their text file location
			while($row = mysqli_fetch_assoc($result)){
				echo "<p>Question $qNum</p><br>";
				$file = file_get_contents($row['location']);
				$questionText = explode("ANSWER:", $file);
				echo $questionText[0] . "<br><br>";
				echo "ANSWER:" . $questionText[1];
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
