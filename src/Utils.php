<?php
require_once 'Database.php';
require_once 'User.php';
$db = new Database();
function create_head($title)
{
    echo "<head>";
    echo "<title>$title</title>";
    echo "<link href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' rel='stylesheet'>";
    echo "<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>";
    echo "<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>";
    echo "<link rel='stylesheet' href='css/main.css' />";
    echo "</head>";
}

function create_page_link($page_file, $page_name) {
    global $db;
    echo "<form action='$page_file' method='post'>";
    echo "<input type=submit value='$page_name'>";
    echo "</form>";
}

/**
* Loads a question from file as an associative array
*
* For singleton questions the array will contain the following keys
* 	question_text:		the question description
*	question_formula:	the WolframAlpha formula for computing the solution
*
* For all questions the array will contain the following key
*	type:			the type of question (singleton, multiple-choice)
*
* @param string $path	
*	the path to the question file
* @return array
*	an associative array containing the question info with the corresponding keys
*/
function load_question($path) {
	//TODO create question object and bind this method based on q type 
	$file = fopen($path, "r") or die("Unable to open file $path!");
	$contents = fread($file, filesize($path));
	fclose($file);

	$contents = explode('<br> FORMULA: ', $contents);
	$result = array('question_text' => $contents[0], 'question_formula' => $contents[1], 
			'type' => 'single');
	return $result;
}

/**
* Saves a singleton question
*
* @param string $path 
*	the path to the question file
* @param $text 
*	the question description
* @param $formula
*	the WolframAlpha formula for computing the solution
* @return array
*	an associative array containing the question info with the corresponding keys
*/
function save_question($path, $text, $formula) {
        $contents = $text . "<br> FORMULA: " . $formula;
	return (file_put_contents($path, $contents));
}

// Convert starttime to sql datetime format
// 10/25/2017 9:31 PM to 2017-10-25 21:31:00
function converttime($time) {
	$part = explode(" ", $time);
	$date = explode("/", $part[0]);
	$time = explode(":", $part[1]);
	if ($part[2] == "PM") {
		$time[0] = $time[0] + 12;
	} else {
		if (strlen($time[0]) == 1){
			$time[0] = "0" . $time[0];
		}
	}
	$newtime = $date[2] . "-" . $date[0] . "-" . $date[1] . " " . $time[0] . ":" . $time[1] . ":00";
	return $newtime;	
}

function check_user_permission($file_name)
{
	if (!isset($_SESSION)) {
  		session_start();
	}
	if (!isset($_SESSION['user'])) {
	    header("Location: error.php?error_status=401");
	    exit();
	} elseif (!$db->pagePermission($file_name, $_SESSION['user'])) {
	    header("Location: error.php?error_status=403");
	    exit();
	}
}
?>