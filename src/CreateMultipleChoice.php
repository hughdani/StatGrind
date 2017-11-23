
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
            <label for="mcQuestion"> Question:</label>
            <textarea type="submit" class="form-control" rows="5" name="mcQuestion" id="mcQuestion" required value="<?=$mcQuestion;?>"></textarea>
        </div>  
        <div class="form-group">
            <label for="numOptions"> Number of Options:</label>
            <input class="form-control" type="number" id="numOptions" name="numOptions" min="2" required value="<?=$numOptions;?>">
            <input type="submit" class="btn btn-default" name="newMC" id="newMC" value="Create Multiple Choice Question"> 
        </div>   
    </form>

    <?php if(isset($_POST["newMC"])) : ?>
        <?php $numOptions = $_POST["numOptions"]; ?>

        <form action='PreviewQuestion.php' method='post'>
            <div class='form-group'>
                <h3>Options</h3>

                <?php for($i = 1; $i <= $numOptions; $i++) : ?>
                    <p>Option <?=$i?> </p>
                    <input class='form-control' type='text' id=mc<?=$i?> value='' required> 
                    <br>
                <?php endfor; ?>

                <p>Correct Option ID:</p>
                <input class='form-control' type='number' id='correct_opt' name='correct_opt' min='1' 
                max=<?=$numOptions?> required value=<?=$correct_opt?>>
            </div>
                   
            <h3>Summary</h3>
            <div>Question: <?=$_POST["mcQuestion"]?> </div>
            <br>
            <div>Options: <?=$_POST["numOptions"]?> </div>

            <!-- questionFormula set to dummy filler value for it to work with existing PreviewQuestion.php -->
            <input class='hidden' name=questionText id=questionText value=<?=$_POST['mcQuestion']?>>
            <input class='hidden' name=questionFormula id=questionFormula value='2+2' >
            <input type='submit' class='btn' value='Submit'> 
        </form>
    
    <?php endif; ?>
</div>

<!-- need to submit with the correct option, change previewquestion.php to handle this case -->