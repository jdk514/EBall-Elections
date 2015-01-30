<?php
include "environment_variables.php";
include "header.php";
logged_in();
$gwid = $_SESSION["gwid"];

// If they submitted a vote, process the vote
if ($_POST['voted'] == "true") {
	if (empty($_POST['award']) || empty($_POST['student']) || empty($_POST['comment'])) {
		$error = 1;
	} else {
		$award = mysqli_real_escape_string($conn, $_POST['award']);
		$student = mysqli_real_escape_string($conn, $_POST['student']);
		$comment = mysqli_real_escape_string($conn, $_POST['comment']);
		$sql = "INSERT INTO Fun_Vote (award_name, student, comment)
				VALUES ('{$award}', '{$student}', '{$comment}');
				UPDATE Students SET fun_vote = 1 WHERE gwid = '{$_SESSION['gwid']}'";
		if (!$conn->multi_query($sql)) {
	    	printf("Errormessage: %s\n", $conn->error);
	    	exit;
		}
		header('Location: ballots.php');
		exit;
	}
}

// Create the array of faculty members
$sql = "SELECT * FROM Students";
$results = $conn->query($sql);

$student_array = array();
while ($row = mysqli_fetch_array($results)) {
	$student_array[] = $row['firstname'] . " " . $row['lastname'];
}
?>
<html>
<head>
 	<link href="css/bootstrap.min.css" rel="stylesheet">
 	<link href="css/election.css" rel="stylesheet">
 	<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/blitzer/jquery-ui.min.css" rel="stylesheet">
	<!-- JQuery and JQuery UI -->
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
 	<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
 	<!-- Bootstrap -->
 	<script src="js/bootstrap.min.js"></script>
 	<script>
 	$( document ).ready(function() {
	 	data = [
	 	<?php
	 		foreach ($student_array as $student) {
	 			echo "'$student',";
	 		}
	 	?>
	 	]
		$( "#student" ).autocomplete({
		  	source: function( request, response ) {
		    	var matcher = new RegExp( $.ui.autocomplete.escapeRegex( request.term ), "i" );
		    	response( $.grep( data, function( item ){
		    		return matcher.test( item );
		    	}) );
		    },
		    change: function (event, ui) {
            	if (ui.item == null || ui.item == undefined) {
                	//$("#nut_autocomplete").val("");
            	}
        	}
		});

	});
 	</script>
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
						<h3>Fun Awards!!</h3>
					</div>
					<div class="panel-body">
						<?php if (!empty($error)) { ?>
						<div class="alert alert-danger" role="alert">
							<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
							<span class="sr-only">Error:</span>
							Please Fill out every field!
						</div>
						<?php } ?>
						<h4>Each year The Engineers' Council presents awards to students that demonstrate great SEAS spirit, bring humor and light-heartedness to the classroom and exemplify values that aren't as celebrated as they should be. This voting form allows students to nominate their peers for an award of their choosing, as well as why that student should receive it. Feel free to submit as many different awards as you would like. The Engineers' Council will sort through them and choose a variety to be presented at E-Ball. Thanks for voting!</h4>
						<form action="fun_award.php" method="post">
							<div class="form-group">
							  	<label for="award">Award Name:</label>
								<input type="text" id="award" name="award">
							</div>
							<div class="form-group">
							  	<label for="student">Student Nominee:</label>
								<input id="student" name="student">
							</div>
							<div class="form-group">
								<label for"comment">Please describe why you have chosen to nominate the above student for the award?</label>
							  	<textarea class="form-control" name="comment"></textarea>
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