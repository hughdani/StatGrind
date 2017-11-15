<html>
<head>
    <title>Assignment Statistics</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container-fluid">

	<div class="jumbotron">
		<h1>Assignment Statistics</h1>
	</div>

	<div>
		<h2>Average</h2>
		<?php
		// Select all assignment from assignment table.
		$mysqli = new mysqli("localhost", "root", "R0binson", "CSCC01");
		$sql = "SELECT assignment_id FROM assignments";
		$result = $mysqli->query($sql);
		// Display open assignments.
		while ($row = $result->fetch_row()) {			
			echo "<h3>Assignment $row[0]</h3><br>";
			$sql = "SELECT result FROM results WHERE assignment_id = $row[0]";
			$result2 = $mysqli->query($sql);
			$attempts = $result2->num_rows;
			$assignmentTotal = 0;
			// Sum up the total marks for the current assignment
			while ($row2 = $result2->fetch_row()){
				$assignmentTotal += row2[0];
			}

			// Get the number of students in the db, account_type = 2 is for students
			$sql = "SELECT username FROM users WHERE account_type = 2"
			$result3 = $mysqli->query($sql);
			$num_of_students = $result3->num_rows;
			echo "Number of students " . $num_of_students . "<br> Number of attempts " . $attempts . "<br>";
			$average = $assignmentTotal / $num_of_students;
			echo "Assignment average is: " . $average . "<br>";
		}
		?>
	</div>

	<div>
		<h2>Attempts</h2>
		<?php
		/*$sql = "SELECT result, attempt_id, feedback FROM results WHERE student_id = '$student_id' AND assignment_id = $row[0]";
		$result2 = $mysqli->query($sql);
		$attempts = $result2->num_rows;
		*/
		?>
	</div>

	<div>
		<h2>Participitation</h2>
	</div>

</div>
</body>
</html>