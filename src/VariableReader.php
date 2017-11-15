<?php 

$text = '$a=random_int(0,5) + $b=random_int(0,100)'
$form = '$a+$b';

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
			$endstr = explode(")", $start[1]);
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

?>
