<?php
$mysqli = new mysqli('localhost', 'root', 'R0binson', 'CSCC01');

// set the visibility of assignment given by $a_id to $a_vis
function set_visibility($a_id, $a_vis) {
    $query = "UPDATE assignments SET visible=$a_vis WHERE assignment_id=$a_id";
    if ($mysqli->query($upquery) === FALSE) {
        echo json_encode(array($mysqli->error));
    }
    echo json_encode(array("Visibility Updated!"));
    $mysqli->close();
}

function set_enrolment($c_id, $u_id, $u_enrol, $table) {
    if ($u_enrol) {
      $query = "INSERT INTO $table (user_id, course_id) VALUES ($u_id, $c_id)"; 
    } else {
      $query = "DELETE FROM $table WHERE user_id=$u_id AND course_id=$c_id"; 
    }
    if ($mysqli->query($upquery) === FALSE) {
        echo json_encode(array($mysqli->error));
    }
    echo json_encode(array("Enrolment Set!"));
    $mysqli->close();
}


//if (isset($_POST['u_id']) && isset($_POST['u_enrol'] && isset($_POST['table']) {
if (isset($_POST['f_set_enrolment'])) {
    set_enrolment($_POST['u_id'], $_POST['u_enrol'], $_POST['table']);
}
// if (isset($_POST['f_set_visibility'])
if (isset($_POST['a_id']) && isset($_POST['a_vis'])) {
    set_visibility($_POST['a_id'], $_POST['a_vis']);
}
?>
