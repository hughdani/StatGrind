<?php 

require_once 'VariableReader.php';
require_once 'Database.php';
require_once 'User.php';
if (!isset($_SESSION)) {
    session_start();
}
$db = new Database();
$mysqli = $db->getconn();

$user = $_SESSION['user'];
$user_id = $user->getUserId();

// Determine assignment_id.
if (isset($_POST['assignment_id'])) {
	$assignment_id = $_POST['assignment_id'];
} else {
	$assignment_id = 1;
}

// If this is not the first question.
if (isset($_POST['questions'])) {
	$i = $_POST['index'];
	$questions = unserialize($_POST['questions']);
	$results = unserialize($_POST['results']);
	// Determine result of last question.
    $user_answer = $_POST['user_answer'];
    $true_answer = $_POST['true_answer'];
    $wa = "$user_answer = $true_answer";
    $wa_result = computeFormula($wa);
	$result[] = ($wa == 'True') ?  100 : 0;
} else {
    $i = 0;
	// Get assignment questions
	$questions = [];
	$results = [];
    $ret = $mysqli->query("SELECT DISTINCT location
        FROM in_assignment 
        INNER JOIN questions ON in_assignment.question_id=questions.question_id 
        WHERE assignment_id = $assignment_id");

    while ($question = $ret->fetch_assoc()) {
            $questions[] = $question;
    }

}
?>

<html>
<head>
    <title>Write <?= $db->getAssignmentTitle($assignment_id); ?></title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/main.css" />
</head>
<body>
<div class="container-fluid">

	<div class="jumbotron">
		<h1>Write <?= $db->getAssignmentTitle($assignment_id); ?></h1>
	</div>

<?php
// Display question
echo "<center><h2>Question $i </h2><br>";
$question = $questions[$i];
$question_file = file_get_contents($question['location']);
$q = explode("FORMULA:", $question_file);
// Insert variable interpetor.
$parsed_question = varreader($q[0], $q[1]);

// Display generated question
$parsed_qtext = $parsed_question[0];
$parsed_qformula = $genquestion[1];

echo $parsed_qtext . "<br><br>";
// Set correct answer.
if ($parsed_qformula == "") {
	$true_answer = "";
} else {
	if ($genquestion[2] != 0) { 
		$true_answer = computeFormula($parsed_qformula);
	} else {
		$true_answer = $parsed_qformula;;
	}
}

// Determine if this is the last question
if ($i == $questions->num_rows - 1) {
?>

	<form action="ConfirmSubmission.php" method="post">
		<label for="user_answer">Answer:</label>
		<input type="text" name="user_answer" id="user_answer">
		<input type="hidden" name="true_answer" id="right_answer" value="<?= $true_answer ?>"/>
		<input type="hidden" name="assignment_id" id="assignment_id" value="<?= $assignment_id ?>"/>
		<input type="hidden" name="results" id="results" value="<?php echo htmlentities(serialize($results)); ?>"/>
		<input type="submit" class="btn btn-default" value="Submit Assignment">
	</form></center>
<?php
} else {
$i = $i + 1;
?>
	<form action="WriteAssignment.php" method="post">
		<label for="user_answer">Answer:</label>
		<input type="text" name="user_answer" id="user_answer">
		<input type="hidden" name="true_answer" id="right_answer" value="<?= $true_answer ?>"/>
		<input type="hidden" name="assignment_id" id="assignment_id" value="<?= $assignment_id; ?>"/>
		<input type="hidden" name="questions" id="questions" value="<?= htmlentities(serialize($questions)) ?>"/>
		<input type="hidden" name="results" id="results" value="<?php echo htmlentities(serialize($results)) ?>"/>
		<input type="hidden" name="index" id="index" value="<?= $i; ?>"/>
		<input type="submit" class="btn btn-default" value="Next Question">
	</form></center>
<?php
}
?>
</div>
</body>
</html>
