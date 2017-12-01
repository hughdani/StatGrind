<?php
require_once 'Database.php';
require_once 'User.php';
require_once 'Utils.php';

if (!isset($_SESSION)) {
    session_start();
}
  $db = new Database();

  if (!isset($_SESSION)) {
      session_start();
  }
  if (!isset($_SESSION['user'])) {
      header("Location: error.php?error_status=401");
      exit();
  } elseif (!$db->pagePermission(basename(__FILE__), $_SESSION['user'])) {
      header("Location: error.php?error_status=403");
      exit();
  }

create_head('Course Creation');
echo "<body>";

$db = new Database();
$user = $_SESSION['user'];
$first_name = $user->getFirstName();
$account_type = $user->getAccountType();
$header_text = $db->getPageTitle(basename(__FILE__));

include("NavigationBar.php");
create_site_header($header_text);
?>
<div class="container-fluid">
<section class="wrapper style2 special">
<div class="inner narrow">
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
</div>
</section>
</div>
