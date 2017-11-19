<html>
<head>
  <title>Log In</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/main.css" />
</head>

<?php
function check_creds($username, $password) {
    /*
    Return integer based on result of credential check:
    Correct user/password: 0
    Account doesn't exist: 1
    Incorrect password: 2
    */
    $mysqli = new mysqli("localhost", "root", "R0binson", "CSCC01");
    $sql = "SELECT username, password FROM users WHERE username = '$username'";
    $result = $mysqli->query($sql);
    $mysqli->close();
    if ($result->num_rows == 0) {
        return 1;
    } else if (strcmp($result->fetch_row() [1], $password) != 0) {
        return 2;
    } else {
        return 0;
    }
}
function visibility_tag($userid, $permission_flag) {
    /*
    <?php if (isset($userid)){ echo visibility_tag($userid, "create_assignment_perm"); }?>
    */
    $mysqli = new mysqli("localhost", "root", "R0binson", "CSCC01");
    $sql = "SELECT user_id, $permission_flag FROM users LEFT JOIN account_types ON users.account_type=account_types.account_type WHERE user_id = $userid";
    $result = $mysqli->query($sql)->fetch_row();
    $mysqli->close();
    if ($result[1] == false) {
        return "style = 'display:none'";
    } else {
        return "";
    }
}
$logged_in = false;
$err_msg = "";
$username = "";

if (isset($_POST["user_id"])){
	$logged_in = true;
	$userid = $_POST["user_id"];
        $mysqli = new mysqli("localhost", "root", "R0binson", "CSCC01");
        $sql = "SELECT first_name FROM users WHERE user_id = $userid";
        $result = $mysqli->query($sql)->fetch_row();
        $firstname = $result[0];
        $mysqli->close();
}

if (isset($_POST["login_attempt"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    if (check_creds($username, $password) == 0) {
        $logged_in = true;
        $mysqli = new mysqli("localhost", "root", "R0binson", "CSCC01");
        $sql = "SELECT first_name, user_id FROM users WHERE username = '$username'";
        $result = $mysqli->query($sql)->fetch_row();
        $firstname = $result[0];
        $userid = $result[1];
        $mysqli->close();
    } else if (check_creds($username, $password) == 1) {
        $err_msg = "Account does not exist";
    } else if (check_creds($username, $password) == 2) {
        $err_msg = "Incorrect password";
    }
}
?>
<body>
<div class="jumbotron text-center" <?php if ($logged_in == true) {
    echo "style = 'display:none'";
} ?>>
  <p>Log In</p> 
</div>
<div class="jumbotron text-center" <?php if ($logged_in == false) {
    echo "style = 'display:none'";
} ?>>
  <p> <?php if (isset($firstname)) {
    echo "Welcome back, $firstname!";
} ?></p> 
</div>

  
<!- Not logged in ->
<div class="container" <?php if ($logged_in == true) {
    echo "style = 'display:none'";
} ?>>
  <form method="post" action="AccountLogin.php">
      Username: <input type="text" name="username" value = <?php echo "'$username'" ?> required><br>
      Password: <input type="password" name="password" required><br>
      <input type="submit" name="login_attempt" value ="Log In">
  </form>
  <?php echo $err_msg ?>

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
    <form action="CreateQuestion.php" method="post" <?php if (isset($userid)) {
    echo visibility_tag($userid, "create_assignment_perm");
} ?>>
      <input type="hidden" name="user_id" id="user_id" <?php if (isset($userid)) {
    echo "value='$userid'";
} ?>"/>
      <input type="submit" value ="Create a New Question">
    </form>

    <form action="AssignmentMarkingFeedback.php" method="post" <?php if (isset($userid)){ echo visibility_tag($userid, "grade_assignment_perm"); }?>>
      <input type="submit" value ="Update marking/feedback">
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

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
