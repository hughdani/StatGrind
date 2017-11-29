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
    echo "<link rel='icon' href='css/favicon.png'>";
    echo "</head>";
}

function create_page_link($page_file, $page_name) {
    global $db;
    echo "<form action='$page_file' method='post'>";
    echo "<input type=submit value='$page_name'>";
    echo "</form>";
}

function create_site_header($header){
    echo "<div class='container-fluid'>";
    echo "<section id='site_header'>";
    echo "<p>$header</p> ";
    echo "</section>";
    echo "</div>";
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

function current_time() {
	// Get current time, convert to 24hr.
	$current_time = date("Y-m-d h:i:sa");
	$edit_time = explode(" ", $current_time);
	$edit_hour = explode(":", $edit_time[1]);
	if ($edit_hour[2][2] == "p") {
		$new_hour = $edit_hour[0] + 12;
		$current_time = $edit_time[0] . " " . $new_hour . ":" . $edit_hour[1] . ":" . $edit_hour[2][0] .  $edit_hour[2][1];
	} else {
		$current_time = $edit_time[0] . " " . $edit_hour[0] . ":" . $edit_hour[1] . ":" . $edit_hour[2][0] .  $edit_hour[2][1];
	}
    return $current_time;
}

function GetAssignment(){
    global $db;
    // get assignment ID
    $assignment_id = $_POST['assignment_id'];
    echo "<h3><b>Assignment $assignment_id</b></h3>";

    // get filename for question
    $sql = "SELECT location FROM in_assignment LEFT JOIN questions ON in_assignment.question_id=questions.question_id WHERE in_assignment.assignment_id = " . $assignment_id;
    $result = $db->query($sql);
    
    if(mysqli_num_rows($result) > 0){
        $qNum = 1;
        // display each questions from their text file location
        while($row = mysqli_fetch_assoc($result)){
            echo "<div> <b>Question $qNum<b><br>";
            $file = file_get_contents($row['location']);
            $question_text = explode("FORMULA:", $file);
            echo "ANSWER:" . $question_text[1] . "<br><br><div>";
            $qNum = $qNum + 1;
        }
    }
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
