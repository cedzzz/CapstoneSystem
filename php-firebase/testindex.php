<?php
include('includes/dashboard.php');

?>
<head>
<link href="/Capstone_System/assets/css/icons.min.css" rel="stylesheet" type="text/css">
    <link href="/Capstone_System/assets/css/app.min.css" rel="stylesheet" type="text/css" id="light-style">
    <link rel = "icon" type = "image/png" href = "logo.png">
    <link rel="stylesheet" href="popup.css">
    <script>
    function onChange() {
        const password = document.querySelector('input[name=new_password]');
        const confirm = document.querySelector('input[name=confirm_password]');
            if (confirm.value === password.value) {
                confirm.setCustomValidity('');
            } else {
                confirm.setCustomValidity('Passwords do not match');
                }
                        }
</script>
<style>
    #password:not(:focus) + #passwordHelpBlock{
    display: none;
}
</style>
</head>
<?php
                                if(isset($_GET['id']))
                                {
                                    $uid = $_GET['id'];
                                    try{
                                        $user=$auth->getUser($uid);
                                        ?>
                                        
                            <div class="container-fluid">
                            <div class="main-block">
                                <form action="actioncode.php" method="POST">
                                  <h1 class="title">Change Password</h1>
                                  <fieldset>
                                    <legend>
                                      <h3>User Details</h3>
                                    </legend>
                                    <input type="hidden" name="change_pwd_uid" value = "<?=$uid;?>">
                                    <div  class="formn-group mb-3">
                                      <label for="">New Password </label>
                                      <input type="password" name="new_password" id="password" class="form-control" required="" onChange="onChange()">
                                      <small id="passwordHelpBlock" class="form-text text-muted">
                                        Your password must contain at least 8 characters, including at least one small letter, one capital letter, one special character (e.g ~`!@#$%^&*()"-_+{}[];:<>,.?/|\ ), and must not contain spaces or emoji.
                                      </small>
                                    </div>

                                    <div  class="formn-group mb-3">
                                      <label for="">Confirm New Password</label>
                                      <input type="password" name="confirm_password" id = "password" class="form-control" required="" onChange="onChange()">
                                      <small id="passwordHelpBlock" class="form-text text-muted">
                                        Your confirm password must be the same as the password you've typed.
                                      </small>
                                    </div>
                                  </fieldset>
                                  
                                  <button type="submit" name="change_pwd_btn" class="btn btn-primary btn-block"> Submit </button>
                                </form>
                                </div> 
                                        <?php
                                    } catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e){
                                        echo $e->getMessage();
                                    }
                                }
                                else
                                {
                                    echo "<h5 id='disappMsg' class='alert alert-info'>"."NO ID FOUND"."</h5>";
                                }
                                ?>
                                

                       
                    </div>

                               

                            </div>
                         

<?php
include('includes/profileoptions.php');
?>