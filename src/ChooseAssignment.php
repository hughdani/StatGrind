<html>
<head>
    <title>Select Assignment</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container-fluid">

	<div class="jumbotron">
		<h1>Available Assignments</h1>
	</div>
<?php
// Get user_id
if (isset($_POST['student_id'])) {
	$student_id = $_POST['student_id'];
}
?>
Find assignment:
<form action="ChooseAssignment.php" method="post">
	<input type="text" name="search_param" id="search_param" placeholder="Assignment Group">
	<input type="submit" value ="Search">
</form>
<?php
// Select all assignments where the end date hasn't passed
$mysqli = new mysqli("localhost", "root", "R0binson", "CSCC01");
$sql = "SELECT assignment_id, end_date FROM assignments WHERE end_date > NOW() AND start_date <= NOW()";

//Apply search params if any
if (isset($_POST['search_param'])) {
	$sql = $sql . "AND tag LIKE '%" . $_POST['search_param'] . "%'";
}

$assignments = $mysqli->query($sql);
// Loop through and display each assignment
while ($row = $assignments->fetch_row()) {
	$assignment_id = $row[0];
	$end_date = $row[1];
	echo "<h2>Assignment $assignment_id </h2><br>";
	// Get previous attempt mark
	$sql = "SELECT result FROM results WHERE student_id = '$student_id' AND assignment_id = $assignment_id ORDER BY attempt_id DESC";
	$result = $mysqli->query($sql);
	$attempts = $result->num_rows;
	if ($attempts > 0){
		$mark = $result->fetch_row()[0];
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
