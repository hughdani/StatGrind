
<head>
    <title>Create Multiple Choice</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<form action="SelectQuestionType.php" method="post">
    <input type="submit" class="btn btn-default" value="Refresh">
</form>

<!-- Multiple Choice -->
<div class="container-fluid">
    <div class="jumbotron text-center">
        <p>Multiple Choice Creator</p> 
    </div>

    <form action="CreateMultipleChoice.php" method="post">
        <div class="form-group">
            <label for="mc_question"> Question:</label>
            <textarea type="submit" class="form-control" rows="5" name="mc_question" id="mc_question" required value="<?php echo $mc_question; ?>"></textarea>
        </div>  
        <div class="form-group">
            <label for="num_question"> Number of Options:</label>
            <input class="form-control" type="number" id="num_options" name="num_options" min="2" required value="<?php echo $num_options; ?>">
            <input type="submit" class="btn btn-default" name="new_mc" id="new_mc" value="Create Multiple Choice Question"> 
        </div>   
    </form>

    <?php 
        if(isset($_POST["new_mc"])) {
            $num_options = $_POST["num_options"];
            echo "<form action='PreviewQuestion.php' method='post'>";
            echo "<div class='form-group'>";
            echo "<h3>Options</h3>";
            for($i = 1; $i <= $num_options; $i++) {
                echo "Option " . $i . " <input class='form-control' type='text' id=mc".$i . " value='' required> " . "<br>";
            }
            echo "Correct Option ID: " . 
            "<input class='form-control' type='number' id='correct_opt' name='correct_opt' min='1' max='" .
            $num_options . "' required value='" . $correct_opt . "'></div>";

                   
            echo "<h3>Summary</h3>";
            echo "Question: " . $_POST["mc_question"] . "<br>";
            echo "Options: " . $_POST["num_options"];

            // questionFormula set to dummy filler value for it to work with existing PreviewQuestion.php
            echo"<input class='hidden' name=questionText id=questionText value='". $_POST['mc_question'] . "'>
                <input class='hidden' name=questionFormula id=questionFormula value='2+2' >
                <input type='submit' class='btn' value='Submit'> 
                </div>
                </form>";
            }
    ?>
</div>

<!-- need to submit with the correct option, change previewquestion.php to handle this case -->