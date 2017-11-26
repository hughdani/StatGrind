<?php
require_once 'Database.php';
require_once 'User.php';
require_once 'Utils.php';

if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['user'])) {
    header("Location: Forbidden.php");
}

create_head('Home');

$db = new Database();
$user = $_SESSION['user'];
echo "<div class='container'>";
foreach ($db->query("SELECT name, filename FROM pages WHERE home_item=1") as $p) {
    create_page_link($p['filename'], $p['name'], $_SESSION['user']);
}
echo "</div>";
