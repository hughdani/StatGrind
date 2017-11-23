<html>
<head>
    <title>Select Question</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/main.css" />
</head>
<?php 
$assignment_id = $_POST['assignment_id'];
?>

<body>

<div class="container-fluid">

    <div class="jumbotron">
        <h1>Select Question</h1>
    </div>

	<!--Cancel button to go back to edit assignment page-->
	<form action="EditAssignmentPage.php" method="post">
        <input type="hidden" name="assignment_id" id="assignment_id" value="<?php echo $assignment_id; ?>"/>
        <input type="submit" class="btn btn-default" value="Cancel">
    </form>
	
	<br>

	<!--Search for question based on tag-->
	<form action="SelectQuestionPage.php" method="post">
            <input type="text" name="questionTag" id="questionTag" placeholder="Question Tag(s)"/>
            <input type="hidden" name="assignment_id" id="assignment_id" value="<?php echo $assignment_id; ?>"/>
            <input type="submit" class="btn btn-default" value="Search">
    </form>
	
	<br>
	
	<!--Add N random questions-->
	<form action="EditAssignmentPage.php" method="post">
		<input type="hidden" name="assignment_id" id="assignment_id" value="<?php echo $assignment_id; ?>"/>
		Add <input type="number" min="1" name="num_questions" id = "num_questions" value=1 /> random questions (with tag 
		<input type="text" name="questionTag" id = "questionTag" />)
		<input type="submit" class="btn btn-default" value="Add Questions">
	</form>
	
	
		<?php
		$i = 1;
		$mysqli = new mysqli("localhost", "root", "R0binson", "CSCC01");
		$sql = "SELECT question_id, location FROM questions";

		// Apply filters
		if (isset($_POST['questionTag'])){
			$filter = $_POST['questionTag'];
			$sql = $sql . " WHERE tag LIKE '%$filter%'";
		}

		$result = $mysqli->query($sql);
		
		// Don't display duplicate questions
		$displayed = [];
		
		// Display each question and answer with the ption to be selected.
		while ($row = $result->fetch_assoc()) {
			// Check if question as been displayed before
			if (!in_array($row["location"], $displayed)) {
				echo "<h2>Question $i</h2><br>";
				$filetxt = file_get_contents($row["location"]);
				$q = explode("ANSWER:", $filetxt);
				// DIsplay question and answer.
				echo $q[0] . "<br><br>";
				echo "ANSWER: " . $q[1];
				// Add question to list of displayed questions
				array_push($displayed, $row["location"]);
				$i = $i + 1;
			
		?>
				<form action="EditAssignmentPage.php" method="post">
					<input type="submit" class="btn btn-default" value="Select Question">
				</form>
		
		<?php
			}
		}
		$mysqli->close();		
		?>

</div>
</body>
</html>
