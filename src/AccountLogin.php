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
