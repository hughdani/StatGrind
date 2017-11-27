<?php
require_once 'Database.php';
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
$edit_time = explode(" ", $time);
$edit_hour = explode(":", $edit_time[1]);
if ($edit_hour[2][2] == "p") {
	$new_hour = $edit_hour[0] + 12;
	$current_time = $edit_time[0] . " " . $new_hour . ":" . $edit_hour[1] . ":" . $edit_hour[2][0] .  $edit_hour[2][1];
} else {
	$current_time = $edit_time[0] . " " . $edit_hour[0] . ":" . $edit_hour[1] . ":" . $edit_hour[2][0] .  $edit_hour[2][1];
}
return $current_time
}
?>
