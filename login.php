<?php

if (isset($_POST['gwid'])) {

	include "environment_variables.php";
	include "header.php";

	$gwid = mysqli_real_escape_string($conn, $_POST["gwid"]);
	$sql = "SELECT * FROM Students WHERE (gwid='{$gwid}')";
	$results = $conn->query($sql);
	
	if ($results->num_rows > 0) {
		session_start();
		// Set their gwid in the session
		$_SESSION['gwid'] = $gwid;

		// Determine their major and set it in the session
		while ($row = mysqli_fetch_array($results)) {
			$_SESSION['major'] = $row['major'];
			$_SESSION['fun_vote'] = $row['fun_vote'];
			$_SESSION['faculty_vote'] = $row['faculty_vote'];
			if ($row['year'] == "Senior") {
				$_SESSION['senior_vote'] = $row['senior_vote'];
			} else {
				$_SESSION['senior_vote'] = 1;
			}
			if ($row['major'] == "UND" || $row['major'] == NULL) {
				header('Location: select_major.php');
				exit;
		    }
		}

		header('Location: ballots.php');
		exit;
	} else {
		$error = "Your GWID does not match any on record";
	}
}
?>

<html>
<head>
	<!-- JQuery and JQuery UI -->
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
 	<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
 	<!-- Bootstrap -->
 	<script src="js/bootstrap.min.js"></script>
 	<link href="css/bootstrap.min.css" rel="stylesheet">
 	<link href="css/election.css" rel="stylesheet">
</head>
<body>
<div class="container">
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3>E-Ball Award Elections</h3>
			</div>
			<div class="panel-body panel-body-center">
			<?php if ($error != NULL) { ?>
				<div class="alert alert-danger" role="alert">
					<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					<span class="sr-only">Error:</span>
					Your GWID does not match any on record
				</div>
			<?php } ?>
			<h4>Welcome to the Engineer's Ball 2015 Elections. Upon a successful log-in you will be presented with three possible categories; Professor of the Year, Senior Awards (Seniors only), and Fun Awards. <strong>Log-in using your GWid.</strong></h4>
			<form class="form-inline" action="login.php" method="post">
				<div class="form-group">
					<label for="gwid">GWID: </label>
					<input class="form-control" type="text" name="gwid" id="gwid"><br>
				</div>
				<button type="submit" class="btn btn-primary">Login</button>
			</form>
			</div>
		</div>
		</div>
	</div>
</div>
</body>
</html>