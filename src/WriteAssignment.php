<?php 
require_once 'Database.php';
require_once 'User.php';
require_once 'Utils.php';

if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['user'])) {
    header("Location: Forbidden.php");
}
// Determine assignment_id.
if (isset($_POST['assignment_id']))
{
	$assignment_id = $_POST['assignment_id'];
} else {
	$assignment_id = 1;
}

create_head('Write Assignment');
echo "<body>";

$db = new Database();
$mysqli = $db->getconn();
$user = $_SESSION['user'];
$first_name = $user->getFirstName();
$account_type = $user->getAccountType();
$header_text = "Write ".$db->getAssignmentTitle($assignment_id);

include("NavigationBar.php");
create_site_header($header_text);


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
	$i = $_POST['inde<div class="container-fluid">
<section class="wrapper style2 special">
<div class="inner narrow">
x'];
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
	$result = $mysqli->query("SELECT in_assignment.question_id, location FROM in_assignment LEFT JOIN questions ON in_assignment.question_id=questions.question_id WHERE assignment_id = $assignment_id");
	while ($row = $result->fetch_assoc()) {
		$questions[] = [$row["question_id"], $row["location"]];
	}
}
?>

<div class="container-fluid">
<section class="wrapper style2 special">
<div class="inner narrow">


<?php
// Display question
$qnumb = $i + 1;
echo "<center><h2>Question $qnumb</h2><br>";
$question_file = file_get_contents($questions[$i][1]);
if (strpos($question_file, 'ANSWER:') !== false) {
    $q = explode("ANSWER:", $question_file);
} else {
	$q = explode("FORMULA:", $question_file);
}

// Insert variable interpetor.
require_once 'VariableReader.php';
$genquestion = varreader($q[0], $q[1]);

// Display generated question
$newquestionbody = $genquestion[0];
$newformula = $genquestion[1];
echo $newquestionbody . "<br><br>";

// Set correct answer.
if ($newformula == "") {
	$right_answer = "";
} else {
	if ($genquestion[2] != 0) { 
		$right_answer = computeFormula($newformula);
	} else {
		$right_answer = $newformula;
	}
}


// Determine if this is the last question
if ($qnumb == count($questions)) {
?>

	<form action="ConfirmSubmission.php" method="post">
		<label for="user_answer">Answer:</label>
		<input type="text" name="user_answer" id="user_answer">
		<input type="hidden" name="right_answer" id="right_answer" value="<?= $right_answer; ?>"/>
		<input type="hidden" name="assignment_id" id="assignment_id" value="<?= $assignment_id; ?>"/>
		<input type="hidden" name="results" id="results" value="<?php echo htmlentities(serialize($results)); ?>"/>
		<input type="hidden" name="student_id" id="student_id" value="<?= $student_id; ?>"/>
		<input type="submit" class="btn btn-default" value="Submit Assignment">
	</form></center>
<?php
} else {
$i = $i + 1;
?>
	<form action="WriteAssignment.php" method="post">
		<label for="user_answer">Answer:</label>
		<input type="text" name="user_answer" id="user_answer">
		<input type="hidden" name="right_answer" id="right_answer" value="<?= $right_answer; ?>"/>
		<input type="hidden" name="assignment_id" id="assignment_id" value="<?= $assignment_id; ?>"/>
		<input type="hidden" name="questions" id="questions" value="<?= htmlentities(serialize($questions)); ?>"/>
		<input type="hidden" name="results" id="results" value="<?php echo htmlentities(serialize($results)); ?>"/>
		<input type="hidden" name="student_id" id="student_id" value="<?= $student_id; ?>"/>
		<input type="hidden" name="index" id="index" value="<?= $i; ?>"/>
		<input type="submit" class="btn btn-default" value="Next Question">
	</form></center>
<?php
}
?>


</div>
</section>
</div>
</body>
</html>
