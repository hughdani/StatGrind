<?php
require_once 'Database.php';
require_once 'User.php';
require_once 'Utils.php';

$db = new Database();
$mysqli = $db->getconn();

if (!isset($_SESSION)) {
    session_start();
}

$header_text = $db->getPageTitle(basename(__FILE__));
create_head('Create Account');

function available($user_name) {
    global $mysqli;
    $sql = "SELECT username FROM users WHERE username = '$user_name'";
    $num_rows = $mysqli->query($sql)->num_rows;
    return ($num_rows == 0);
}
function register($username, $password, $first_name, $last_name, $account_type) {
    global $mysqli;
    $password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (username, password, first_name, last_name, account_type) VALUES ('$username', '$password', '$first_name', '$last_name', $account_type)";
    $mysqli->query($sql);
}

$err_msg = "";
$err_clr = "ef6951";
$username = "";
$firstname = "";
$lastname = "";

if (isset($_POST["create_account"]))
	{
	$username = $_POST["user_name"];
	$firstname = $_POST["first_name"];
	$lastname = $_POST["last_name"];
	$accounttype = $_POST["account_type"];
	$pass1 = $_POST["password1"];
	$pass2 = $_POST["password2"];
	if (!available($username))
		{
		$err_msg = "Username is unavailable";
		$username = "";
		}
	  else
	if ($pass1 != $pass2)
		{
		$err_msg = "Passwords do not match";
		}
	  else
		{
		register($username, $pass1, $firstname, $lastname, $accounttype);
		$username = "";
		$firstname = "";
		$lastname = "";
		$err_msg = "Account Created";
		$err_clr = "54f296";
		}
	}

?>

<body>	

<?php 
create_site_header($header_text);
?>

<?php if ($err_msg != ""): ?>
<div class="alert" style="background-color:<?= "#$err_clr" ?>">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
      <?= $err_msg; ?>
</div>
<?php endif; ?>

<section class="wrapper special">
    <div class="inner">
      <form method="post" action="CreateAccount.php">
        <h3>User Name:</h3> <input type="text" name="user_name" minlength="4" value="<?= $username; ?>" required><br>
        <h3>Password:</h3> <input type="password" name="password1" minlength="4" required><br>
        <h3>Confirm Password:</h3> <input type="password" name="password2" minlength="4" required><br/>
        <h3>First Name:</h3> <input type="text" name="first_name" value="<?= $firstname; ?>" required><br>
        <h3>Last Name:</h3> <input type="text" name="last_name" value="<?= $lastname; ?>" required><br>
        <h3>Account Type:</h3>
        <select name="account_type" required>
 			<option value="2">Student</option>
  			<option value="1">Instructor</option>
  			<option value="3">TA</option>
		    </select><br>
     	<input type="submit" name="create_account" value ="Create Account">
      </form>
      <form method="post" action="AccountLogin.php">
        <input type="submit" name="log_in" value ="Log in">
      </form>
    </div>
</section>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
