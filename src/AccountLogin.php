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
<body>

<section id="site_header">
  <p>Log In</p> 
</section>

<?php if (isset($_SESSION['error'])): ?>
<div class="alert">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
      <?= $_SESSION['error']; ?>
</div>
<?php endif; ?>

<section class="wrapper special">
    <div class="inner">
 	<form method="post" action="AccountLogin.php">
    	 	<h3>Username:</h3> <input type="text" name="username" required><br>
      		<h3>Password:</h3> <input type="password" name="password" required><br>
      		<input type="submit" name="login" value ="Log In">
	</form>
	<form method="post" action="CreateAccount.php">
		<input type="submit" value ="Create Account">
	</form>
    </div>
</section>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
