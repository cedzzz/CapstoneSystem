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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
function onChange() {
  const password = document.querySelector('input[name=password]');
  const confirmpassword = document.querySelector('input[name=confirmpassword]');
  if (confirmpassword.value === password.value) {
    confirmpassword.setCustomValidity('');
  } else {
    confirmpassword.setCustomValidity("Your confirm password must be the same as the password you've typed.");
  }
}
</script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
<link rel="stylesheet" href="style.css">
<link rel = "icon" type = "image/png" href = "logo.png">
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Register User </title>
</head>

<body>
<div class="card bg-light">
<article class="card-header mx-auto" style="max-width: 400px;">
    <div class="h-100 d-flex align-items-center justify-content-center">
    <img class="" src="logo.png" style="height:100px;"/>
    </div>
	<h4 class="card-title mt-3 text-center">Register Account</h4>
	<p class="text-center">Get started with your account right now!</p>
    <p class="divider-text">
        <span class=""></span>
    </p>
	<form action= "actioncode.php" method = "POST">
	<div class="form-group input-group">
		<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="fa fa-user"></i> </span>
		 </div>
        <input name="first_name" class="form-control" placeholder="First Name" type="text" required="">
    </div> 

    <div class="form-group input-group">
		<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="fa fa-user"></i> </span>
		 </div>
        <input name="last_name" class="form-control" placeholder="Last Name" type="text" required="">
    </div> 
    
    <div class="form-group input-group">
    	<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
		 </div>
        <input name="email" class="form-control" placeholder="Email Address" type="email" required="">
    </div> 
    <div class="form-group input-group">
    	<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="fa fa-mobile"></i> </span>
		</div>
		<input name="prephone" class="form-control" value="+63" placeholder="" type="text" style="max-width: 120px;" readonly>
    	<input name="phone" class="form-control" placeholder="Phone Number" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" pattern="[0-9]{10}" required="">
    </div>

    <div class="form-group input-group">
    	<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
		</div>
        <input class="form-control" id="password" name= "password" placeholder="Password" oninvalid="this.setCustomValidity('Your password must contain at least 8 characters, including at least one small letter, one capital letter, one special character, and must not contain spaces or emoji.')"  pattern="^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$" oninput="this.setCustomValidity('')" type="password" required="" onChange="onChange()">
        <span class="input-group-text"><i class="bi bi-eye-slash" id="togglePassword"></i></span>
        
    </div>

    <div class="form-group input-group">
    	<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
		</div>
        <input class="form-control" name="confirmpassword" id ="confirmpassword" title =" Your confirm password must be the same as the password you've typed." placeholder="Confirm Password" type="password" required="" onChange="onChange()">
        <span class="input-group-text"><i class="bi bi-eye-slash" id="toggleConfirmPassword"></i></span>
    </div>
    <p class="divider-text">
        <span class=""></span>
    </p>
                                         
    <div class="form-group">
        <button type="submit" name="regisuser" class="btn btn-primary btn-block"> Create Account  </button>
    </div> 
    
    <p class="text-center">Have an account? <a href="login.php">Log In</a> </p>
                                                                     
</form>
</article>
</div> <!-- card.// -->

</div> 
<!--container end.//-->
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
const toggleConfirmPassword = document.querySelector("#toggleConfirmPassword");
const confirmpassword = document.querySelector("#confirmpassword");

toggleConfirmPassword.addEventListener("click", function () {
   
// toggle the type attribute
const type = confirmpassword.getAttribute("type") === "password" ? "text" : "password";
confirmpassword.setAttribute("type", type);

// toggle the eye icon
this.classList.toggle('bi-eye');
});
</script>
</body>
</html>
