<?php
if (isset($_POST['a_id']) && isset($_POST['a_vis'])) {
    set_visibility($_POST['a_id'], $_POST['a_vis']);
}

// set the visibility of assignment given by $a_id to $a_vis
function set_visibility($a_id, $a_vis) {
    $mysqli = new mysqli('localhost', 'root', 'R0binson', 'CSCC01');
    $upquery = "UPDATE assignments SET visible=$a_vis WHERE assignment_id=$a_id";
    if ($mysqli->query($upquery) === FALSE) {
        echo json_encode(array($mysqli->error));
    }
    $mysqli->close();
    echo json_encode(array($upquery));
}
?>
