<html>
<head>
    <title>Assignment Overview</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container-fluid">

	<div class="jumbotron">
		<h1>Assignment Overview</h1>
	</div>
<?php
// Get student_id
if (isset($_POST['student_id'])) {
	$student_id = $_POST['student_id'];
} else {
	$student_id = "kozaadam";
}

// Get current time, convert to 24hr.
$current_time = date("Y-m-d h:i:sa");
$edit_time = explode(" ", $current_time);
$edit_hour = explode(":", $edit_time[1]);
if ($edit_hour[2][2] == "p") {
	$new_hour = $edit_hour[0] + 12;
	$current_time = $edit_time[0] . " " . $new_hour . ":" . $edit_hour[1] . ":" . $edit_hour[2][0] .  $edit_hour[2][1];
} else {
	$current_time = $edit_time[0] . " " . $edit_hour[0] . ":" . $edit_hour[1] . ":" . $edit_hour[2][0] .  $edit_hour[2][1];
}

// Select all assignment from assignment table.
$mysqli = new mysqli("localhost", "root", "R0binson", "CSCC01");
$sql = "SELECT assignment_id, start_date FROM assignments";
$result = $mysqli->query($sql);
// Display open assignments.
while ($row = $result->fetch_row()) {
	if ($current_time > $row[1]) {
		echo "<h2>Assignment $row[0]</h2><br>";
		// Select all student attempts for this assignment.
		$sql = "SELECT result, attempt_id FROM results WHERE student_id = '$student_id' AND assignment_id = $row[0]";
		$result2 = $mysqli->query($sql);
		$attempts = $result2->num_rows;
		// Determine last attempt.
		if ($attempts > 0) {
			$mark = 0;
			$attempt_id = 0;
			while ($row2 = $result2->fetch_row()) {
				if ($row2[1] > $attempt_id) {
					$mark = $row2[0];
					$attempt_id = $row2[1];
				}
			}
		} else {
			$mark = 0;
		}
		echo "Mark: " . $mark . "<br>Number of attempts: " . $attempts . "<br>";
		echo "Instructor feedback: " . "<br>";
	}
	
}

?>



</div>
</body>
</html>