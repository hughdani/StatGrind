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
$first_name = $user->getFirstName();
$account_type = $user->getAccountType();
$header_text = "Welcome back $first_name!";


include("NavigationBar.php");

//create_site_header($header_text);
?>
<body>
<section class="wrapper style2 special">
<div class="inner narrow">
<?php
$sql = "SELECT name, filename
    FROM pages
    INNER JOIN permissions ON pages.page_id = permissions.page_id
    WHERE pages.home_item=1 AND permissions.account_type=$account_type";
foreach ($db->query("SELECT name, filename FROM pages WHERE home_item=1") as $p) {
    create_page_link($p['filename'], $p['name']);
}
?>
</div>
</section>
</body>
