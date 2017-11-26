<html>
<head>
  <title>Create New Account</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/main.css" />
</head>
<?php

function available($user_name)
	{
	$mysqli = new mysqli("localhost", "root", "R0binson", "CSCC01");
	$sql = "SELECT username FROM users WHERE username = '$user_name'";
	$num_rows = $mysqli->query($sql)->num_rows;
	$mysqli->close();
	return ($num_rows == 0);
	}

function register($username, $password, $first_name, $last_name, $account_type)
	{
	$mysqli = new mysqli("localhost", "root", "R0binson", "CSCC01");
	$sql = "INSERT INTO users (username, password, first_name, last_name, account_type) VALUES ('$username', '$password', '$first_name', '$last_name', $account_type)";
	$mysqli->query($sql);
	$mysqli->close();
	return;
	}

$err_msg = "";
$err_clr = "red";
$username = "";
$firstname = "";
$lastname = "";

if (isset($_POST["create_Account"]))
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
		$err_clr = "green";
		}
	}

?>

<body>	

<section id="site_header">
  <p>Create New Account</p> 
</section>

<?php

if ($err_msg != ""): ?>
<div class="alert" style="background-color:<?php echo $err_clr
?>">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
      <?php echo $err_msg; ?>
</div>
<?php
endif; ?>

	<section class="wrapper special">
		<div class="inner">
      <form id="account_creation" method="post" action="CreateAccount.php">
        <h3>User Name:</h3> <input type="text" id="user_name" name="user_name" minlength="4" value="<?php echo $username; ?>" required><br/>
        <h3>Password:</h3> <input type="password" name="password1" minlength="4" required><br/>
        <h3>Confirm Password:</h3> <input type="password" name="password2" minlength="4" required><br/>
        <h3>First Name:</h3> <input type="text" name="first_name" value="<?php echo $firstname; ?>" required><br/>
        <h3>Last Name:</h3> <input type="text" name="last_name" value="<?php echo $lastname; ?>" required><br/>
        <h3>Account Type:</h3>
        <select name="account_type" required>
     		  <option value="2">Student</option>
    			<option value="1">Instructor</option>
    			<option value="3">TA</option>
    	  </select><br/>
        <input form="account_Creation" type="submit" name="create_Account" value ="Create Account">
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