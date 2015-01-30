<?php
include "environment_variables.php";
include "header.php";
logged_in();
$gwid = $_SESSION["gwid"];

// If they submitted a vote, process the vote
if ($_POST['voted'] == "true") {
	if (empty($_POST['faculty_vote'])) {
		$error = 1;
	} else {
		$faculty_vote = mysqli_real_escape_string($conn, $_POST['faculty_vote']);
		$faculty_comment = mysqli_real_escape_string($conn, $_POST['faculty_comment']);
		$sql = "UPDATE Faculty SET vote_count = vote_count + 1 WHERE id={$faculty_vote};
		UPDATE Students SET faculty_vote=1 WHERE gwid='{$_SESSION['gwid']}';
		INSERT INTO Faculty_Comments (fid, comment) VALUES (faculty_vote}, '{$faculty_comment}')";
		echo $sql;
		if (!$conn->multi_query($sql)) {
	    	printf("Errormessage: %s\n", $conn->error);
		}
		header('Location: ballots.php');
		exit;
	}
}

// Create the array of faculty members
$sql = "SELECT * FROM Faculty WHERE (major='{$_SESSION['major']}')";
$results = $conn->query($sql);

$faculty_array = array();
while ($row = mysqli_fetch_array($results)) {	
	$faculty_array[$row['id']] = $row['name'];
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
			<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="btn-group pull-left back-icon-btn">
						<a href="ballots.php" class="btn btn-default"><span class="glyphicon glyphicon-share-alt icon-flipped"></span></a>
					</div>
					<h3>Professor of the Year</h3>
				</div>
				<div class="panel-body">
				<?php if (!empty($error)) { ?>
				<div class="alert alert-danger" role="alert">
					<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					<span class="sr-only">Error:</span>
					You must select a Professor
				</div>
				<?php } ?>
				<h4>Each department votes on the Professor of the Year. The Professor of the Year should demonstrate exemplary work inside and outside the classroom. He or she should go above and beyond to help students achieve their academic goals as well as inspire students to keep pushing towards their engineering futures. Thank you for taking the time to vote. Remember you can vote only once!</h4>
				<form class="" action="faculty_election.php" method="post">
					<div class="form-group">
						<label for="faculty_vote">Which professor would you like to vote for as the Professor of the Year? </label>
						<select id="faculty_vote" name="faculty_vote">
							<option value="">Select one...</option>
						<?php
							foreach($faculty_array as $id => $faculty) {
								echo "<option value='{$id}'>{$faculty}</option>";
							}
						?>
					  	</select>
					</div>					
					<div class="form-group">
						<label for="faculty_comment">Please describe your reasons for choosing the professor as well as any examples of their
						outstanding work in and out of the classroom:</label>
	  					<textarea class="form-control" id="faculty_comment" name="faculty_comment"></textarea>
	  				</div>
	  				<input type="hidden" name="voted" value="true">
	  				<div class="col-md-4 col-md-offset-4">
						<button type="submit" class="btn btn-primary form-control">Vote!</button>
					</div>
				</form>
				</div>
			</div>
			</div>
		</div>
	</div>
</body>
</html>