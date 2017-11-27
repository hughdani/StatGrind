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

require_once 'Database.php';
$db = new Database();
$mysqli = $db->getconn();


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
	$sql = "INSERT INTO results (student_id, assignment_id, result) VALUES ('$student_id', $assignment_id, $result)";
	$mysqli->query($sql);
}

// Get current time, convert to 24hr.
include 'Utils.php';
$current_time = converttime(date("Y-m-d h:i:sa"));

?>

Find assignment:
<form action="AssignmentOverview.php" method="post">
	<input type="text" name="search_param" id="search_param" placeholder="Search for assignments">
	<input type="hidden" name="student_id" id="student_id" <?php if ($student_id){ echo "value=$student_id";} ?>>
	<input type="submit" value ="Search">
</form>

<?php
// Select all assignment from assignment table.
$sql = "SELECT assignment_id, start_date, end_date FROM assignments";

//Apply search params if any
if (isset($_POST['search_param'])) {
	$filter = $_POST['search_param'];
	$sql = $sql . " WHERE tag LIKE '%$filter%' OR title LIKE '%$filter%'";
}

$result = $mysqli->query($sql);
// Display open assignments.
while ($row = $result->fetch_assoc()) {
	$start_date = $row["start_date"];
	$end_date = $row["end_date"];
	$assignment_title = $db->getAssignmentTitle($row["assignment_id"]);
	if ($current_time > $row["start_date"]) {
		echo "<h2>$assignment_title</h2>";
		// Select all student attempts for this assignment.
		$sql = "SELECT result, attempt_id, feedback FROM results WHERE student_id = '$student_id' AND assignment_id = $row['assignment_id']";
		$result2 = $mysqli->query($sql);
		$attempts = $result2->num_rows;
		// Determine last attempt.
		if ($attempts > 0) {
			$mark = 0;
			$attempt_id = 0;
			while ($row2 = $result2->fetch_assoc()) {
				if ($row2["attempt_id"] > $attempt_id) {
					$mark = $row2["result"];
					$attempt_id = $row2["attempt_id"];
					$feedback = $row2["feedback"];
				}
			}
		} else {
			$mark = 0;
			$feedback = "";
		}
		echo "Available from : " . $start_date . " to " . $end_date . "<br>";
		echo "Mark: " . $mark . "<br>Number of attempts: " . $attempts . "<br>";
		echo "Instructor feedback: " . $feedback . "<br><br><br><br>";
	}
	
}

?>

</div>
</body>
</html>
