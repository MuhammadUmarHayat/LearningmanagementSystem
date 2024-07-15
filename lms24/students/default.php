<?php $SID = $_SESSION['USER_ID'];

$std = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM students WHERE ID = '$SID'")); ?>

<div class="row">
  

  <?php 
  $i = 1;
  $query2 = mysqli_query($con, "SELECT * FROM course_enroll AS CE JOIN courses AS C ON CE.C_ID = C.ID WHERE CE.S_ID = '$SID'");
  while ($cou = mysqli_fetch_array($query2)) { ?>
   
   <div class="" style="margin: 10px;">
    <div class="small-box ">
      <div class="inner" style="height: 80px; background: url(../assets/icons/bg-6.jpg);">
        

        <h4 style="color:white;" ><?=$cou['title']?></h4> 
          <p  style="color:white;" class=""><b><?=$cou['section'];?></b></p>
        </div>
        <div style="background-color:white;">
          <div style="position: absolute; margin-left: 90%;" ><br>
          <a href="#" class="btn btn-outline-primary"  style="background-color: blue; border-radius: 200px ;width: 100px; font-size: 30px;text-decoration: none; color: white;">20</a>
         
          
        </a>
        </div>
          <img src="../assets/icons/user.png" width="200">
          <hr>
          <div class="course">
          <ul>
            <li>
          <a href='index.php?page=course_website&C_ID=<?=$cou['ID']?>&title=<?=$cou['title']?>'><span><img src="../assets/icons/assignment.png"> </span>
          <p>Assigment</p></a>
             </li>
            <li>
              <a href="index.php?page=course_website&C_ID=<?=$cou['ID']?>&title=<?=$cou['title']?>" class=""><span><img src="../assets/icons/quiz4.png" width="50"> </span>
          <p>Quiz's</p></a>  
             </li>
            <li>
              <a href="index.php?page=course_website&C_ID=<?=$cou['ID']?>&title=<?=$cou['title']?>" class=""><span><img src="../assets/icons/vid.png" width="50"> </span>
          <p>Vidoes Lecture</p></a>  
             </li>
             <li>
              <a href="index.php?page=course_website&C_ID=<?=$cou['ID']?>&title=<?=$cou['title']?>" class=""><span><img src="../assets/icons/folder.png" width="50"> </span>
          <p>Helping Materail</p></a>  
             </li>
          </ul>
        </div>
        <!--
        

       
        <a href="index.php?page=course_website&C_ID=<?=$cou['ID']?>&title=<?=$cou['title']?>" class="">Assigment </a>
        <a href="index.php?page=course_website&C_ID=<?=$cou['ID']?>&title=<?=$cou['title']?>" class="">Assigment </a>
        <a href="index.php?page=course_website&C_ID=<?=$cou['ID']?>&title=<?=$cou['title']?>" class="">Assigment </a>
      </div>
    </div>
-->
    <?php $i++; } ?>


  </div>
  <style type="text/css">
    .course ul li{
      display: inline-block;
      margin: 30px;
    }
  </style>