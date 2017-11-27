<?php
require_once 'Database.php';
require_once 'User.php';
require_once 'Utils.php';

if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['user'])) {
    header("Location: error.php");
}

create_head('Home');

$db = new Database();
$user = $_SESSION['user'];
$account_type = $user->getAccountType();
$sql = "SELECT name, filename
    FROM pages
    INNER JOIN permissions ON pages.page_id = permissions.page_id
    WHERE pages.home_item=1 AND permissions.account_type=$account_type";
echo "<div class='container'>";
foreach ($db->query($sql) as $p) {
    create_page_link($p['filename'], $p['name']);
}
echo "</div>";
