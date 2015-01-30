<?php
include "environment_variables.php";
include "header.php";
logged_in();
$gwid = $_SESSION["gwid"];

// If they submitted a vote, process the vote
if ($_POST['voted'] == "true") {
	if (empty($_POST['nut']) || empty($_POST['bolt']) || empty($_POST['senior_award'])) {
		$error = 1;
	} else {
		$nut = mysqli_real_escape_string($conn, $_POST['nut']);
		$bolt = mysqli_real_escape_string($conn, $_POST['bolt']);
		$senior_award = mysqli_real_escape_string($conn, $_POST['senior_award']);
		$nut_bolt_comment = mysqli_real_escape_string($conn, $_POST['nut_bolt_comment']);
		$senior_award_comment = mysqli_real_escape_string($conn, $_POST['senior_award_comment']);
		$sql = "INSERT INTO Senior_Votes (nut, bolt, senior_award, nut_bolt_comment, senior_award_comment)
				VALUES ('{$nut}', '{$bolt}', '{$senior_award}', '{$nut_bolt_comment}', '{$senior_award_comment}');
				UPDATE Students SET senior_vote = 1 WHERE gwid = '{$_SESSION['gwid']}'";
		if (!$conn->multi_query($sql)) {
	    	printf("Errormessage: %s\n", $conn->error);
	    	exit;
		}
		header('Location: ballots.php');
		exit;
	}
}

// Create the array of faculty members
$sql = "SELECT * FROM Students WHERE (year='Senior')";
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
		$( "#nut_autocomplete" ).autocomplete({
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
		
		$( "#bolt_autocomplete" ).autocomplete({
		  	source: function( request, response ) {
		    	var matcher = new RegExp( $.ui.autocomplete.escapeRegex( request.term ), "i" );
		    	response( $.grep( data, function( item ){
		    		return matcher.test( item );
		    	}) );
		    },
		    change: function (event, ui) {
            	if (ui.item == null || ui.item == undefined) {
                	//$("#bolt_autocomplete").val("");
            	}
        	}
		});

		$( "#senior_award_autocomplete" ).autocomplete({
		  	source: function( request, response ) {
		    	var matcher = new RegExp( $.ui.autocomplete.escapeRegex( request.term ), "i" );
		    	response( $.grep( data, function( item ){
		    		return matcher.test( item );
		    	}) );
		    },
		    change: function (event, ui) {
            	if (ui.item == null || ui.item == undefined) {
                	//$("#senior_award_autocomplete").val("");
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
						<h3>Senior Awards</h3>
					</div>
					<div class="panel-body">
						<?php if (!empty($error)) { ?>
						<div class="alert alert-danger" role="alert">
							<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
							<span class="sr-only">Error:</span>
							Please choose a Senior in every category
						</div>
						<?php } ?>
						<h4>The senior awards given at E-Ball include the Nut &amp; Bolt Award and Senior of the Year. The Nut &amp; Bolt Award is given to a pair of seniors who exemplify the SEAS community values including a great spirit of friendship. The Senior of the Year Award is given to a senior who excels both inside and outside the classroom, contributes to the SEAS community, and inspires other students to do the same. These awards can be voted on only once; please review your votes carefully before submitting your response. Thank you for voting!</h4>
						<form action="senior_election.php" method="post">
							<div class="form-group">
								<label for="nut">Who would you like to select for the Nut &amp; Bolt Award? Please choose 2 seniors.</label>
								<input id="nut_autocomplete" name="nut">
								<input id="bolt_autocomplete" name="bolt">
							</div>
							<div class="form-group">
							  	<label for"nut_bolt_comment">Please describe your reasons for choosing the professor as well as any examples of their outstanding work in and out of the classroom.</label>
							  	<textarea class="form-control" name="nut_bolt_comment"></textarea>
							</div>
							<div class="form-group">
							  	<label for="senior_award">Who would you like to select for the Senior of the Year Award?</label>
								<input id="senior_award_autocomplete" name="senior_award">
							</div>
							<div class="form-group">
								<label for"senior_award">Please describe your reasons for choosing the professor as well as any examples of their outstanding work in and out of the classroom.</label>
							  	<textarea class="form-control" name="senior_award_comment"></textarea>
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