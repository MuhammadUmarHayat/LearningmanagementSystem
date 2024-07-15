<?php $C_ID = $_GET['C_ID']; ?>

<div class="row" style="margin-top: -12px !important">
	<div style="background: #201D1D; padding: 10px 10px; padding-right: 15px">
		<?= str_repeat('&nbsp;', 10); ?>
		<button type="button" class="btn btn-primary active" onclick="Download()">My Files</button>
		<?= str_repeat('&nbsp;', 15); ?>
		<a href="index.php?page=assignments&C_ID=<?= $C_ID ?>&title=<?= $_GET['title'] ?>" class="btn btn-success">Assignments</a>
		<?= str_repeat('&nbsp;', 15); ?>
		<a href="index.php?page=quizzes&C_ID=<?= $C_ID ?>&title=<?= $_GET['title'] ?>" class="btn btn-info">Quiz</a>
		<?= str_repeat('&nbsp;', 15); ?>
		<a href="index.php?page=short_quizzes&C_ID=<?= $C_ID ?>&title=<?= $_GET['title'] ?>" class="btn btn-default">Short Quiz</a>
		<?= str_repeat('&nbsp;', 15); ?>
		<button type="button" class="btn btn-warning active" onclick="Lectures()">Video Lectures</button>

		<span class="courseTitle pull-right" style="color: #fff; font-weight: bold; font-size: 13pt"><?= $_GET['title']; ?></span>
	</div>
	<div onload="visibility:hidden">
		<div id="download" style="display:none" class="col-sm-4">
			<h2 class="text-center">Course Material</h2>
			<table class="table table-bordered table-striped">
				<tr>
					<th>ID</th>
					<th>Title</th>
					<th>Download</th>
				</tr>

				<?php
				$i = 1;
				$query = mysqli_query($con, "SELECT * FROM course_material WHERE C_ID = '$C_ID'");
				$count = mysqli_num_rows($query);
				if ($count > 0) {
					while ($row = mysqli_fetch_array($query)) {
						echo "<tr>
	  		 			<td>$i</td>
	  		 			<td>$row[title]</td>
	  		 			<td><a href='../assets/material/$row[material]' class='btn btn-success' download>Download</a></td>
						</tr>";
						$i++;
					}
				} else {
					echo "<tr>
	  		 			<td colspan='3' class='text-center'>No Record Found</td>
	  		 		 </tr>";
				} ?>
			</table>
		</div>

		<div id="lecture" class="col-sm-8" style="display:none; max-height: 450px; overflow: scroll;">
			<h2 class="text-center">Video Lectures</h2>
			<table class="table table-bordered table-striped">
				<tr>
					<th>ID</th>
					<th>Title</th>
					<th>Lecture Video</th>
				</tr>

				<?php
				$query = mysqli_query($con, "SELECT * FROM course_video WHERE C_ID = '$C_ID'");
				$count = mysqli_num_rows($query);
				if ($count > 0) {
					while ($row = mysqli_fetch_array($query)) {
						echo "<tr>
	  		 			<td>$row[ID]</td>
	  		 			<td>$row[title]</td>
	  		 			<td>
		  		 			<video width='320' height='240' controls>
							  <source src='../assets/videos/$row[video]' type='video/mp4'>
							</video>
						</td>";
					}
				} else {
					echo "<tr>
	  		 			<td colspan='3' class='text-center'>No Record Found</td>
	  		 		 </tr>";
				} ?>
			</table>
		</div>
	</div>
</div>