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

create_head('Leaderboard');
echo "<body>";

$db = new Database();
$user = $_SESSION['user'];
$first_name = $user->getFirstName();
$account_type = $user->getAccountType();
$header_text = "Rankings";

include("NavigationBar.php");
create_site_header($header_text);

$user_id = $user->getUserId();

// Get user's rank and total score
$sql = "SELECT rank, total_score from (SELECT @rnk := @rnk+1 as 'rank', user_id, total_score FROM leaderboard, (SELECT @rnk := 0) T) LB WHERE user_id = $user_id";
$result = $db->query($sql);
$row = $result->fetch_assoc();
$user_rank = $row['rank'];
$user_score = $row['total_score'];

// Get complete leaderboard with rankings
$sql = "SELECT @rnk := @rnk+1 as 'rank', CONCAT(first_name, ' ', last_name) as 'student', total_score FROM leaderboard, (SELECT @rnk := 0) T";
$result = $db->query($sql);	
?>


<div class="container-fluid">
<section class="wrapper style2 special">
<div class="inner narrow">

	<div class="jumbotron">
		<h1>Leaderboard</h1>
	</div>

	<div class="container">
		<div class="row">
				<h3> Your Rank </h3>
				<h1><?= $user_rank; ?></h1>
				
				<h3> Your Score </h3>
				<h1><?= $user_score; ?></h1>
		</div>
	</div>

	<div class="table-responsive">
		<table>
			<tr>
				<th>Rank</th>
				<th>Student</th>
				<th>Total Score</th>
			</tr>
			<?php while ($row = $result->fetch_assoc()){ ?>
			<tr>
				<td><?= $row['rank']; ?></td>
				<td><?= $row['student']; ?></td>
				<td><?= $row['total_score']; ?></td>
			</tr>
			<?php } ?>
		</table>
	</div>
</div>
</section>
</div>

</body>
</html>
