<html>
<head>
<title>Question Preview</title>
</head>
<body>
<?php
include 'dependencies/wa_wrapper/WolframAlphaEngine.php';

// use wolfram alpha to calculate formula
function computeFormula($formula) {
	// create instance of api
	$engine = new WolframAlphaEngine('R4AW9W-39U3QJHUQ4');

	// send query info
	$resp = $engine->getResults("2 + 2 = 4 - 1");

	// get data pods back
	$pod = $resp->getPods();

	// select the wanted pod
	$pod = $pod[1];

	// search for the plaintext pod
	foreach($pod->getSubpods() as $subpod){
		if($subpod->plaintext){
		      $plaintext = $subpod->plaintext;
			          break;
			        }
	}

	// print the answer
	echo $plaintext;
}
function saveString($filename, $questionInput){ // function that takes in a string and store into a file
  file_put_contents($filename, $questionInput);
}

if (isset($_POST['questionText']))
{
	computeFormula($_POST['questionFormula']);
	
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
        saveString($dir . $file_name, $qanda); // saves the string in the textarea into the file
        echo $qanda;

        // Determine how many rows exist in question table (for question_id).
        $mysqli = new mysqli("localhost", "root", "R0binson", "CSCC01");
        $result = $mysqli->query("SELECT * FROM questions");
        $question_id = $result->num_rows + 1;

        // Insert question into question table
        $location = $dir . $file_name;
        $assignment_id = $_POST['assignment_id'];
        $sql = "INSERT INTO questions (question_id, assignment_id, location) VALUES ($question_id, $assignment_id, '$location')";
        $mysqli->query($sql);
        $mysqli->close();

}
?>
</body>
</html>
