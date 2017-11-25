<html>
<head>
    <title>edit assignment</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/main.css" />
</head>

<?php 

include 'Database.php';
$db = new Database();

// Set $assignment_id
if (isset($_POST['assignment_id'])) {
	$assignment_id = $_POST['assignment_id'];
} else {
	$assignment_id = 1;
}

// Convert starttime to sql datetime format
// 10/25/2017 9:31 PM to 2017-10-25 21:31:00
function converttime($time) {
	$part = explode(" ", $time);
	$date = explode("/", $part[0]);
	$time = explode(":", $part[1]);
	if ($part[2] == "PM") {
		$time[0] = $time[0] + 12;
	} else {
		if (strlen($time[0]) == 1){
			$time[0] = "0" . $time[0];
		}
	}
	$newtime = $date[2] . "-" . $date[0] . "-" . $date[1] . " " . $time[0] . ":" . $time[1] . ":00";
	return $newtime;	
}

// function that takes in a string and store into a file
function saveString($filename, $questionInput) {
  file_put_contents($filename, $questionInput);
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

// Insert new assignment into assignments table
if (isset($_POST['starttime']))
{
	$start = converttime($_POST['starttime']);
	$end = converttime($_POST['endtime']);
	$assignment_id = $_POST['assignment_id'];
	
	$mysqli = new mysqli("localhost", "root", "R0binson", "CSCC01");
	$sql = "INSERT INTO assignments (assignment_id, start_date, end_date, tag, title) VALUES ($assignment_id, '$start', '$end', '$assignment_tag', '$assignment_title')";
	$mysqli->query($sql);
	$mysqli->close();
}

// Save new question to questions table
if (isset($_POST['questionText']))
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
	$qanda = $_POST['questionText'] . "\n\n\n\n ANSWER: " . $_POST['questionFormula'];

	// Save question to file.
	$location = $dir . $file_name;
	saveString($location, $qanda); // saves the string in the textarea into the file

	// Insert question into question table
	$mysqli = new mysqli("localhost", "root", "R0binson", "CSCC01");
	$assignment_id = $_POST['assignment_id'];
	$sql = "INSERT INTO questions (location) VALUES ('$location')";
	$mysqli->query($sql);

	$sql = "SELECT question_id, location FROM questions WHERE location = '$location'";
	$row = $mysqli->query($sql)->fetch_assoc();
	$new_question_id = $row["question_id"];

	$sql = "INSERT INTO in_assignment (assignment_id, question_id) VALUES ($assignment_id, $new_question_id)";
	$mysqli->query($sql);

	$mysqli->close();
	
}

// if question was selected, save that question
if (isset($_POST['question_id']))
{
	
	// Insert question into question table
	$mysqli = new mysqli("localhost", "root", "R0binson", "CSCC01");
	$question_id = $_POST['question_id'];
	$assignment_id = $_POST['assignment_id'];
	$sql = "INSERT INTO in_assignment (assignment_id, question_id) VALUES ($assignment_id, $question_id)";
	$mysqli->query($sql);
	$mysqli->close();
	
}

// if a number of random questions was selected, save those questions.
if (isset($_POST['num_questions']))
{
	$mysqli = new mysqli("localhost", "root", "R0binson", "CSCC01");
	for ($i = 1; $i <= $_POST['num_questions']; $i++) {
		$sql = "SELECT question_id FROM questions";
		
		// Apply filter if any
		if (isset($_POST['questionTag'])){
			$filter = $_POST['questionTag'];
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
	$mysqli->close();
}

// if question was removed, remove that question
if (isset($_POST['map_id']))
{
	// Insert question into question table
	$mysqli = new mysqli("localhost", "root", "R0binson", "CSCC01");
	$map_id = $_POST['map_id'];
	$sql = "DELETE FROM in_assignment WHERE map_id = $map_id";
	$mysqli->query($sql);
	$mysqli->close();

}
// If editing existing assignment, get id and title
if (isset($_POST['assignment_id'])) {
	$assignment_id = $_POST['assignment_id'];
} else {
	$assignment_id = 1;
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
		$mysqli = new mysqli("localhost", "root", "R0binson", "CSCC01");
		$result = $mysqli->query("SELECT in_assignment.question_id, location, map_id FROM in_assignment LEFT JOIN questions ON in_assignment.question_id=questions.question_id WHERE assignment_id = $assignment_id");
		while ($row = $result->fetch_assoc()) {
			echo "<h2>Question $i</h2><br>";
			$filetxt = file_get_contents($row["location"]);
			$q = explode("ANSWER:", $filetxt);
			echo $q[0] . "<br><br>";
			echo "ANSWER: " . $q[1] . "<br>";
			$i = $i + 1;
			?>
			<form action="EditAssignmentPage.php" method="post">
				<input type="hidden" name="assignment_id" id="assignment_id" value="<?= $assignment_id; ?>"/>
				<input type="hidden" name="map_id" id="map_id" value="<?= $row["map_id"]; ?>"/>
				<input type="submit" class="btn btn-default" value="Remove Question">
			</form>
			<?php
		}
		$mysqli->close();		
		echo "<br><br>";
		echo "<h2>Question $i</h2>";
	?>

	<form action="CreateQuestion.php" method="post">
		<input type="hidden" name="assignment_id" id="assignment_id" value="<?= $assignment_id; ?>"/>
		<input type="submit" class="btn btn-default" value="Create New Question">
	</form>
	<form action="SelectQuestionPage.php" method="post">
		<input type="hidden" name="assignment_id" id="assignment_id" value="<?= $assignment_id; ?>"/>
		<input type="submit" class="btn btn-default" value="Select Question">
	</form>
	<form action="ConfirmCreateAssignmentPage.php" method="post">
		<input type="hidden" name="assignment_id" id="assignment_id" value="<?= $assignment_id; ?>"/>
		<input type="submit" class="btn btn-default" value="Submit Assignment">
	</form>

</div>
</body>
</html>

