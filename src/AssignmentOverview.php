<html>
<head>
    <title>Assignment Overview</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/main.css" />
</head>
<body>

<div class="container-fluid">

	<div class="jumbotron">
		<h1>Assignment Overview</h1>
	</div>
<?php

include 'Database.php';
$db = new Database();


// Get student_id
if (isset($_POST['student_id'])) {
	$student_id = $_POST['student_id'];
} else {
	$student_id = "kozaadam";
}

	echo "<!-- $student_id -->";
// If comming from ConfirmSubmission page, insert submission into results table
if (isset($_POST['result'])) {
	$result = $_POST['result'];
	$assignment_id = $_POST['assignment_id'];
	$mysqli = new mysqli("localhost", "root", "R0binson", "CSCC01");
	$sql = "INSERT INTO results (student_id, assignment_id, result) VALUES ('$student_id', $assignment_id, $result)";
	$mysqli->query($sql);
	$mysqli->close();
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
?>

Find assignment:
<form action="AssignmentOverview.php" method="post">
	<input type="text" name="search_param" id="search_param" placeholder="Search for assignments">
	<input type="hidden" name="student_id" id="student_id" <?php if ($student_id){ echo "value=$student_id";} ?>>
	<input type="submit" value ="Search">
</form>

<?php
// Select all assignment from assignment table.
$mysqli = new mysqli("localhost", "root", "R0binson", "CSCC01");
$sql = "SELECT assignment_id, start_date, end_date FROM assignments";

//Apply search params if any
if (isset($_POST['search_param'])) {
	$filter = $_POST['search_param'];
	$sql = $sql . " WHERE tag LIKE '%$filter%' OR title LIKE '%$filter%'";
}

$result = $mysqli->query($sql);
// Display open assignments.
while ($row = $result->fetch_row()) {
	$start_date = $row[1];
	$end_date = $row[2];
	$assignment_title = $db->getAssignmentTitle($row[0]);
	if ($current_time > $row[1]) {
		echo "<h2>$assignment_title</h2><br>";
		// Select all student attempts for this assignment.
		$sql = "SELECT result, attempt_id, feedback FROM results WHERE student_id = '$student_id' AND assignment_id = $row[0]";
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
					$feedback = $row2[2];
				}
			}
		} else {
			$mark = 0;
			$feedback = "";
		}
		echo "Available from : " . $start_date . " to " . $end_date . "<br>";
		echo "Mark: " . $mark . "<br>Number of attempts: " . $attempts . "<br>";
		echo "Instructor feedback: " . $feedback . "<br>";
	}
	
}
$mysqli->close();

?>

</div>
</body>
</html>
