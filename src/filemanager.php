<?php
include_once 'database.php';
$db = new database();

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
?>