<html>
<head>
<title>Question Preview</title>
</head>
<body>
    <form method="POST">
        <div class="form-row">
            Previewing question:
        </div>

    <?php
    include 'dependencies/wa_wrapper/WolframAlphaEngine.php';

    // use wolfram alpha to calculate formula
    function computeFormula($formula) {
        // create instance of api
        $engine = new WolframAlphaEngine('R4AW9W-39U3QJHUQ4');

        // get query info
        $resp = $engine->getResults($formula);

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
        return $plaintext;
    }

    // function that takes in a string and store into a file
    function saveString($filename, $questionInput){ 
      file_put_contents($filename, $questionInput);
    }

    if (isset($_POST['questionText']) and isset($_POST['questionFormula']))
    {
        echo "Question: " . $_POST['questionText'] . "<br>";
        echo "Formula: " . $_POST['questionFormula'] . "<br>";

    }

    if(isset($_POST['save'])){
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
        $answer = computeFormula($_POST['questionFormula']);
        echo $answer . "<br>";
        $qanda = $_POST['questionText'] . "<br> FORMULA: " . $_POST['questionFormula'];
        // Save question to file.
        saveString($dir . $file_name, $qanda); // saves the string in the textarea into the file
        echo $qanda . "<br>";

        // Determine how many rows exist in question table (for question_id).
        $mysqli = new mysqli("localhost", "root", "R0binson", "CSCC01");
        $result = $mysqli->query("SELECT question_id FROM questions");
        $question_id = $result->num_rows + 1;
        
        // Insert question into question table
        $location = $dir . $file_name;
        $assignment_id = $_POST['assignment_id'];
        $sql = "INSERT INTO questions (question_id, location) VALUES ($question_id, '$location')";
        $mysqli->query($sql);
        $mysqli->close();

        echo "Question have been saved! <br>"
        ?>
        
        <form method="post" action="CreateQuestion.php">
        <button type="submit" name="submit" value="submit" formaction="CreateQuestion.php">Create more questions</button>
        </form>
    }
        <div class="form-row">
            <button type="button" class="btn btn-danger" onclick="history.back();"> Back </button>
            <button type="submit" class="btn btn-primary" name="save" value="save"> Save </button>
        </div>
    </form>
</body>
</html>
