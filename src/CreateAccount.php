<html>
<head>
  <title>Create New Account</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>

<div class="jumbotron text-center">
  <p>Create New Account</p> 
</div>
  
<div class="container">
  <form method="post" action="AccountLogin.php">
      User Name: <input type="text" name="user_name"><br>
      Password: <input type="text" name="password1"><br>
      Confirm Password: <input type="text" name="password2"><br>
      First Name: <input type="text" name="first_name"><br>
      Last Name: <input type="text" name="last_name"><br>
      Account Type: <input type="text" name="acc_type"><br>
      <input type="submit" value ="Create Account">
    </div>
  </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
