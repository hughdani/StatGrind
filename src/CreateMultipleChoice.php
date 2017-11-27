<html>
<head>
    <title>Create Multiple Choice</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>

<form action="SelectQuestionType.php" method="post">
    <input type="submit" class="btn btn-default" value="Refresh">
</form>

<!-- Multiple Choice -->
<div class="container-fluid">
    <div class="jumbotron text-center">
        <p>Multiple Choice Creator</p> 
    </div>

    <form method="post">
        <div class="form-group">
            <label for="mc_question"> Question:</label>
            <textarea type="submit" class="form-control" rows="5" name="mc_question" id="mc_question" required value=<?=$mc_question;?> ></textarea>
        </div>  
        <div class="form-group">
            <label for="num_options"> Number of Options:</label>
            <input class="form-control" type="number" id="num_options" name="num_options" min="2" required value=<?=$num_options;?>>
            <input type="submit" class="btn btn-default" name="newMC" id="newMC" value="Create Multiple Choice Question"> 
        </div>   
    </form>

    <?php if(isset($_POST["newMC"])) : ?>
        <?php $num_options = $_POST["num_options"]; ?>

        <form action='PreviewQuestion.php' method='post'>
            <div class='form-group'>
                <h3>Options</h3>

                <?php for($i = 1; $i <= $num_options; $i++) : ?>
                    <label for=mc<?=$i?>>Option <?=$i?> </label>
                    <input class='form-control' type='text' id=mc<?=$i?> value='' required> 
                    <br>
                <?php endfor; ?>

                <label for="correct_opt">Correct Option Number </label>
                <select class="form-control" id="correct_opt">

                <?php for($i = 1; $i <= $num_options; $i++) : ?>
                    <option><?=$i?></option>
                <?php endfor; ?>
            </div>
            
            <!-- question_formula set to dummy filler value for it to work with existing PreviewQuestion.php -->
            <input class='hidden' name=question_text id=question_text value=<?=$_POST['mc_question']?>>
            <input class='hidden' name=question_formula id=question_formula value='2+2' >
            <input type='submit' class='btn' value='Submit'> 
                               
            <h3>Summary</h3>
            <div>Question: <?=$_POST["mc_question"]?> </div>
            <br>
            <div>Options: <?=$_POST["num_options"]?> </div>
        </form>
    
    <?php endif; ?>
</div>

</body>
</html>
<!-- need to submit with the correct option, change previewquestion.php to handle this case -->