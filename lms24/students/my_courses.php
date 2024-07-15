<div class="row">
	<div class="col-sm-offset-2 col-sm-8">

		<div class="panel panel-primary">
			<div class="panel-heading">
				<h2 class="panel-title">My Courses</h2>
			</div>
				<div class="panel-body">
					<table class="table table-bordered table-striped">
						<tr>
							<th>ID</th>
							<th>Course Title</th>
							<th>Course Wesbite</th>
						</tr>
					

		<?php 
		$SID = $_SESSION['USER_ID'];
		$i = 1;

		$result = mysqli_query($con, "SELECT * FROM course_enroll AS CE INNER JOIN courses AS C ON CE.C_ID = C.ID WHERE S_ID = '$SID'");
		while ($row = mysqli_fetch_array($result)) {
		     echo "<tr>
					<td>$i</td>
					<td>$row[title]</td>
					<td><a href='index.php?page=course_website&C_ID=$row[C_ID]&title=$row[title]' class='btn btn-info'>Course Wesbite</a></td>
				</tr>";
			$i++;
		 } ?>
		 </table>
				</div>
		</div>
	</div>
</div>