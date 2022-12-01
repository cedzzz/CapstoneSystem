<?php
session_start();
include('includes/header.php');
if(isset($_SESSION['verified_user_id']))
{
  $_SESSION['statusinfo'] = "You are already logged in!";
  header('Location: dashboard.php');
  exit();
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <title>Barangay Information System</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- bootstrap 3.0.2 -->
    <link href="/Capstone_System/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Theme style -->

    <link rel = "icon" type = "image/png" href = "logo.png">
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <style>
        body{
            background:  rgb(36, 41, 67);
        }
    </style>

</head>
<body class="skin-black">
    <?php
    if(isset($_SESSION['status']))
    {
        echo "<h5 id='disappMsg' class='alert alert-success'>".$_SESSION['status']."</h5>";
        unset($_SESSION['status']);
    }
    elseif(isset($_SESSION['statusred']))
    {
        echo "<h5 id='disappMsg' class='alert alert-danger'>".$_SESSION['statusred']."</h5>";
        unset($_SESSION['statusred']);
    }
    ?>
    <div class="container" style="margin-top:30px">
      <div class="col-md-4 col-md-offset-4">
          <div class="panel panel-default">
        <div class="panel-heading" style="text-align:center;">
            <img class="" src="logo.png" style="height:100px;"/>
          <h3 class="panel-title">
            <strong>
                Barangay User Login
            </strong>
          </h3>
        </div>
        <div class="panel-body">
          <form role="form" action="actioncode.php" method="POST">
            <h5>&nbsp;Email</h5>
            <div class="form-group mb-3">
            <input type="email" class="form-control" style="border-radius:0px" name="email" placeholder="Enter Email" required="">
             
            </div>
            <h5>&nbsp;Password</h5>
            <div class="form-group mb-3 input-group">
              <input type="password" id="password" name="password" class="form-control" style="border-radius:0px"  placeholder="Enter Password" required="">
              <span class="input-group-text"><i class="bi bi-eye-slash" id="togglePassword"></i></span>


            </div>
            <button type="submit" class="btn btn-lg btn-primary" name="btn_login">Log in</button>
            <label id="error" class="label label-danger pull-right"></label> 
            <p class="divider-text">
                <span class=""></span>
            </p>
            <p class="text-center">Don't have an account yet? <a href="register.php">Register Now</a> </p>
            <p class="text-center">Having trouble logging in? Go to our <a href="forgotpassword.php">forgot password page!</a> </p>
          </form>
        </div>
      </div>
      </div>
    </div>
  </body>
  </html>
  <script>
  function hideMessage() {
      document.getElementById("disappMsg").style.display = "none";
    };
    setTimeout(hideMessage, 2000);
   </script>
   <script>
const togglePassword = document.querySelector("#togglePassword");
const password = document.querySelector("#password");

togglePassword.addEventListener("click", function () {
   
// toggle the type attribute
const type = password.getAttribute("type") === "password" ? "text" : "password";
password.setAttribute("type", type);

// toggle the eye icon
this.classList.toggle('bi-eye');
});

   </script>