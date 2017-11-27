<?php
require_once 'Database.php';
$db = new Database();

/**
 * Set the visibility of an assignment
 *
 * @param $a_id:  the id of the assignment to set
 * @param $a_vis: the visibility status to set
 */
function set_visibility($a_id, $a_vis) {
    global $db;
    $sql = "UPDATE assignments SET visible=$a_vis WHERE assignment_id=$a_id";
    if ($db->query($sql) === FALSE) {
        echo json_encode(array("FAILED"));
    } else {
        echo json_encode(array("SUCCESS"));
    }
}

/**
 * Set the visibility of an assignment
 *
 * @param $c_id:    the id of the course to set
 * @param $u_id:    the id of the user to set
 * @param $u_enrol: the new enrolment status
 * @param $table:   the table to put user and course enrolment in
 */
function set_enrolment($c_id, $u_id, $u_enrol, $table) {
    global $db;
    if ($u_enrol) {
        $sql = "INSERT INTO $table (user_id, course_id) VALUES ($u_id, $c_id)";
    } else {
        $sql = "DELETE FROM $table WHERE user_id=$u_id AND course_id=$c_id";
    }
    if ($db->query($sql) === FALSE) {
        echo json_encode(array("FAILED"));
    } else {
        echo json_encode(array("SUCCESS"));
    }
}

if (isset($_POST['f_set_enrolment'])) {
    set_enrolment($_POST['c_id'], $_POST['u_id'], $_POST['u_enrol'], $_POST['table']);
}
if (isset($_POST['f_set_visibility'])) {
    set_visibility($_POST['a_id'], $_POST['a_vis']);
}
?>
