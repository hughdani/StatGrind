<html>
<head>
    <title>edit assignment</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<?php 
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

// Insert new assignment into assignments table
if (isset($_POST['starttime']))
{
	$start = converttime($_POST['starttime']);
	$end = converttime($_POST['endtime']);
	$assignment_id = $_POST['assignment_id'];
	
	$mysqli = new mysqli("localhost", "root", "R0binson", "CSCC01");
	$sql = "INSERT INTO assignments (assignment_id, start_date, end_date) VALUES ($assignment_id, '$start', '$end')";
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
	$qanda = $_POST['questionText'] . "\n\n\n\n ANSWER: " . $_POST['formula'];

	// Save question to file.
	saveString($dir . $file_name, $qanda); // saves the string in the textarea into the file

	// Insert question into question table
	$mysqli = new mysqli("localhost", "root", "R0binson", "CSCC01");
	$location = $dir . $file_name;
	$assignment_id = $_POST['assignment_id'];
	$sql = "INSERT INTO questions (location) VALUES ('$location')";
	$mysqli->query($sql);

	$sql = "SELECT question_id, location FROM questions WHERE location = '$location'";
	$row = $mysqli->query($sql)->fetch_row();
	$new_question_id = $row[0];

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


$assignment_id = $_POST['assignment_id'];


?>


<body>

<div class="container-fluid">

	<div class="jumbotron">
		<h1>Edit Assignment <?php echo $assignment_id; ?></h1>
	</div>

	<?php
		$i = 1;
		// Grab questions with correct assignment_id.
		$mysqli = new mysqli("localhost", "root", "R0binson", "CSCC01");
		$result = $mysqli->query("SELECT assignment_id, location FROM in_assignment LEFT JOIN questions ON in_assignment.question_id=questions.question_id WHERE assignment_id = $assignment_id");
		while ($row = $result->fetch_row()) {
			echo "<h2>Question $i</h2><br>";
			$filetxt = file_get_contents($row[1]);
			$q = explode("ANSWER:", $filetxt);
			echo $q[0] . "<br><br>";
			echo "ANSWER: " . $q[1];
			$i = $i + 1;
		}
		$mysqli->close();		
		echo "<br><br>";
		echo "<h2>Question $i</h2>";
	?>

	<form action="CreateQuestion.php" method="post">
		<input type="hidden" name="assignment_id" id="assignment_id" value="<?php echo $assignment_id; ?>"/>
		<input type="submit" class="btn btn-default" value="Create New Question">
	</form>
	<form action="AddRandomQuestions.php" method="post">
		<input type="hidden" name="assignment_id" id="assignment_id" value="<?php echo $assignment_id; ?>"/>
		Add <input type="number" min="1" name="num_questions" id = "num_questions" value=1 /> random questions
		<input type="submit" class="btn btn-default" value="Add Questions">
	</form>
	<form action="SelectQuestionPage.php" method="post">
		<input type="hidden" name="assignment_id" id="assignment_id" value="<?php echo $assignment_id; ?>"/>
		<input type="submit" class="btn btn-default" value="Select Question">
	</form>
	<form action="ConfirmCreateAssignmentPage.php" method="post">
		<input type="hidden" name="assignment_id" id="assignment_id" value="<?php echo $assignment_id; ?>"/>
		<input type="submit" class="btn btn-default" value="Submit Assignment">
	</form>

</div>
</body>
</html>
