<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>LMS | Login</title>
  <link rel="icon" href="assets/images/logo.jpeg" />
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <script src="assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/dist/js/sweetalert.min.js"></script>
</head>
<style type="text/css">
  form{
   position: relative;
            z-index: 1;
            background: #FFFFFF;
            max-width: 500px;
            margin: 0 auto 10px;
            padding: 30px;
            border-top-left-radius: 3px;
            border-top-right-radius: 3px;
            border-bottom-left-radius: 3px;
            border-bottom-right-radius: 3px;
            text-align: center;
        }
   .form-control {
            outline: 0;
            background: #f2f2f2;
            width: 100%;
            border: 1px solid #ccc;
            margin: 0 0 15px;
            padding: 15px;
            height: 50px;
            border-top-left-radius: 3px;
            border-top-right-radius: 3px;
            border-bottom-left-radius: 3px;
            border-bottom-right-radius: 3px;
            box-sizing: border-box;
            font-size: 14px;
        }
        .button{
            outline: 0;
            background: #337AB7;
            width: 100%;
            border: 0;
            padding: 15px;
            border-top-left-radius: 3px;
            border-top-right-radius: 3px;
            border-bottom-left-radius: 3px;
            border-bottom-right-radius: 3px;
            color: #FFFFFF;
            font-size: 14px;
            -webkit-transition: all 0.3 ease;
            transition: all 0.3 ease;
            cursor: pointer;
        }

</style>
<body>

    <div class="row" style="background-color: #ececec">

      <div class="col-sm-offset-4 col-sm-4">

        <form action="" method="POST">

          <div class="panel panel-primary" style="text-align: center; margin-top: 10%; border: 10px solid #fff">
            <div class="panel-body">
               <img src="https://datesheet.vu.edu.pk/App_Themes/Default/Images/lms_logo.jpg" width="200">
               <br><br> <br>
               
                  <input type="email" name="email" class="form-control" placeholder="Enter Email" required>
                
                  <input type="password" name="password" class="form-control" maxlength="10" placeholder="Enter Password" required>
                
                  <select name="uType" class="form-control" required>
                    <option value="" selected disabled>Select User Type</option>
                    <option value="students">Student</option>
                    <option value="teachers">Teacher</option>
                    <option value="admins">Admin</option>
                  </select>
                
                <button type="submit" class="button" name="Submit"> Login
                </button>
             
        </form>
        <div class="panel-footer">


          <?php

          include "config/db.php";
          if (isset($_GET['error'])) {
            echo "<font color='red'><span class='glyphicon glyphicon-remove-sign '></span> " . @$_GET['error'];
          }
          if (isset($_GET['msg'])) {
            echo "<font color='greem'><span class='glyphicon glyphicon-ok '></span> " . @$_GET['msg'];
          }
          if (isset($_POST['Submit'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $uType = $_POST['uType'];


            $result = mysqli_query($con, "SELECT * from $uType where email='$email' and password='$password'");
            $count = mysqli_num_rows($result);
            $user = mysqli_fetch_array($result);


            if ($count > 0) {
              if ($uType != "admins" && $user['status'] == "Pending") {
                echo "<script> swal('', 'Registration request pending', 'error'); </script>";
              } else {
                $_SESSION['IS_LOGIN'] = "true";
                $_SESSION['USER_ID'] = $user['ID'];
                $_SESSION['USER_NAME'] = $user['name'];
                $_SESSION['USER_TYPE'] = $uType;
                echo "<script> window.location.href='$uType'; </script>";
              }
            } else {
              echo "<script> swal('', 'Email Or Password not correct', 'error'); </script>";
            }
          }
          ?>
        </div>
        <a data-toggle="modal" href='#StudentModal' >Register as Student</a> &nbsp | &nbsp
        <a data-toggle="modal" href='#TeacherModal' >Register as Teacher</a>
      </div>
    </div>
  </div>
  </div>
</body>

</html>



<div class="modal fade" id="StudentModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Student Registration</h4>
      </div>
      <div class="modal-body">
        <form action="" method="POST" enctype="multipart/form-data">
          <div class="row">
            <div class="col-sm-4">
              <label>Student Name</label>
              <input type="text" name="name" class="form-control" placeholder="Enter Student Name" required>
            </div>
            <div class="col-sm-4">
              <label>Father Name</label>
              <input type="text" name="fname" class="form-control" placeholder="Enter Father Name" required>
            </div>
            <div class="col-sm-4">
              <label>Email</label>
              <input type="email" name="email" class="form-control" placeholder="Enter Email" required>
            </div>
          </div><br>
          <div class="form-group">
            <label>Profile Image</label>
            <input type="file" name="image" class="form-control" required>
          </div>
          <div class="form-row">
            <label>Address</label>
            <input type="text" name="address" class="form-control" placeholder="Enter Student Address" required>
          </div><br>
          <div class="row">
            <div class="col-sm-6">
              <label>Contact No</label>
              <input type="text" name="cellNo" class="form-control" placeholder="Enter Contact No" required>
            </div><br>
            <div class="col-sm-12">
              <label>Password</label>
              <input type="password" name="password" placeholder="Enter Password" class="form-control" required>
            </div><br>
          </div><br>
          <button type="submit" class="btn btn-sm btn-primary pull-right" name="RegisterAsStudent"> Register As Student
          </button><br><br>
        </form>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="TeacherModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Instructor Registration</h4>
      </div>
      <div class="modal-body">
        <form action="" method="POST" enctype="multipart/form-data">
          <div class="row">
            <div class="col-sm-6">
              <label>Name</label>
              <input type="text" name="name" class="form-control" placeholder="Enter Name" required>
            </div>
            <div class="col-sm-6">
              <label>Email</label>
              <input type="email" name="email" class="form-control" placeholder="Email" required>
            </div>
          </div><br>
          <div class="row">
            <div class="col-sm-6">
              <label>Address</label>
              <input type="text" name="address" class="form-control" placeholder="Enter Address" required>
            </div>
            <div class="col-sm-6">
              <label>Cell No</label>
              <input type="number" name="cellNo" class="form-control" required placeholder="Cell No">
            </div>
          </div><br>
          <div class="form-group">
            <label>Qualification</label>
            <input type="text" name="qual" class="form-control" required placeholder="Enter Qualification">
          </div><br>
          <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" placeholder="Enter Password">
          </div>
          <button type="submit" class="btn btn-sm btn-primary pull-right" name="RegisterAsTeacher"> Register As Teacher
          </button><br><br>
        </form>
      </div>
    </div>
  </div>
</div>

<?php
if (isset($_POST['RegisterAsStudent'])) {
  $name = $_POST['name'];
  $fname = $_POST['fname'];
  $email = $_POST['email'];
  $address = $_POST['address'];
  $cellNo = $_POST['cellNo'];
  $password = $_POST['password'];
  $time = time();
  $image = $_FILES['image']['name'];
  $tmp_img = $_FILES['image']['tmp_name'];


  if ($image != "") {
    $parts = explode(".", $image);
    $imgName = $time . "." . $parts[1];
    move_uploaded_file($tmp_img, "assets/profile_images/$imgName");
  }
  $query = "INSERT INTO students SET name ='$name', fName = '$fname', email = '$email', image = '$imgName', address = '$address', cellNo = '$cellNo', password = '$password'";

  $result = mysqli_query($con, $query);
  if ($result) {
    echo "<script> swal('', 'Registered Successfully', 'success'); </script>";
  } else {
    echo "Error" . mysqli_error($con);
  }
}

if (isset($_POST['RegisterAsTeacher'])) {

  extract($_POST);

  $result = mysqli_query($con, "INSERT INTO teachers (name, email, address, cellNo, qual, password)
  VALUES ('$name', '$email', '$address', '$cellNo', '$qual', '$password')");
  if ($result) {
    echo "<script> swal('', 'Registered Successfully', 'success'); </script>";
  } else {
    echo 'error' . mysqli_error($con);
  }
}


?>