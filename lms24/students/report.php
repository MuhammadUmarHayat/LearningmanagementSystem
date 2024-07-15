<?php $S_ID = $_SESSION['USER_ID'];
$stdQry = mysqli_query($con, "SELECT * FROM students WHERE ID = '$S_ID'");
$std = mysqli_fetch_array($stdQry); ?>

<div class="row">
	<div class="col-sm-offset-1 col-sm-10" style="margin-top: 5%">
		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title pull-left" style="margin-top: 5px"><b>Academic Report of  
				(<?=$std['name']?>)</b></h3>
			<span class="pull-right">
					<a href="index.php?page=my_childs" class="btn btn-primary txtBlack btn-sm"><i class="fa fa-arrow-left"></i> Back</a><br>
				</span>
			</div>
			<div class="panel-body">
				<table class="table table-hover table-bordered">
			<thead>
				<tr>
					<th>ID</th>
					<th>Course</th>
					<th>Section</th>
					<th>Teacher Name</th>
					<th>Email</th>
					<th>Quiz Performance</th>
					<th>Assignments Performance</th>
					<th>Attendance</th>
				</tr>
			</thead>
			<tbody>

				<?php
					$i = 1;
					
				
				    $qry = mysqli_query($con, "SELECT * FROM course_enroll AS CE JOIN students AS S ON CE.S_ID = S.ID INNER JOIN courses AS C ON CE.C_ID = C.ID  WHERE CE.S_ID = '$S_ID'");
				    while ($row = mysqli_fetch_array($qry)) {
				    	$Quiz_per  = 0;
				    	$Quiz_total_marks = 0;
				    	$Quiz_ob_marks = 0;

				    	$Asimnt_per  = 0;
				    	$Asimnt_total_marks = 0;
				    	$Asimnt_ob_marks = 0;

				    	$qry3 = mysqli_query($con, "SELECT * FROM teachers AS T JOIN course_teacher AS CT ON T.ID = CT.T_ID WHERE CT.C_ID = '$row[C_ID]'");
				    	@$row3 = mysqli_fetch_array($qry3);
				    	

				    	/////////////////////////////////
				    	////////QUIZ PERCENTAGE/////////
				    	////////////////////////////////
				    	$res = mysqli_query($con, "SELECT obtain_marks, Q_ID, marks, C.title FROM quiz_attempts AS QA JOIN schedule_quiz AS SQ ON QA.Q_ID = SQ.ID JOIN courses AS C ON SQ.C_ID = C.ID WHERE S_ID = '$S_ID' AND SQ.C_ID = '$row[C_ID]'");
				    	while($row2=mysqli_fetch_assoc($res))
				          {
				            @$Quiz_total_marks += $row2['marks'];
				            @$Quiz_ob_marks += $row2['obtain_marks'];
				            $Quiz_per =  $Quiz_ob_marks / $Quiz_total_marks * 100;
				          }

  				    	/////////////////////////////////
				    	/////ASSIGNMENT PERCENTAGE///////
				    	////////////////////////////////
				    	$res2 = mysqli_query($con, "SELECT marks, A_ID, total_marks, C.title FROM course_assignment AS CA JOIN upload_assignment AS UA ON UA.A_ID = CA.ID JOIN courses AS C ON CA.C_ID = C.ID WHERE UA.S_ID = '$S_ID' AND CA.C_ID = '$row[C_ID]' ");
				    	while($row1=mysqli_fetch_assoc($res2))
				          {
				            $Asimnt_total_marks += $row1['total_marks'];
				            $Asimnt_ob_marks += $row1['marks'];
				            $Asimnt_per =  $Asimnt_ob_marks / $Asimnt_total_marks * 100;
				          }


				         $atndQry = mysqli_query($con, "SELECT * FROM attendance WHERE S_ID = '$S_ID' AND C_ID = '$row[C_ID]'");
				         $PresentQry = mysqli_query($con, "SELECT * FROM attendance WHERE S_ID = '$S_ID' AND C_ID = '$row[C_ID]' AND status = 'Present'");
				         @$totalDays = mysqli_num_rows($atndQry);
				         @$totalPresent = mysqli_num_rows($PresentQry);

				         if ($totalDays == 0) {
				         	$atndPer = "-";
				         }
				         else{
				         	$atndPer = $totalPresent / $totalDays * 100 . "%";
				         }
				         

				     	echo "<tr>
								<td>$i</td>
								<td>$row[title]</td>
								<td>$row[section]</td>
								<td>". @$row3['name']."</td>
								<td>". @$row3['email']."</td>
								<td>$Quiz_per %</td>
								<td>$Asimnt_per %</td>
								<td>$atndPer</td>
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