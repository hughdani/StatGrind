<?php
    require_once 'Database.php';
    require_once 'User.php';
    require_once 'Utils.php';
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
?>
<html>
<head>
    <title>Leaderboard</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/main.css" />
</head>

<?php
$user_id = $_SESSION['user_id'];

$user_id = 128; //TMP

require_once 'Database.php';
$db = new Database();

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


<body>

<div class="container-fluid">

	<div class="jumbotron">
		<h1>Leaderboard</h1>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-md-offset-2 col-md-3">
				<h3> Your Rank </h3>
				<h1><?= $user_rank; ?></h1>
			</div>
			<div class="col-md-offset-2 col-md-3">
				<h3> Your Score </h3>
				<h1><?= $user_score; ?></h1>
			</div>
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
</body>
</html>
