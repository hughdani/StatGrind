<?php
require_once 'Database.php';
require_once 'User.php';
require_once 'Utils.php';

$db = new Database();

if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['user'])) {
    header("Location: Forbidden.php");
}

create_head('Assignment Marking/Feedback');

/**
 * Update the mark and feedback for the selected student's assignment
 *
 * @param int $new_mark the updated mark for the selected assignment
 * @param int $new_feed_back the updated feedback for the selected assignment
 * @param int $attempt_id the current attempt id for the selected assignment
 */
function update_mark_and_feedback($new_mark, $new_feedback, $attempt_id){
	global $db;
	$sqlUpdate = "UPDATE results SET result=$new_mark, feedback='$new_feedback' WHERE attempt_id=$attempt_id";
	$db->query($sqlUpdate);
}

if(isset($_POST['attempt_id'])){
	update_mark_and_feedback($_POST['new_mark'], $_POST['feedback'],$_POST['attempt_id']);
}


/**
 * Display the dropdown for selecting assignment and display the mark/feedback of the selected assignment
 *
 */
function display_mark_and_feedback(){
	global $db;
	?>
	<form method='post'>
		View Mark/Feedback for: 
		<select name="select_assignment" onchange="this.form.submit();">
			<option disabled value="" selected hidden>Select Assignment</option>
			<?php 
			// Display open assignments.
			$sql = "SELECT assignment_id, start_date FROM assignments";
			$result = $db->query($sql);
			while ($row = $result->fetch_row()){
				echo "<option value='".$row[0]."''> Assignment ". $row[0] . "</option>";
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
		$result = $db->query($sql);
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
  			<textarea id="feedback" name="feedback" type='text' rows='5' ><?php echo $feedback; ?></textarea>
  			<input type="submit" class="btn btn-default" value="Submit Update"/>
    	</form>
<?php
		}
	}
}

display_mark_and_feedback();

?>

</div>
</body>
</html>
