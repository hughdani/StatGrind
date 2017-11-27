<html>
<head>
    <title>Select Assignment</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/main.css" />
</head>
<body>

<div class="container-fluid">

	<div class="jumbotron">
		<h1>Available Assignments</h1>
	</div>
<?php

include 'Database.php';
$db = new Database();

// Get user_id
if (isset($_POST['student_id'])) {
	$student_id = $_POST['student_id'];
}
?>
Find assignment:
<form action="ChooseAssignment.php" method="post">
	<input type="text" name="search_param" id="search_param" placeholder="Search for Assignments">
	<input type="submit" value ="Search">
</form>
<?php
// Select all assignments where the end date hasn't passed
$mysqli = new mysqli("localhost", "root", "R0binson", "CSCC01");
$sql = "SELECT assignment_id, end_date FROM assignments WHERE end_date > NOW() AND start_date <= NOW() AND visibility=true";

//Apply search params if any
if (isset($_POST['search_param'])) {
	$sql = $sql . "AND tag LIKE '%".$_POST['search_param']."%' OR title LIKE '%".$_POST['search_param']."%'";
}

$assignments = $mysqli->query($sql);
// Loop through and display each assignment
while ($row = $assignments->fetch_assoc()) {
	$assignment_id = $row["assignment_id"];
	$assignment_title = $db->getAssignmentTitle($assignment_id);
	$end_date = $row["end_date"];
	echo "<h2>$assignment_title </h2><br>";
	// Get previous attempt mark
	$sql = "SELECT result FROM results WHERE student_id = '$student_id' AND assignment_id = $assignment_id ORDER BY attempt_id DESC";
	$result = $mysqli->query($sql);
	$attempts = $result->num_rows;
	if ($attempts > 0){
		$mark = $result->fetch_assoc()["result"];
	} else {
		$mark = "N/A";
	}
	echo "Available until : " . $end_date . "<br>";
	echo "Last Attempt: " . $mark . "%<br>";
	echo "<form action='WriteAssignment.php' method='post'>";
	echo "<input type='hidden' name='assignment_id' id='assignment_id' value='$assignment_id'>";
	echo "<input type='hidden' name='student_id' id='student_id' value='$student_id'>";
	echo "<input type='submit' value ='Write This Assignment'>";
        echo "</form><br>";
	
}
$mysqli->close();

?>



</div>
</body>
</html>
