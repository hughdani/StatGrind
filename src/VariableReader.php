<?php
// Import WolframAlpha API
require_once 'dependencies/wa_wrapper/WolframAlphaEngine.php';

/**
 * Parse and generate random variables in question and formula text.
 *
 * @param $question_text:  The raw text of the question.
 * @param $formula:       The raw text of the solution/formula.
 */
function varreader($question_text, $formula) {
    // Seperate text into elements by spaces
	$space = explode(" ", $question_text);
	$var_names = array();
	$return_text = "";
	foreach ($space as &$elm) {
		// Test if element is a declaration of a random variable.
		if (strpos($elm, 'random_') !== false) {
			$split = explode("=", $elm);
			// Var name.
			$var = $split[0];
			// Var type, real or int.
			$type = explode("(", $split[1]);
			$startstr = explode(",", $type[1]);
			$endstr = explode(")", $startstr[1]);
			// Range Min.
			$start = $startstr[0];
			// Range Max.
			$end = $endstr[0];
			if ($type[0] == "random_int") {
				// Generate random integer, save variable name as key and new int as value.
				$randint = rand($start, $end);
				$var_names[$var] = $randint;
				// Append new question text.
				$return_text = $return_text . $randint . " ";
			}
			if ($type[0] == "random_real") {
				// Generate random integer, save variable name as key and new int as value.
				$randint = rand($start*100, $end*100) / 100;
				$var_names[$var] = $randint;
				// Append new question text.
				$return_text = $return_text . $randint . " ";
			}
		} else {
			// If not a random variable, append text to new question text.
			$return_text = $return_text . $elm . " ";
		}
	}
	$numbvar = 0;
	// For each variable in the var_names array, replace any instance of it in the formula with the generated value.
	foreach ($var_names as $name => $theint) {
		$formula = str_replace($name, $theint, $formula);
		$numbvar = $numbvar + 1;
	}
	// Build return array, 0 is new question text, 1 is new formula.
	$return_array = array();
	$return_array[] = $return_text;
	$return_array[] = $formula;
	$return_array[] = $numbvar;
	return $return_array;
}


/**
 * Use wolfram alpha api to calculate formula.
 *
 * @param $formulatext:  Formula text to calculate.
 */
function computeFormula($formulatext) {
    // create instance of api
    $engine = new WolframAlphaEngine('R4AW9W-39U3QJHUQ4');

    // get query info
    $resp = $engine->getResults($formulatext);

    // get data pods back
    if ( count($resp->getPods()) > 0 ) {
    	$pod = $resp->getPods();

    	// select the wanted pod
    	$pod = $pod[1];

    	// search for the plaintext pod
    	foreach($pod->getSubpods() as $subpod){
        	if($subpod->plaintext){
            		$plaintext = $subpod->plaintext;
                    	break;
        	}
    	}

    	// print the answer
    	return $plaintext;
    } else {
	return "error";
    }
}
?>
