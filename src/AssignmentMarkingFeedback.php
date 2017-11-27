<html>
<head>
    <title>Assignment Marking Feedback</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/main.css" />
</head>
<body>

<div class="container-fluid">

	<div class="jumbotron">
		<h1>Assignment Marking/Feedback</h1>
	</div>
<?php
<<<<<<< HEAD
=======
	include 'Database.php';
	$db = new Database();

	// Get student_id
	if (isset($_POST['student_id'])) {
		$student_id = $_POST['student_id'];
	} else {
		$student_id = "kozaadam";
	}
>>>>>>> master


/**
 * Update the mark and feedback for the selected student's assignment
 *
 * @param int $new_mark the updated mark for the selected assignment
 * @param int $new_feed_back the updated feedback for the selected assignment
 * @param int $attempt_id the current attempt id for the selected assignment
 */
function update_mark_and_feedback($new_mark, $new_feedback, $attempt_id){
	$mysqli = new mysqli("localhost", "root", "R0binson", "CSCC01");
<<<<<<< HEAD
	$sqlUpdate = "UPDATE results SET result=$new_mark, feedback='$new_feedback' WHERE attempt_id=$attempt_id";
	$mysqli->query($sqlUpdate);
	$mysqli->close();
}
=======
	$sql = "SELECT assignment_id, start_date FROM assignments";
	$result = $mysqli->query($sql);
	// Display open assignments.
	while ($row = $result->fetch_row()) {
		if ($current_time > $row[1]) {
			echo "<h2>".$db->getAssignmentTitle($row[0])."</h2><br>";
			// Select all student attempts for this assignment.
			$sql = "SELECT result, attempt_id, feedback FROM results WHERE student_id = '$student_id' AND assignment_id = $row[0]";
			$result2 = $mysqli->query($sql);
			$attempts = $result2->num_rows;
			$feedback = "";
			$attempt_id = 0;
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
			}
			echo "Mark: " . $mark . "<br>Number of attempts: " . $attempts . "<br>";
			echo "Instructor feedback: " . $feedback . "<br>";

?>
>>>>>>> master

if(isset($_POST['attempt_id'])){
	update_mark_and_feedback($_POST['new_mark'], $_POST['feedback'],$_POST['attempt_id']);
}


/**
 * Display the dropdown for selecting assignment and display the mark/feedback of the selected assignment
 *
 */
function display_mark_and_feedback(){
?>
	<form method='post'>
		View Mark/Feedback for: 
		<select name="select_assignment" onchange="this.form.submit();">
			<option disabled value="" selected hidden>Select Assignment</option>
			<?php 
			// Display open assignments.
			$mysqli = new mysqli("localhost", "root", "R0binson", "CSCC01");
			$sql = "SELECT assignment_id, start_date FROM assignments";
			$result = $mysqli->query($sql);
			while ($row = $result->fetch_assoc()){
				echo "<option value='".$row["assignment_id"]."''> Assignment ". $row["assignment_id"] . "</option>";
			}
			?>
		</select>
	</form>
		<br>
<?php
	if(isset($_POST['select_assignment'])){
		$assignment_id = $_POST['select_assignment'];
		echo "<h2>Assignment $assignment_id</h2><br>";
		// Select all student attempts for this assignment.
		$sql = "SELECT results.student_id, results.assignment_id, results.result, results.feedback, results.attempt_id from (SELECT student_id, assignment_id, max(attempt_id) as 'most_recent' FROM `results` group by student_id, assignment_id) T LEFT JOIN results on most_recent = attempt_id where results.assignment_id = $assignment_id";
		$result = $mysqli->query($sql);
		while($row = $result->fetch_assoc()){ ?>
	<form id="update_result" method='post'>
			<?php
			$student_id = $row['student_id'];
			$feedback = $row['feedback'];
			$mark = $row['result'];
			$attempt_id = $row['attempt_id'];
			echo "Student ID: $student_id <br>";
			?>	
    			<input type="hidden" name="student_id" id="student_id" value="<?php echo $student_id; ?>"/>
    			<input type="hidden" name="attempt_id" id="attempt_id" value="<?php echo $attempt_id; ?>"/>
    			<input type="hidden" name="select_assignment" id="select_assignment" value="<?php echo $assignment_id; ?>"/>
			Mark:
			<input id="new_mark" name="new_mark" type='text' class='form-control' value="<?php echo $mark; ?>">
			Feedback:
  			<textarea id="feedback" name="feedback" type='text' class='form-control' form='update_result' rows='5' ><?php echo $feedback; ?></textarea>
  			<input type="submit" class="btn btn-default" value="Submit Update"/>
    	</form>
<?php
		}
	}
	$mysqli->close();
}

display_mark_and_feedback();

?>

</div>
</body>
</html>
