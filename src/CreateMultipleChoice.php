<head>
    <title>Create Mutliple Choice</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<!-- Multiple Choice -->
<div class="container-fluid">
    <div class="form-group">
        <label for="num-question"> Number of Questions:</label>
        <textarea class="form-control" rows="1" id="num-question"></textarea>
    </div>   

    <div class="form-group">
        <label for="question"> Question:</label>
        <textarea class="form-control" rows="5" id="question"></textarea>
    </div>   

    <form action="CreateMultipleChoice.php" method="post">
        <input id="new_mc"type="submit" class="btn btn-default" value="Multiple Choice">
    </form>

    <div class="checkbox">
        <label><input type="checkbox" value="">Option 1</label>
    </div>
   
</div>

<?php 
    if(isset($_POST['new_mc')) {
        echo 'hello';
    }

?>


