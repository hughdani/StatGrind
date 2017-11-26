<?php
$page_redirected_from = $_SERVER['REQUEST_URI'];  // this is especially useful with error 404 to indicate the missing page.
$server_url = "http://thatbitcoinguy.com/L02_01/src/";
$redirect_url = $_SERVER["REDIRECT_URL"];

switch(getenv("REDIRECT_STATUS"))
{
	# "400 - Bad Request"
	case 400:
	$error_code = "400 - Bad Request";
	$explanation = "The syntax of the URL submitted by your browser could not be understood. Please verify the address and try again.";
	$redirect_to = "index.php";
	break;

	# "401 - Unauthorized"
	case 401:
	$error_code = "401 - Unauthorized";
	$explanation = "This section requires a password or is otherwise protected. If you feel you have reached this page in error, please return to the login page and try again, or contact the webmaster if you continue to have problems.";
	$redirect_to = "index.php";
	break;

	# "403 - Forbidden"
	case 403:
	$error_code = "403 - Forbidden";
	$explanation = "This section requires a password or is otherwise protected. If you feel you have reached this page in error, please return to the login page and try again, or contact the webmaster if you continue to have problems.";
	$redirect_to = "index.php";
	break;

	# "404 - Not Found"
	case 404:
	$error_code = "404 - Not Found";
	$explanation = "The requested resource '" . $page_redirected_from . "' could not be found on this server. Please verify the address and try again.";
	$redirect_to = "index.php";
	break;

	# "500 - Internal Server Error"
	case 500:
	$error_code = "500 - Internal Server Error";
	$explanation = "The server experienced an unexpected error. Please verify the address and try again.";
	$redirect_to = "index.php";
	break;
}
?>

<html>
<head>
	<title>Page not found: <?php echo ($redirect_to); ?></title>

</head>
<body>

<h1>Error Code <?php echo ($error_code); ?></h1>
<img src="http://2.bp.blogspot.com/-2RS14e7Z5Zs/VN0VyBmGKLI/AAAAAAAABfE/XcmQJWEp26o/s1600/racoon.jpg">
<h1>Seems like something went wrong.</h1>
<p>The URL you requested was not found. <?PHP echo($explanation); ?></p>

<p><strong>Click <a href="<?php echo ($redirect_to); ?>">here</a> to return to the home page</strong> </p>

<p>Click <a href="<?php echo ($server_url); ?>">here</a> to return to the login page</p>

<hr />

<p><i>CSCC01 Fall 2017 Project <a href="https://github.com/CSCC01F17/L02_01">GITHUB</a>.</i></p>


</body>
</html>