<html>
<head>
    <title>Question Preview</title>
    <link rel="stylesheet" href="css/main.css" />
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="jumbotron text-center">
        <p>Preview Question</p> 
    </div>

    <?php

    require_once 'dependencies/wa_wrapper/WolframAlphaEngine.php';

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
    function saveString($filename, $question_input){ 
      file_put_contents($filename, $question_input);
    }

    if (isset($_POST['question_text']) and isset($_POST['question_formula']))
    {
        echo "Question: " . $_POST['question_text'] . "<br>";
        echo "Formula: " . $_POST['question_formula'] . "<br>";

            // print the answer
            return $plaintext;
        }

        // function that takes in a string and store into a file
        function saveString($filename, $questionInput) { 
            file_put_contents($filename, $questionInput);
        }

        if (isset($_POST['questionText']) and isset($_POST['question_formula'])) {
  
            if (!(isset($_POST['save']))) {
                echo "Question: " . $_POST['questionText'] . "<br>";
                echo "Formula: " . $_POST['question_formula'] . "<br>";
            }

            if(isset($_POST['save'])) {
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
                //$answer = computeFormula($_POST['question_formula']);
                //echo $answer . "<br>";

                $qanda = $_POST['questionText'] . "<br> FORMULA: " . $_POST['question_formula'];

                // Save question to file.
                saveString($dir . $file_name, $qanda); // saves the string in the textarea into the file
                //echo $qanda . "<br>";

                // Determine how many rows exist in question table (for question_id).
                $mysqli = new mysqli("localhost", "root", "R0binson", "CSCC01");
                $result = $mysqli->query("SELECT question_id FROM questions");
                $question_id = $result->num_rows + 1;
                
                // Get tag(s)
                $questionTags = '';
                if (isset($_POST['questionTags'])){
                    $questionTags = $_POST['questionTags'];
                }

                // Insert question into question table
                $location = $dir . $file_name;
                //$assignment_id = $_POST['assignment_id'];
                $sql = "INSERT INTO questions (question_id, location, tag) VALUES ($question_id, '$location', '$questionTags')";
                $mysqli->query($sql);
                $mysqli->close();

                echo "Question has been saved! <br>";
            }
        }
    ?>
    
    <form method="post" action="SelectQuestionType.php">
        <button type="submit" name="submit" value="submit">Create more questions</button>
    </form>
    
    <form method="post" action="PreviewQuestion.php">
        <div class="form-row">
            <button type="button" class="btn btn-danger" onclick="history.back();"> Back </button>
            <button type="submit" class="btn btn-primary" name="save" value="save"> Save </button>
            <input type="hidden" name="questionText" value="<?=$_POST['questionText']?>">
            <input type="hidden" name="question_formula" value="<?=$_POST['question_formula']?>">
        </div>
    </form>

</body>
</html>
