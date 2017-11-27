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

create_head('Select Question');
$assignment_id = $_POST['assignment_id'];
?>

<body>

<div class="container-fluid">

    <div class="jumbotron">
        <h1>Select Question</h1>
    </div>

	<!--Cancel button to go back to edit assignment page-->
	<form action="EditAssignment.php" method="post">
        <input type="hidden" name="assignment_id" id="assignment_id" value="<?= $assignment_id; ?>"/>
        <input type="submit" class="btn btn-default" value="Cancel">
    </form>
	
	<br>

	<!--Search for question based on tag-->
	<form action="SelectQuestion.php" method="post">
            <input type="text" name="question_tag" id="question_tag" placeholder="Question Tag(s)"/>
            <input type="hidden" name="assignment_id" id="assignment_id" value="<?= $assignment_id; ?>"/>
            <input type="submit" class="btn btn-default" value="Search">
    </form>
	
	<br>
	
	<!--Add N random questions-->
	<form action="EditAssignment.php" method="post">
		<input type="hidden" name="assignment_id" id="assignment_id" value="<?= $assignment_id; ?>"/>
		Add <input type="number" min="1" name="num_questions" id = "num_questions" value=1 /> random questions with tag:
		<input type="text" name="question_tag" id = "question_tag" />
		<input type="submit" class="btn btn-default" value="Add Questions">
	</form>
	
	
		<?php
		$i = 1;
		$sql = "SELECT question_id, location FROM questions";

		// Apply filters
		if (isset($_POST['question_tag'])){
			$filter = $_POST['question_tag'];
			$sql = $sql . " WHERE tag LIKE '%$filter%'";
		}

		$result = $db->query($sql);
		
		// Don't display duplicate questions
		$displayed = [];
		
		// Display each question and answer with the ption to be selected.
		while ($row = $result->fetch_assoc()) {
			// Check if question as been displayed before
			if (!in_array($row["location"], $displayed)) {
				echo "<h2>Question $i</h2><br>";
				$filetxt = file_get_contents($row["location"]);
				$q = explode("FORMULA:", $filetxt);
				// DIsplay question and answer.
				echo $q[0] . "<br><br>";
				echo "ANSWER: " . $q[1];
				// Add question to list of displayed questions
				array_push($displayed, $row["location"]);
				$i = $i + 1;
			
		?>
				<form action="EditAssignment.php" method="post">
					<input type="hidden" name="assignment_id" id="assignment_id" value="<?= $assignment_id; ?>"/>
					<input type="hidden" name="question_id" id="question_id" value="<?= $row["question_id"]; ?>"/>
					<input type="submit" class="btn btn-default" value="Select Question">
				</form>
		
		<?php
			}
		}
		?>

</div>
</body>
</html>
