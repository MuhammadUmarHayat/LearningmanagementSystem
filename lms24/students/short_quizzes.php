<?php 
	$SID = $_SESSION['USER_ID'];
	$C_ID = $_GET['C_ID'];
	$title = $_GET['title']; ?>



<div class="modal fade" id="SQ_Solution">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Add Solution</h4>
			</div>
			<div class="modal-body">
				<form action="" method="POST">
				
					<div class="form-group">
						<input type="hidden" name="SQ_ID" id="SQ_ID">
						<input type="hidden" name="S_ID" value="<?=$SID?>">
						<input type="hidden" name="C_ID" value="<?=$C_ID?>">
						<input type="hidden" name="title" value="<?=$title?>">
						<textarea name="solution" class="form-control textarea" rows="3" required placeholder="Solution..."></textarea>
					</div><br>
					<button type="submit" name="AddSolution" class="btn btn-primary pull-right">Add Solution</button><br><br>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-12"><br><br>
		
		<div class="panel panel-primary">
			<div class="panel-heading as-bg" style="">
				<h2 class="panel-title pull-left" style="margin-top: 5px"><b>Short Quiz (<?=$title?>)</b></h2>
				<span class="pull-right">
					<a href="index.php?page=course_website&C_ID=<?=$C_ID?>&title=<?=$title?>" class="btn btn-primary txtBlack btn-sm"><i class="fa fa-arrow-left"></i> Back</a><br>
				</span>
			</div>
				<div class="panel-body">
					<table class="table table-bordered table-striped">
						<tr>
							<th>ID</th>
							<th>Title</th>
							<th>Question</th>
							<th>Due Date</th>
							<th>Total Marks</th>
							<th>Quiz Status</th>
							<th>Submit Status</th>
							<th>Result</th>
						</tr>
					

		<?php 
		$i = 1;

		$result = mysqli_query($con, "SELECT * FROM short_quizzes WHERE C_ID = '$C_ID'");
		while ($row = mysqli_fetch_array($result)) {
			$SQ_ID = $row['ID'];

			$atmptQry = mysqli_query($con, "SELECT * FROM short_quiz_solutions  WHERE S_ID = '$SID' AND SQ_ID = '$SQ_ID'");
			$atmptDetails = mysqli_fetch_array($atmptQry);
			$chk = mysqli_num_rows($atmptQry);
		     echo "<tr>
					<td>$i</td>
					<td>$row[title]</td>
					<td>$row[question]</td>
					<td class='text-danger'>$row[dueDate]</td>
					<td>$row[total_marks]</td>";
					$end=date_create($row['dueDate']);
					$now = new DateTime();

					if($end < $now) {
						echo "<td class='text-danger'>Closed</td>";
					}
					else{
						echo "<td class='text-success'>Opened</td>";
					} 

					if ($chk > 0) {
						echo "<td class='text-success'>Submitted <br> <small>$atmptDetails[submissionDate] </small> </td>
						<td>$atmptDetails[marks]</td>";
					} else {
						if($end > $now) {
							echo "<td><a href='#' SQ_ID='$row[ID]' class='Attempt_SQ'>Attempt Quiz</a></td>";
						}
						echo"<td>-</td>";
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
	if (isset($_POST['AddSolution'])) {

	 	$C_ID = $_POST['C_ID'];
	 	$title = $_POST['title'];
	 	$SQ_ID = $_POST['SQ_ID'];
	 	$S_ID = $_POST['S_ID'];
	 	$solution = $_POST['solution'];
	 	$date = date("F d, Y");

	 	$qry = mysqli_query($con, "INSERT INTO short_quiz_solutions SET S_ID = '$S_ID', SQ_ID = '$SQ_ID', submissionDate = '$date', solution = '$solution'");
	 	if ($qry) {
	 		echo "<script>
						  window.location='index.php?page=short_quizzes&C_ID=$C_ID&title=$title';
			</script>";
	 	} else {
	 		echo "Error";
	 	}
	 	
	 } ?>

	 