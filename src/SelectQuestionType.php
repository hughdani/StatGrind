<?php
require_once 'Database.php';
require_once 'User.php';
require_once 'Utils.php';
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

create_head('Select Question Type');
echo "<body>";

$db = new Database();
$user = $_SESSION['user'];
$first_name = $user->getFirstName();
$account_type = $user->getAccountType();
$header_text = "Select Question Type";

include("NavigationBar.php");
create_site_header($header_text);
?>
<body>
<div class="container-fluid">
<section class="wrapper style2 special">
<div class="inner narrow">
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

</div>
</section>
</div>
</body>
</html>
