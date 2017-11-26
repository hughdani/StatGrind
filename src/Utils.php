<?php
require_once 'Database.php';
$db = new Database();
function create_head($title)
{
    echo "<head>";
    echo "<title>$title</title>";
    echo "<link href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' rel='stylesheet'>";
    echo "<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>";
    echo "<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>";
    echo "<link rel='stylesheet' href='css/main.css' />";
    echo "</head>";
}

function create_page_link($page_file, $page_name, $user) {
    global $db;
    $vis = !$db->pagePermission($page_file, $user) ? "style='display:none'" : "";
    echo "<form action='$page_file' method='post' $vis>";
    echo "<input type=submit value='$page_name'>";
    echo "</form>";
}
