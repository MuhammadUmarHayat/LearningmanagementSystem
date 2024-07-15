<?php 
	$C_ID = $_GET['C_ID'];
	$title = $_GET['title'];
	$SQ_ID = $_GET['SQ_ID']; ?>


<div class="modal fade" id="MarkSQModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Mark Quiz</h4>
			</div>
			<div class="modal-body">
				<form action="" method="POST">
				
					<div class="form-group">
						<label for="">Marks</label>
						<input type="hidden" name="ID" id="sq_id">
						<input type="hidden" name="CourseID" value="<?=$_GET['C_ID']?>" >
				 		<input type="hidden" name="C_Title" value="<?=$_GET['title']?>">
				 		<input type="hidden" name="SQ_ID" value="<?=$_GET['SQ_ID']?>">
						<input type="number" class="form-control" name="marks"  placeholder="Marks" required>
					</div>
					<div class="form-group">
						<label for="">Comments</label>
						<input type="text" class="form-control" name="comments"  placeholder="Comments" required>
					</div>
					<br><button type="submit" name="Mark_Quiz" class="btn btn-primary pull-right">Mark</button><br><br>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-offset-1 col-sm-10"><br><br>

		<div class="panel panel-primary">
			<div class="panel-heading as-bg">
				<h2 class="panel-title pull-left" style="margin-top: 5px"><b>Short Quiz Submissions</b> (<?=$_GET['title']?>)</h2>
				<span class="pull-right">
					<a href="index.php?page=add_short_quiz&C_ID=<?=$C_ID?>&title=<?=$title?>" class="btn btn-primary txtBlack btn-sm"><i class="fa fa-arrow-left"></i> Back</a><br>
				</span>
			</div>
				<div class="panel-body">
					<table id="table" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>ID</th>
								<th>Student Name</th>
								<th>Submission Date</th>
								<th>Solution</th>
								<th>Status</th>
								<th>Marks</th>
							</tr>
						</thead>
					<tbody>

		<?php 
		$i = 1;

		$result = mysqli_query($con, "SELECT * FROM short_quiz_solutions AS SQS JOIN students AS S ON SQS.S_ID = S.ID  WHERE SQS.SQ_ID = '$SQ_ID'");
		while ($row = mysqli_fetch_array($result)) {
		     echo "<tr>
						<td>$i</td>
						<td>$row[name]</td>
						<td class='text-success'>$row[submissionDate]</td>
						<td>$row[solution]</td>";
						if ($row['5'] == "") {
							echo "<td><a href='#' ID='$row[0]' class='btn btn-success btn-xs MarkQuiz'>Mark Quiz</a></td>
							<td> -- </td>";
						} else {
							echo "<td class='text-success'><b>$row[5]</b></td>
								  <td>$row[marks]
								  <a href='index.php?page=short_quiz_submissions&Reset=Yes&ID=$row[0]&C_ID=$_GET[C_ID]&title=$_GET[title]&SQ_ID=$_GET[SQ_ID] class='btn btn-danger btn-xs'><span class='glyphicon glyphicon-refresh'></span></a>
								  </td>";
						}
						
						
					echo"</tr>";
			$i++;
		 } ?>
		 </tbody>
		 </table>
				</div>
		</div>
	</div>
</div>

<?php 
	if (isset($_POST['Mark_Quiz'])) {
	 	
	 	$ID = $_POST['ID'];
	 	$marks = $_POST['marks'];
	 	$comments = $_POST['comments'];
	 	$status = "Marked";

	 	$CourseID = $_POST['CourseID'];
	 	$C_Title = $_POST['C_Title'];
	 	$SQ_ID = $_POST['SQ_ID'];

	 	$qry = mysqli_query($con, "UPDATE short_quiz_solutions SET status = '$status', marks = '$marks', comments = '$comments' WHERE ID = '$ID'");

	 	if ($qry) {
				echo"<script>
						window.location='index.php?page=short_quiz_submissions&C_ID=$CourseID&title=$C_Title&SQ_ID=$SQ_ID';
				</script>";
			}
			else {
				echo 'Error';
			}

	 }

	 if (isset($_GET['Reset'])) {

	  	$ID = $_GET['ID'];
	  	$CourseID = $_GET['C_ID'];
	 	$C_Title = $_GET['title'];
	 	$SQ_ID = $_GET['SQ_ID'];
	 	$status = "";

	 	$qry = mysqli_query($con, "UPDATE short_quiz_solutions SET status = '$status', marks = '-', comments = '-' WHERE ID = '$ID'");

	 	if ($qry) {
				echo"<script>
						window.location='index.php?page=short_quiz_submissions&C_ID=$CourseID&title=$C_Title&SQ_ID=$SQ_ID';
				</script>";
			}

	  } ?>