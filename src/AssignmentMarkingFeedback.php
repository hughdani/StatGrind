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
/**
 * Update the mark and feedback for the selected student's assignment
 *
 * @param int $new_mark the updated mark for the selected assignment
 * @param int $new_feed_back the updated feedback for the selected assignment
 * @param int $attempt_id the current attempt id for the selected assignment
 * @param int $student_id the current selected student
 */
function update_mark_and_feedback($new_mark, $new_feed_back, $attempt_id, $student_id){
	if ($attempt_id != 0){
		$mysqli = new mysqli("localhost", "root", "R0binson", "CSCC01");
		$sqlUpdate = "UPDATE results SET result=$newMark, feedback='$newFeedback' WHERE attempt_id=$attempt_id and student_id=$student_id";
		$mysqli->query($sqlUpdate);
		$mysqli->close();
	}
}

/**
 * Display the dropdown for selecting assignment and display the mark/feedback of the selected assignment
 *
 * @param date $current_time the current time of the search
 * @param int $student_id the current selected student
 */
function display_mark_and_feedback($current_time, $student_id){
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
			while ($row = $result->fetch_row()){
				if ($current_time > $row[1]) {
					echo "<option value='".$row[0]."''> Assignment ". $row[0] . "</option>";
				}
			}
			?>
		</select>
		<br>
<?php
	if(isset($_POST['selectedAssignment'])){
		$assignment_id = $_POST['selectedAssignment'];
		echo "<h2>Assignment $assignment_id</h2><br>";
		// Select all student attempts for this assignment.
		$sql = "SELECT result, attempt_id, feedback FROM results WHERE attempt_id = (SELECT MAX(attempt_id) FROM results WHERE student_id = '$student_id' AND assignment_id = $assignment_id)";
		$result2 = $mysqli->query($sql);
		$row2 = $result2->fetch_row();
		$feedback = $row2[2];
		$attempt_id = $row2[1];
		$mark = $row2[0];
		echo "Mark: " . $mark . "<br>Number of attempts: " . $attempt_id . "<br>";
		echo "Instructor feedback: " . $feedback . "<br>";	
?>	
    	<input type="hidden" name="student_id" id="student_id" value="<?php echo $student_id; ?>"/>
    	<input type="hidden" name="attempt_id" id="attempt_id" value="<?php echo $attempt_id; ?>"/>
		<input id="newmark" name="newmark" type='text' class='form-control' value="<?php echo $mark; ?>">
  		<textarea id="feedback" name="feedback" class='form-control' rows='5'><?php echo $feedback; ?></textarea>
  		<input type="submit" class="btn btn-default" value="Submit Update"/>
    </form>
<?php
	}
	$mysqli->close();
}

	// Get student_id
	if (isset($_POST['student_id'])) {
		$student_id = $_POST['student_id'];
	} else {
		$student_id = "kozaadam";
	}

	if(isset($_POST['attempt_id'])){
		update_mark_and_feedback($_POST['newmark'], $_POST['feedback'],$_POST['attempt_id'], $_POST['student_id']);
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
	display_mark_and_feedback($current_time, $student_id);
?>

</div>
</body>
</html>
