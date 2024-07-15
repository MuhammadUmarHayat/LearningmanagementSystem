<?php 
	$C_ID = $_GET['C_ID'];
	$title = $_GET['title']; ?>

<div class="row">
	<div class="col-sm-offset-1 col-sm-10"><br><br>
		
		<?php 
			if (isset($_GET['Error'])) { ?>
			 	<div class="alert alert-danger">
			 		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			 		<strong>Invalid File Extension</strong> Only .docx extension files are allowed
			 	</div>
			<?php } ?>

		<a class="btn btn-warning text-black" data-toggle="modal" href='#UploadAssignment'>Add Assignment</a>
		<br><br>
		<div class="modal fade" id="UploadAssignment">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Add New Assignment</h4>
			</div>
			<div class="modal-body">
				<form action="" method="POST" enctype="multipart/form-data">
			 		<label>Title</label>
			 		<input type="hidden" name="CourseID" value="<?=$_GET['C_ID']?>" >
			 		<input type="hidden" name="C_Title" value="<?=$_GET['title']?>">
			 		<input type="text" name="title" class="form-control" required placeholder="Title"><br>
			 		<label>Due Date</label>
			 		<input type="date" name="dueDate" class="form-control" required><br>
			 		<label>Total Marks</label>
			 		<input type="number" name="marks" class="form-control" required placeholder="Total Marks"><br>
			 		<label>Assignment File</label>
			 		<input type="file" name="file" class="form-control" required><br>
			 		<input type="submit" name="AddAssignment" value="Upload Assignment" class="btn btn-success pull-right"><br><br>
		 	</form>
			</div>
		</div>
	</div>
</div>


		<div class="panel panel-primary">
			<div class="panel-heading as-bg" style="">
				<h2 class="panel-title pull-left" style="margin-top: 5px"><b>Scheduled Assignments</b> (<?=$_GET['title']?>)</h2>
				<span class="pull-right">
					<a href="index.php?page=teacher_courses" class="btn btn-primary txtBlack btn-sm"><i class="fa fa-arrow-left"></i> Back</a><br>
				</span>
			</div>
				<div class="panel-body">
					<table class="table table-bordered table-striped">
						<tr>
							<th>ID</th>
							<th>Title</th>
							<th>Due Date</th>
							<th>Total Marks</th>
							<th>Assignment File</th>
							<th>Submissions</th>
						</tr>
					

		<?php 
		$i = 1;

		$result = mysqli_query($con, "SELECT * FROM course_assignment WHERE C_ID = '$C_ID'");
		while ($row = mysqli_fetch_array($result)) {
		     echo "<tr>
					<td>$i</td>
					<td>$row[title]</td>
					<td class='text-success'>$row[dueDate]</td>
					<td class='text-danger'>$row[total_marks]</td>
					<td><a href='index.php?page=readWord&File=$row[assignment]&C_ID=$C_ID&title=$title&Type=Question'> Read File </a>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<a href='../assets/assignment_question/$row[assignment]' download> <i class='fa fa-download'></i> </a>
					</td>
					<td><a href='index.php?page=submissions&C_ID=$C_ID&title=$title&A_ID=$row[ID]'> Submissions </a>
					</td>
				   </tr>";
			$i++;
		 } ?>
		 </table>
				</div>
		</div>
	</div>
</div>


<?php 
	if (isset($_POST['AddAssignment'])) {

		$ext = explode(".", $_FILES['file']['name']);
		
	 	$CourseID = $_POST['CourseID'];
	 	$C_Title = $_POST['C_Title'];
	 	$title = $_POST['title'];
	 	$marks = $_POST['marks'];
	 	$date = $_POST['dueDate'];
	 	$dueDate = date("d F, Y", strtotime($date));

	 	$fileName = time().".".$ext[1];

	 	if ($ext[1] == "docx" OR $ext[1] == "doc" OR $ext[1] == "pdf") {
	 		$tempName = $_FILES['file']['tmp_name'];
		 	move_uploaded_file($tempName, "../assets/assignment_question/$fileName");

		 	$query = "INSERT INTO course_assignment SET  C_ID = '$CourseID', title = '$title', dueDate = '$dueDate', total_marks = '$marks', assignment = '$fileName'";
		 	$result = mysqli_query($con, $query);

		 	if ($result) {
				echo"<script>
						window.location='index.php?page=schedule_assignment&C_ID=$CourseID&title=$C_Title';
				</script>";
			}
			else {
				echo 'Error<br>'.$query;
			}
	 	} else {
	 		echo"<script>
						window.location='index.php?page=schedule_assignment&C_ID=$CourseID&title=$C_Title&Error=Invalid Extension';
				</script>";
	 	}
	 	

	 	
	 }
	 

	  ?>