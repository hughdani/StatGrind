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
?>
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
                <input class="hidden" name="assignment_id" id="assignment_id" value="<?= $_POST['assignment_id']; ?>">
            <?php endif; ?>
        </form>

        <form action="CreateMultipleChoice.php" method="post">
            <input type="submit" class="btn btn-default" value="Multiple Choice">
            <?php if (isset($_POST["assignment_id"])) : ?>
                <input class="hidden" name="assignment_id" id="assignment_id" value="<?= $_POST["assignment_id"]; ?>">
            <?php endif; ?>
            
        </form>
        
        <form action="<?php if(isset($_POST['assignment_id'])){ echo 'EditAssignment.php'; } else { echo 'Home.php';};?>" method="post">
            <input type="submit" class="btn btn-default" value="Cancel">
            <?php if (isset($_POST["assignment_id"])) : ?>
                <input class="hidden" name="assignment_id" id="assignment_id" value="<?= $_POST["assignment_id"]; ?>">
            <?php endif; ?>
        </form>
    </div>

</body>
</html>
