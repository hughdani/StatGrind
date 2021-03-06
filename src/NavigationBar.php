<div class="navbar navbar-default">
    <div class="navbar-header">
      <a class="navbar-brand" href="Home.php"><span class="fa fa-home"></span> StatGrind</a>
    </div>
    <ul class="nav navbar-nav">
    <?php      
    require_once 'Database.php';
    require_once 'User.php';
    require_once 'Utils.php';
    if (!isset($_SESSION)) {
        session_start();
    }
    $user = $_SESSION['user'];
    $account_type = $user->getAccountType();
	// Generate navigation bar options based on account type
	$sql = "SELECT pages.name, pages.filename FROM permissions LEFT JOIN pages on permissions.page_id = pages.page_id where pages.nav_item = 1 AND permissions.account_type = $account_type";
        foreach ($db->query($sql) as $p) {
	    $pageName = $p['name'];
	    $address = $p['filename']; ?>
            <li><a href="javascript:void(0)" onClick="navLink('<?php echo $address?>','<?php echo $pageName?>')"><?=$pageName;?></a></li>
	<?php        
	} ?>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="index.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
    </ul>
</div>

<script>
function navLink(address, pagename) {
    var form = document.createElement("form");
    var element1 = document.createElement("input"); 

    form.method = "POST";
    form.action = address;   

    element1.value=pagename;
    element1.name="name";
    form.appendChild(element1);  

    document.body.appendChild(form);

    form.submit();
}
</script>

