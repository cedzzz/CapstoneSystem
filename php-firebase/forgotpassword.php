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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
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
                Barangay User Reset Password
            </strong>
          </h3>
        </div>
        <div class="panel-body">
          <form role="form" action="actioncode.php" method="POST">
            <h5>&nbsp;Email</h5>
            <div class="form-floating mb-3">
              <input type="email" class="form-control" style="border-radius:0px" name="email" placeholder="Enter Email" required="">
              <label for="txt_username" style="font-weight: normal;">Email</label>
            </div>
            <button type="submit" class="btn btn-lg btn-primary" name="btn_reset">Reset Password</button>
            <label id="error" class="label label-danger pull-right"></label> 
            <p class="divider-text">
                <span class=""></span>
            </p>
            <h3><a href="login.php" style="font-family: Arial;"><i class="fa fa-arrow-left" style="font-size: 0.73em;"> Go Back</i></a> </h3>
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
    setTimeout(hideMessage, 4000);
                        
   </script>