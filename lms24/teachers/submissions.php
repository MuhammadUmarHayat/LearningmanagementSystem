<?php 
	$C_ID = $_GET['C_ID'];
	$title = $_GET['title'];
	$A_ID = $_GET['A_ID']; ?>


<div class="modal fade" id="MarkModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Mark Assignment</h4>
			</div>
			<div class="modal-body">
				<form action="" method="POST">
				
					<div class="form-group">
						<label for="">Marks</label>
						<input type="hidden" name="ID" id="ua_id">
						<input type="text" name="CourseID" value="<?=$_GET['C_ID']?>" >
			 		<input type="hidden" name="C_Title" value="<?=$_GET['title']?>">
			 		<input type="hidden" name="A_ID" value="<?=$_GET['A_ID']?>">
						<input type="number" class="form-control" name="marks"  placeholder="Marks" required>
					</div>
					<div class="form-group">
						<label for="">Comments</label>
						<input type="text" class="form-control" name="comments"  placeholder="Comments" required>
					</div>
					<br><button type="submit" name="Mark_Assignment" class="btn btn-primary pull-right">Mark</button><br><br>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-offset-1 col-sm-10"><br><br>

		<div class="panel panel-primary">
			<div class="panel-heading as-bg">
				<h2 class="panel-title pull-left" style="margin-top: 5px"><b>Assignment Submissions</b> (<?=$_GET['title']?>)</h2>
				<span class="pull-right">
					<a href="index.php?page=schedule_assignment&C_ID=<?=$C_ID?>&title=<?=$title?>" class="btn btn-primary txtBlack btn-sm"><i class="fa fa-arrow-left"></i> Back</a><br>
				</span>
			</div>
				<div class="panel-body">
					<table id="table" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>ID</th>
								<th>Student Name</th>
								<th>Submission Date</th>
								<th>Solution File</th>
								<th>Status</th>
								<th>Marks</th>
							</tr>
						</thead>
					<tbody>

		<?php 
		$i = 1;

		$result = mysqli_query($con, "SELECT * FROM upload_assignment AS UA JOIN students AS S ON UA.S_ID = S.ID  WHERE UA.A_ID = '$A_ID'");
		while ($row = mysqli_fetch_array($result)) {
		     echo "<tr>
						<td>$i</td>
						<td>$row[name]</td>
						<td class='text-success'>$row[submissionDate]</td>
						<td><a href='index.php?page=readWord&File=$row[assignment]&C_ID=$C_ID&A_ID=$A_ID&title=$title&Type=Solution'> Read </a>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<a href='../assets/assignment_solution/$row[assignment]' download> <i class='fa fa-download'></i> </a>
						</td>";
						if ($row['status'] == "") {
							echo "<td><a href='#' ID='$row[0]' class='btn btn-success btn-xs MarkAsimnt'>Mark Assignment</a></td>
							<td> -- </td>";
						} else {
							echo "<td class='text-success'><b>$row[status]</b></td>
								  <td>$row[marks]</td>";
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
	if (isset($_POST['Mark_Assignment'])) {
	 	
	 	$ID = $_POST['ID'];
	 	$marks = $_POST['marks'];
	 	$comments = $_POST['comments'];
	 	$status = "Marked";

	 	$CourseID = $_POST['CourseID'];
	 	$C_Title = $_POST['C_Title'];
	 	$A_ID = $_POST['A_ID'];

	 	$qry = mysqli_query($con, "UPDATE upload_assignment SET status = '$status', marks = '$marks', comments = '$comments' WHERE ID = '$ID'");

	 	if ($qry) {
				echo"<script>
						window.location='index.php?page=submissions&C_ID=$CourseID&title=$C_Title&A_ID=$A_ID';
				</script>";
			}
			else {
				echo 'Error';
			}

	 } ?>