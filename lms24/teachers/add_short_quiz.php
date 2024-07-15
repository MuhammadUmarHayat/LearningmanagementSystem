<?php 
	$C_ID = $_GET['C_ID'];
	$title = $_GET['title']; ?>

<div class="row">
	<div class="col-sm-offset-1 col-sm-10"><br><br>

		<a class="btn btn-warning text-black" data-toggle="modal" href='#ShortQuiz'>Add Short Quiz</a>
		<br><br>
		<div class="modal fade" id="ShortQuiz">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Add New Short Quiz</h4>
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
			 		<label>Question</label>
			 		<textarea name="question"  class="form-control" rows="3" required placeholder="Quiz Question"></textarea><br>
			 		<input type="submit" name="AddQuiz" value="Add Quiz" class="btn btn-success pull-right"><br><br>
		 	</form>
			</div>
		</div>
	</div>
</div>


		<div class="panel panel-primary">
			<div class="panel-heading as-bg">
				<h2 class="panel-title pull-left" style="margin-top: 5px"><b>Scheduled Short Quizzes</b> (<?=$_GET['title']?>)</h2>
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
							<th>Question</th>
							<th>Submissions</th>
						</tr>
					

		<?php 
		$i = 1;

		$result = mysqli_query($con, "SELECT * FROM short_quizzes WHERE C_ID = '$C_ID'");
		while ($row = mysqli_fetch_array($result)) {
		     echo "<tr>
					<td>$i</td>
					<td>$row[title]</td>
					<td class='text-success'>$row[dueDate]</td>
					<td class='text-danger'>$row[total_marks]</td>
					<td>$row[question]</td>
					<td><a href='index.php?page=short_quiz_submissions&C_ID=$C_ID&title=$title&SQ_ID=$row[ID]'> Submissions </a>
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
	if (isset($_POST['AddQuiz'])) {

		
	 	$CourseID = $_POST['CourseID'];
	 	$C_Title = $_POST['C_Title'];
	 	$title = $_POST['title'];
	 	$marks = $_POST['marks'];
	 	$question = $_POST['question'];
	 	$date = $_POST['dueDate'];
	 	$dueDate = date("d F, Y", strtotime($date));

	 	$message = "New Short Quiz of <b> ". $C_Title . "</b> has been scheduled. Closing date is <i>". $dueDate ."</i>";
         $to  = "C".$C_ID;

	 	$query = "INSERT INTO short_quizzes SET  C_ID = '$CourseID', title = '$title', dueDate = '$dueDate', total_marks = '$marks', question = '$question'";
	 	$result = mysqli_query($con, $query);

	 	if ($result) {
	 		
			echo"<script>
					window.location='index.php?page=add_short_quiz&C_ID=$CourseID&title=$C_Title';
			</script>";
		}
		else {
			echo 'Error<br>'.$query;
		}
	 	
	 	

	 	
	 }
	 

	  ?>