<?php
include "enviornment_variables.php";
include "header.php";
logged_in();
$gwid = $_SESSION["gwid"];

if (isset($_POST)) {
	var_dump();
	if (empty($_POST['major'])) {
		$error = 1;
	} else {
		$sql = "UPDATE Students SET major = '{$_POST['major']}' WHERE gwid = '{$_SESSION['gwid']}'";
		if (!$conn->multi_query($sql)) {
	    	printf("Errormessage: %s\n", $conn->error);
	    	exit;
		}
		$_SESSION['major'] = $_POST['major'];
		header('Location: ballots.php');
		exit;
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
 	<!-- JS defines button clicks -->
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3>Select Your Major</h3>
				</div>
				<div class="panel-body">
					<?php if (!empty($error)) { ?>
						<div class="alert alert-danger" role="alert">
							<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
							<span class="sr-only">Error:</span>
							Please choose a Major
						</div>
					<?php } ?>
					<form class="" action="select_major.php" method="post">
						<div class="form-group">
							<label for="major">Select your current major:</label>
							<select id="major" name="major">
								<option value="">Select one...</option>
								<option value="APSC">Applied Science</option>
								<option value="BME">Biomedical Engineering</option>
								<option value="CE">Computer Engineering</option>
								<option value="CEE">Civil Engineering</option>
								<option value="CS">Computer Science</option>
								<option value="EE">Electical Engineering</option>
								<option value="MAE">Mechanical Engineering</option>
								<option value="EMSE">Systems Engineering</option>
						  	</select>
						</div>
		  				<div class="col-md-4 col-md-offset-4">
							<button type="submit" class="btn btn-primary form-control">Select</button>
						</div>
					</form>
				</div>
			</div>
			</div>
		</div>
	</div>
</body>
</html>

