<?php
require_once 'Database.php';
require_once 'User.php';
require_once 'Utils.php';

session_start();
session_unset();

create_head('Log In');
$db = new Database();

if ($_POST['login']) {
    $login = $db->login($_POST['username'], $_POST['password']);
    if ($login == Database::LOGIN_FAIL) {
        $_SESSION['error'] = "Incorrect Password";
    } elseif ($login == Database::LOGIN_DNE) {
        $_SESSION['error'] = "Account does not exist";
    } else {
        if ($login['account_type'] == Instructor::USER_TYPE) {
            $user = new Instructor($login['user_id'], $login['username'], $login['first_name'], $login['last_name']);
        } elseif ($login['account_type'] == TA::USER_TYPE) {
            $user = new TA($login['user_id'], $login['username'], $login['first_name'], $login['last_name']);
        } elseif ($login['account_type'] == Student::USER_TYPE) {
            $user = new Student($login['user_id'], $login['username'], $login['first_name'], $login['last_name']);
        }
        $_SESSION['user'] = $user;
        header("Location: Home.php");
        exit();
    }
}
?>
<div class="container">
  <form method="post" action="AccountLogin.php">
      Username: <input type="text" name="username" required><br>
      Password: <input type="password" name="password" required><br>
      <input type="submit" name="login" value ="Log In">
</form>
<?= $_SESSION['error'] ?>
  <form method="post" action="CreateAccount.php">
      <input type="submit" value ="Create Account">
  </form>
</div>

<!- Logged in ->
<div class="container" <?php if ($logged_in == false) {
    echo "style = 'display:none'";
} ?>>
    <br><br>
    <img src="http://2.bp.blogspot.com/-2RS14e7Z5Zs/VN0VyBmGKLI/AAAAAAAABfE/XcmQJWEp26o/s1600/racoon.jpg">
    <br><br>
    <form action="NewAssignmentPage.php" method="post" <?php if (isset($userid)) {
    echo visibility_tag($userid, "create_assignment_perm");
} ?>>
      <input type="hidden" name="user_id" id="user_id" <?php if (isset($userid)) {
    echo "value='$userid'";
} ?>/>
      <input type="submit" value ="Create a New Assignment">
    </form>
    <form action="SelectQuestionType.php" method="post" <?php if (isset($userid)) {
    echo visibility_tag($userid, "course_management_perm");
} ?>>
      <input type="hidden" name="user_id" id="user_id" <?php if (isset($userid)) {
    echo "value='$userid'";
} ?>/>
      <input type="submit" value ="Create a New Question">
    </form>

    <form action="AllCreatedQuestions.php" method="post" <?php if (isset($userid)) {
    echo visibility_tag($userid, "course_management_perm");
} ?>>
	<input type="submit" value ="All Created Questions">
    </form>
    <form action="AssignmentMarkingFeedback.php" method="post" <?php if (isset($userid)){ echo visibility_tag($userid, "grade_assignment_perm"); }?>>
      <input type="submit" value ="Update marking/feedback">
    </form>

    <form action="EditCourses.php" method="post" <?php if (isset($userid)){ echo visibility_tag($userid, "course_management_perm"); }?>>
      <input type="submit" value ="Course Management">
    </form>

    <form action="AssignmentOverview.php" method="post" <?php if (isset($userid)){ echo visibility_tag($userid, "view_assignment_perm"); }?>>
      <input type="submit" value ="Assignment Overview">
    </form>

<!--
    <form action="WriteAssignment.php" method="post" <?php if (isset($userid)){ echo visibility_tag($userid, "view_assignment_perm"); }?>>
      <input type="text" name="assignment_id" id="assignment_id" placeholder="Assignment #">
      <input type="submit" value ="Write Assignment">
    </form>
-->
    <form action="ChooseAssignment.php" method="post">
      <input type="hidden" name="student_id" id="student_id" <?php if (isset($userid)) { echo "value='$userid'";} ?>/>
      <input type="submit" value ="Select Assignment">
    </form>

    <form action="DisplayAssignment.php" method="post">
      <input type="submit" value ="View Full Assignment">
    </form>

    <form action="AssignmentAnswer.php" method="post">
      <input type="submit" value ="View Assignment Answer">
    </form>

    <form action="ViewStatistic.php" method="post">
      <input type="submit" value ="View Assignment Statistics">
    </form>

    <form action="ViewLeaderboard.php" method="post">
      <input type="submit" value ="View Leaderboard">
    </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
