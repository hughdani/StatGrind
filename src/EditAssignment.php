<?php
 	require_once 'Database.php';
	require_once 'User.php';
	require_once 'Utils.php';
	$db = new Database();

	if (!isset($_SESSION)) {
  		session_start();
	}
	if (!isset($_SESSION['user'])) {
	    header("Location: error.php?error_status=401");
	    exit();
	} elseif (!$db->pagePermission(basename(__FILE__), $_SESSION['user'])) {
	    header("Location: error.php?error_status=403");
	    exit();
	}
$mysqli = $db->getconn();

$user = $_SESSION['user'];
create_head('Edit Assignment');

// If editing existing assignment, get id and title
if (isset($_POST['assignment_id'])) {
	$assignment_id = $_POST['assignment_id'];
} else {
	$assignment_id = 1;
}

if (isset($_POST['course_id'])) {
    $course_id = $_POST['course_id'];
} else {
    $course_id = 1;
}

// Get assignment title if defined
if (isset($_POST['assignment_title'])){
	$assignment_title = $_POST['assignment_title'];
} else {
	$assignment_title = "";
}

// Get assignment tags if any
if (isset($_POST['assignment_tag'])) {
	$assignment_tag = $_POST['assignment_tag'];
} else {
	$assignment_tag = "";
}

// Insert new assignment into assignments table and and select the new assignment_id
if (isset($_POST['starttime']))
{
	$start = $_POST['starttime'];
	$end = $_POST['endtime'];
	$sql = "INSERT INTO assignments (start_date, end_date, tag, course_id, title) VALUES (STR_TO_DATE('$start', '%m/%d/%Y %h:%i %p'), STR_TO_DATE('$end', '%m/%d/%Y %h:%i %p'), '$assignment_tag', $course_id, '$assignment_title')";
	$mysqli->query($sql);
	$assignment_id = $mysqli->insert_id;
}

// Save new question to questions table
if (isset($_POST['question_text']))
{

	$dir = 'questions';

 	// create new directory with 744 permissions if it does not exist yet
 	// owner will be the user/group the PHP script is run under
 	if ( !file_exists($dir) ) {
     		$oldmask = umask(0);
     		mkdir ($dir, 0744);
 	}

	// Increment question number for file name.
	$fi = new FilesystemIterator($dir, FilesystemIterator::SKIP_DOTS);
	$file_name = "/question" . (iterator_count($fi) + 1) . ".txt";

	// Append answer to question.
	$qanda = $_POST['question_text'] . "<br> FORMULA: " . $_POST['question_formula'];

	// Save question to file.
	$location = $dir . $file_name;
	file_put_contents($location, $qanda); // saves the string in the textarea into the file

	// Insert question into question table
	$assignment_id = $_POST['assignment_id'];
	$sql = "INSERT INTO questions (location) VALUES ('$location')";
	$mysqli->query($sql);

	$new_question_id = $mysqli->insert_id;

	$sql = "INSERT INTO in_assignment (assignment_id, question_id) VALUES ($assignment_id, $new_question_id)";
	$mysqli->query($sql);
}

// if question was selected, save that question
if (isset($_POST['question_id']))
{
	// Insert question into question table
	$question_id = $_POST['question_id'];
	$assignment_id = $_POST['assignment_id'];
	$sql = "INSERT INTO in_assignment (assignment_id, question_id) VALUES ($assignment_id, $question_id)";
	$mysqli->query($sql);
	
}

// if a number of random questions was selected, save those questions.
if (isset($_POST['num_questions']))
{
	for ($i = 1; $i <= $_POST['num_questions']; $i++) {
		$sql = "SELECT question_id FROM questions";
		
		// Apply filter if any
		if (isset($_POST['question_tag'])){
			$filter = $_POST['question_tag'];
			$sql = $sql . " WHERE tag LIKE '%$filter%'";
		}
		
       	$result = $mysqli->query($sql);
		for ($j = 1; $j <= rand(1, $result->num_rows); $j++){
			$row = $result->fetch_assoc();
		}
		$question_id = $row["question_id"];
		$insertsql = "INSERT INTO in_assignment (assignment_id, question_id) 
				VALUES ($assignment_id, $question_id)";
		$mysqli->query($insertsql);
	}
}

// if question was removed, remove that question
if (isset($_POST['map_id']))
{
	// Insert question into question table
	$map_id = $_POST['map_id'];
	$sql = "DELETE FROM in_assignment WHERE map_id = $map_id";
	$mysqli->query($sql);

}
$assignment_title = $db->getAssignmentTitle($assignment_id);

?>


<body>

<div class="container-fluid">

	<div class="jumbotron">
		<?php if ($assignment_title != ""): ?>
			<h1>Edit <?= $assignment_title; ?></h1>
		<?php else: ?>
			<h1>Edit Assignment <?= $assignment_id; ?></h1>
		<?php endif ?>
	</div>

	<?php
		$i = 1;
		// Grab questions with correct assignment_id.
		$result = $mysqli->query("SELECT in_assignment.question_id, location, map_id FROM in_assignment LEFT JOIN questions ON in_assignment.question_id=questions.question_id WHERE assignment_id = $assignment_id");
		while ($row = $result->fetch_assoc()) {
			echo "<h2>Question $i</h2><br>";
			$filetxt = file_get_contents($row["location"]);
			$q = explode("FORMULA:", $filetxt);
			echo $q[0] . "<br><br>";
			echo "ANSWER: " . $q[1] . "<br>";
			$i = $i + 1;
			?>
			<form action="EditAssignment.php" method="post">
				<input type="hidden" name="assignment_id" id="assignment_id" value="<?= $assignment_id ?>"/>
				<input type="hidden" name="map_id" id="map_id" value="<?= $row["map_id"]; ?>"/>
				<input type="submit" class="btn btn-default" value="Remove Question">
			</form>
			<?php
		}
		echo "<br><br>";
		echo "<h2>Question $i</h2>";
	?>

	<form action="SelectQuestionType.php" method="post">
		<input type="hidden" name="assignment_id" id="assignment_id" value="<?= $assignment_id; ?>"/>
		<input type="submit" class="btn btn-default" value="Create New Question">
	</form>
	<form action="SelectQuestion.php" method="post">
		<input type="hidden" name="assignment_id" id="assignment_id" value="<?= $assignment_id; ?>"/>
		<input type="submit" class="btn btn-default" value="Select Question">
	</form>
	<form action="ConfirmCreateAssignment.php" method="post">
		<input type="hidden" name="assignment_id" id="assignment_id" value="<?= $assignment_id; ?>"/>
		<input type="submit" class="btn btn-default" value="Submit Assignment">
	</form>

</div>
</body>
</html>

