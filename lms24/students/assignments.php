<?php 
	$SID = $_SESSION['USER_ID'];
	$C_ID = $_GET['C_ID'];
	$title = $_GET['title']; ?>


<div class="modal fade" id="Assignment">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Upload Assignment File</h4>
			</div>
			<div class="modal-body">
				<form action="" method="POST" enctype="multipart/form-data">
				
					<div class="form-group">
						<label for="">Select File</label>
						<input type="hidden" name="aid" id="aid">
						<input type="hidden" name="CourseID" value="<?=$_GET['C_ID']?>" >
			 			<input type="hidden" name="C_Title" value="<?=$_GET['title']?>">
						<input type="file" name="file" class="form-control"  required>
					</div><br>
					<button type="submit" name="Upload" class="btn btn-info btn-sm pull-right">Upload</button><br><br>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-offset-1 col-sm-10"><br><br>
		
		<?php 
			if (isset($_GET['Error'])) { ?>
			 	<div class="alert alert-danger">
			 		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			 		<strong>Invalid File Extension</strong> Only .docx extension files are allowed
			 	</div>
		<?php } ?>

		<div class="panel panel-primary">
			<div class="panel-heading as-bg" style="">
				<h2 class="panel-title pull-left" style="margin-top: 5px"><b>Assignments</b></h2>
				<span class="pull-right">
					<a href="index.php?page=course_website&C_ID=<?=$C_ID?>&title=<?=$title?>" class="btn btn-primary txtBlack btn-sm"><i class="fa fa-arrow-left"></i> Back</a><br>
				</span>
			</div>
				<div class="panel-body">
					
					<table class="table table-bordered table-striped">
						<tr>
							<th>ID</th>
							<th>Title</th>
							<th>Assignment</th>
							<th>Due Date</th>
							<th>Total Marks</th>
							<th>Submit</th>
							<th>Result</th>
							<th>Comments</th>
						</tr>
					

		<?php 
		
		$i = 1;

		$result = mysqli_query($con, "SELECT * FROM course_assignment WHERE C_ID = '$C_ID'");
		while ($row = mysqli_fetch_array($result)) {
			$AID = $row['ID'];

			$Up_Query = mysqli_query($con, "SELECT * FROM upload_assignment WHERE A_ID = '$AID' AND S_ID = '$SID'");
			$count = mysqli_num_rows($Up_Query);
		     echo "<tr>
					<td>$i</td>
					<td>$row[title]</td>
					<td><a href='../assets/assignment_question/$row[assignment]' class='btn btn-info btn-xs' download><i class='fa fa-download'> Download</a></td>
					<td>$row[dueDate]</td>
					<td>$row[total_marks]</td>";
					$end=date_create($row['dueDate']);
					$now = new DateTime();
					if($end < $now) {
						if ($count > 0) {
							$dtls = mysqli_fetch_array($Up_Query);
							echo "<td class='text-danger'> Submitted <br> <small>$dtls[submissionDate]</small></td>
							<td>$dtls[marks]</td>
							<td>$dtls[comments]</td>";
						} else {
							echo "<td><a href='#' ID='$AID' class='btn btn-success btn-xs SubmitAssignment'>Submit</a></td> <td>--</td>";
						}
						

					}
					else{
						echo "<td class='text-danger'><b>Closed</b></td>";
					}
					
				echo"</tr>";
			$i++;
		 } ?>
		 </table>
				</div>
		</div>
	</div>
</div>

<?php 
	if (isset($_POST['Upload'])) {
	 	$ext = explode(".", $_FILES['file']['name']);
		
	 	$CourseID = $_POST['CourseID'];
	 	$C_Title = $_POST['C_Title'];
	 	$A_ID = $_POST['aid'];
	 	$submissionDate = date("d F, Y");

	 	$fileName = time().".".$ext[1];

	 	if ($ext[1] == "docx" OR $ext[1] == "doc" OR $ext[1] == "pdf") {
	 		$tempName = $_FILES['file']['tmp_name'];
		 	move_uploaded_file($tempName, "../assets/assignment_solutions/$fileName");

		 	$query = "INSERT INTO upload_assignment SET  S_ID = '$SID', A_ID = '$A_ID', submissionDate = '$submissionDate', assignment = '$fileName'";
		 	$result = mysqli_query($con, $query);

		 	if ($result) {
				echo"<script>
						window.location='index.php?page=assignments&C_ID=$CourseID&title=$C_Title';
				</script>";
			}
			else {
				echo 'Error<br>'.$query;
			}
	 	} else {
	 		echo"<script>
						window.location='index.php?page=assignments&C_ID=$CourseID&title=$C_Title&Error=Invalid Extension';
				</script>";
	 	}
	 } ?>