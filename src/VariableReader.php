<?php

include 'dependencies/wa_wrapper/WolframAlphaEngine.php';

function varreader($questiontext, $formula) {

	$space = explode(" ", $questiontext);
	$varnames = array();
	$returntext = "";
	foreach ($space as &$elm) {
		if (strpos($elm, 'random_') !== false) {
			$split = explode("=", $elm);
			$var = $split[0];
			$type = explode("(", $split[1]);
			$startstr = explode(",", $type[1]);
			$endstr = explode(")", $startstr[1]);
			$start = $startstr[0];
			$end = $endstr[0];
			if ($type[0] == "random_int") {
				$randint = rand($start, $end);
				$varnames[$var] = $randint;
				$returntext = $returntext . $randint . " ";
			}
			if ($type[0] == "random_real") {
				$randint = rand($start*100, $end*100) / 100;
				$varnames[$var] = $randint;
				$returntext = $returntext . $randint . " ";
			}
		} else {
			$returntext = $returntext . $elm . " ";
		}
	}
	foreach ($varnames as $name => $theint) {
		$formula = str_replace($name, $theint, $formula);
	}
	$returnarray = array();
	$returnarray[] = $returntext;
	$returnarray[] = $formula;
	return $returnarray;
}

// use wolfram alpha to calculate formula
function computeFormula($formulatext) {
    // create instance of api
    $engine = new WolframAlphaEngine('R4AW9W-39U3QJHUQ4');

    // get query info
    $resp = $engine->getResults($formulatext);

    // get data pods back
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
}

?>
