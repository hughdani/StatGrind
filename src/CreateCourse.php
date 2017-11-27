<?php
require_once 'Database.php';
require_once 'User.php';
require_once 'Utils.php';
$db = new Database();

if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['user'])) {
    header("Location: Forbidden.php");
} elseif (!$db->pagePermission(basename(__FILE__), $_SESSION['user'])) {
    header("Location: Forbidden.php");
}

create_head('Create Course');
?>
<form method='post' action='EditCourses.php'>
  <div class='form-group'>
    <label for='new_cname'>New Course Name</label>
    <input id='new_cname' type='text' name='new_cname' placeholder='Course Name' class='form-control'>
  </div>

  <div class='form-group'>
    <label for='new_cdesc>'>New Course Description</label>
    <textarea id='new_cdesc' name='new_cdesc' placeholder='Course Description' class='form-control'></textarea>
  </div>

  <div class='form-group'>
    <input type='submit' name='create_course' value='Add Course' class='btn btn-default'> 
</form>
