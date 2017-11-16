<?php
$mysqli = new mysqli('localhost', 'root', 'R0binson', 'CSCC01');
if (isset($_POST['f_set_visibility'])) {
    set_visibility($_POST['a_id'], $_POST['a_vis']);
}

/**
 * Set the visibility of an assignment
 *
 * @param $a_id:  the id of the assignment to set
 * @param $a_vis: the visibility status to set
 */
function set_visibility($a_id, $a_vis) {
    global $mysqli;
    $query = "UPDATE assignments SET visible=$a_vis WHERE assignment_id=$a_id";
    if ($mysqli->query($query) === FALSE) {
        echo json_encode(array("FAILED"));
    } else {
    echo json_encode(array("SUCCESS"));
    }
}
$mysqli->close();
?>
