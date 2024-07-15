<div class="row">
	<div class="col-sm-offset-2 col-sm-8">
		<div class="panel panel-success">
			<div class="panel-heading text-center">Add New Course</div>
			<div class="panel-body">
				<form action="" method="POST" class="form-inline">
					<label>Course Name</label>
					<input type="text" name="name" class="form-control" placeholder="Enter Course Name">
					<label>Section</label>
					<input type="text" name="section" class="form-control" placeholder="Section">
					<input type="submit" name="submit" value="Add Course" class="btn btn-success">
				</form>
			</div>
		</div>
	</div>

	<div class="col-sm-offset-2 col-sm-8">
		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title text-center"><b>Courses List</b></h3>
			</div>
			<div class="panel-body">
				<table id="table" class="table table-hover table-bordered table-striped">
					<thead>
						<tr>
							<th>ID</th><th>Course Title</th><th>Section</th><th>Delete</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i = 1;
						     $qry = mysqli_query($con, "SELECT * FROM courses");
						     while ($row = mysqli_fetch_array($qry)) {
						     	echo "<tr>
						     	          <td>$i</td>
						     	          <td>$row[title]</td>
						     	          <td>$row[section]</td>
						     	          <td><a href='index.php?page=manage_courses&Delete=Yes&ID=$row[ID]' class='btn btn-danger btn-xs'><span class='glyphicon glyphicon-trash'></span></a></td>
						     	</tr>";
						     	$i++;
						     }
						 ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<?php 

	
	if (isset($_POST['submit'])) {
		$title = $_POST['name'];
		$section = $_POST['section'];

		$result =mysqli_query($con, "INSERT INTO courses SET title = '$title', section = '$section'");

		if ($result) {
			echo "<script>
					window.location='index.php?page=manage_courses';
				</script>";
		}
	}

	if (isset($_GET['Delete'])) {
		$ID = $_GET['ID'];

		$result = mysqli_query($con, "DELETE FROM courses WHERE ID = '$ID'");

		if ($result) {
			echo "<script>
					window.location='index.php?page=manage_courses';
				</script>";
		}
	}


 ?>
 ?>