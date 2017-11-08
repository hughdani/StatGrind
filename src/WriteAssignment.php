<?php 
// Determine assignment_id.
if (isset($_POST['assignment_id']))
{
	$assignment_id = $_POST['assignment_id'];
} else {
	$assignment_id = 1;
}
// Determine student_id.
if (isset($_POST['student_id']))
{
	$student_id = $_POST['student_id'];
} else {
	$student_id = "kozaadam";
}

// If this is not the first question.
if (isset($_POST['questions']))
{
	$i = $_POST['index'];
	$questions = unserialize($_POST['questions']);
	$results = unserialize($_POST['results']);
	// Determine result of last question.
	If ($_POST['user_answer'] == $_POST['right_answer']){
		$results[] = 100;
	} else {
		$results[] = 0;
	}

} else {
	// Get assignment questions
	$i = 0;
	$questions = [];
	$results = [];
	$mysqli = new mysqli("localhost", "root", "R0binson", "CSCC01");
	$result = $mysqli->query("SELECT in_assignment.question_id, location FROM in_assignment LEFT JOIN questions ON in_assignment.question_id=questions.question_id WHERE assignment_id = $assignment_id");
	while ($row = $result->fetch_row()) {
		$questions[] = [$row[0], $row[1]];
	}
	$mysqli->close();
}
?>

<html>
<head>
    <title>Write Assignment <?php echo $assignment_id; ?></title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container-fluid">

	<div class="jumbotron">
		<h1>Write Assignment <?php echo $assignment_id; ?></h1>
	</div>

<?php
// Display question
$qnumb = $i + 1;
echo "<center><h2>Question $qnumb</h2><br>";
$question_file = file_get_contents($questions[$i][1]);
$q = explode("ANSWER:", $question_file);

// Insert variable interpetor.
echo $q[0] . "<br><br>";

// Set correct answer.
$right_answer = "";


// Determine if this is the last question
if ($qnumb == count($questions)) {
?>

	<form action="ConfirmSubmission.php" method="post">
		<label for="user_answer">Answer:</label>
		<input type="text" name="user_answer" id="user_answer">
		<input type="hidden" name="right_answer" id="right_answer" value="<?php echo $right_answer; ?>"/>
		<input type="hidden" name="assignment_id" id="assignment_id" value="<?php echo $assignment_id; ?>"/>
		<input type="hidden" name="results" id="results" value="<?php echo htmlentities(serialize($results)); ?>"/>
		<input type="hidden" name="student_id" id="student_id" value="<?php echo $student_id; ?>"/>
		<input type="submit" class="btn btn-default" value="Submit Assignment">
	</form></center>
<?php
} else {
$i = $i + 1;
?>
	<form action="WriteAssignment.php" method="post">
		<label for="user_answer">Answer:</label>
		<input type="text" name="user_answer" id="user_answer">
		<input type="hidden" name="right_answer" id="right_answer" value="<?php echo $right_answer; ?>"/>
		<input type="hidden" name="assignment_id" id="assignment_id" value="<?php echo $assignment_id; ?>"/>
		<input type="hidden" name="questions" id="questions" value="<?php echo htmlentities(serialize($questions)); ?>"/>
		<input type="hidden" name="results" id="results" value="<?php echo htmlentities(serialize($results)); ?>"/>
		<input type="hidden" name="student_id" id="student_id" value="<?php echo $student_id; ?>"/>
		<input type="hidden" name="index" id="index" value="<?php echo $i; ?>"/>
		<input type="submit" class="btn btn-default" value="Next Question">
	</form></center>
<?php
}
?>









</div>
</body>
</html>