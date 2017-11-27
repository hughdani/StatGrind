<html>
<head>
    <title>Select Question Type</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</head>

<body>

    <div class="jumbotron text-center">
        <p>Select Question Type</p> 
    </div>

    <div class="container-fluid" >
        <form action="CreateQuestion.php" method="post">
            <input type="submit" class="btn btn-default" value="Standard Question">
            <?php if (isset($_POST['assignment_id'])) : ?>
                <input class="hidden" name="assignment_id" id="assignment_id" value="<?php $_POST['assignment_id']; ?>">
            <?php endif; ?>
        </form>

        <form action="CreateMultipleChoice.php" method="post">
            <input type="submit" class="btn btn-default" value="Multiple Choice">
            <?php if (isset($_POST['assignment_id'])) : ?>
                <input class="hidden" name="assignment_id" id="assignment_id" value="<?php $_POST['assignment_id']; ?>">
            <?php endif; ?>
            
        </form>
        
        <form action="AccountLogin.php" method="post">
            <input type="submit" class="btn btn-default" value="Cancel">
        </form>
    </div>

</body>
</html>
