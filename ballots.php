<?php
include "environment_variables.php";
include "header.php";
logged_in();

$sql = "SELECT * FROM Students WHERE (gwid='{$_SESSION['gwid']}')";
$results = $conn->query($sql);

$ballots = array();
/* fetch associative array */
while ($row = mysqli_fetch_array($results)) {
    if (!$row['faculty_vote'] && !$_SESSION['faculty_vote']) {
    	$ballots['Professor of the Year'] = "professor_of_the_year";
    	//array_push($ballots, "Faculty Election");
    }
    if (!$row['senior_vote'] && $row['year'] == "Senior" && !$_SESSION['senior_vote']) {
    	$ballots['Senior Award'] = "senior_award";
    	//array_push($ballots, "Senior Election");
    }
    $ballots['Fun Award'] = "fun_award";
}

if (empty($ballots)) {

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
	<script>
		$( document ).ready(function() {
    		$('#professor_of_the_year').click(function(){
				window.location.href = "faculty_election.php";
			});

			$('#senior_award').click(function() {
				window.location.href = "senior_election.php";
			});

			$('#fun_award').click(function() {
				window.location.href = "fun_award.php";
			})
		});
	</script>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3>E-Ball Award Elections</h3>
				</div>
				<div class="panel-body">
					<?php if (empty($ballots)) { ?>
					<div class="alert alert-success" role="alert">
						<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
						<span class="sr-only">Error:</span>
						You've voted in every poll
					</div>
					<?php } else { ?>
					<div class="alert alert-warning" role="alert">
						<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
						<span class="select-major">Current Major: <?php echo $_SESSION['major']?></span>
						<span class="select-major"><a href="select_major.php">Click here if incorrect</a></span>
					</div>
					<?php
						foreach ($ballots as $key=>$value) {
							echo "<div class='col-md-6'><button class='btn btn-primary btn-block' id='{$value}'>{$key}</button></div>";
						}
					}
					?>
				</div>
			</div>
			</div>
		</div>
	</div>
</body>
</html>

