<?php
include('includes/dashboard.php');

?>
<head>
<link href="/Capstone_System/assets/css/icons.min.css" rel="stylesheet" type="text/css">
    <link href="/Capstone_System/assets/css/app.min.css" rel="stylesheet" type="text/css" id="light-style">
    <link rel = "icon" type = "image/png" href = "logo.png">
    <link rel="stylesheet" href="popup.css">
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
                                <form action="actioncode.php" method = "POST" enctype="multipart/form-data">
                                  <h1 class="title">User Profile</h1>
                                  <fieldset>
                                    <legend>
                                      <h3>User Details</h3>
                                    </legend>
                                    <div  class="personal-details">
                                        <input type="hidden" name="user_id" value="<?=$uid;?>">
                                      <div>
                                        
                                        <div><label>Full Name</label><input type="text" class="form-control" name="name" value="<?=$user->displayName;?>" required></div>
                                        <div><label>Email</label><input type="email" class="form-control" name="email" value="<?=$user->email;?>" required></div>
                                        <div><label>Phone Number</label><input type="text" class="form-control" name="phonenum" value="<?=$user->phoneNumber;?>"  required></div>
                                        <div><label>Role</label><select name="roles" class="form-control">
                                            <option disabled selected value="">-- The user's role is set to: <?php $claims = $auth->getUser($uid)->customClaims; if(isset($claims['admin']) == true) {echo "Admin";} elseif(isset($claims['super_admin']) == true) {echo "Super Admin";} elseif($claims == null) {echo "User";}?> -- </option>
                                            <option value="admin">Admin</option>
                                            <option value="user">User</option>
                                        </select></div>
                                        <div><label>Account Status</label><select name="accountstatus" class="form-control">
                                            <option disabled selected value="">-- The user's account's status is set to: <?php if($user->disabled) {echo "Disabled";} else{echo "Enabled";}?> -- </option>
                                            <option value="enable">Enabled</option>
                                            <option value="disable">Disabled</option>
                                        </select></div>
    
                                      </div>
                                      <div>
                                      <div><label>User Profile Image</label></div>
                                      <?php
                                        if($user->photoUrl != NULL){
                                            ?>
                                            
                                            <div><label></label><img src="<?=$user->photoUrl;?>" class="w-50" alt="profile image" style="border-radius: 50%;"></div>
                                            <?php
                                        }
                                        else{
                                            echo "Update the profile picture!";
                                        }
                                        ?>
                                      <div><label for="">Upload User's Profile Picture</label><input type = "file" name = "profilepic" class = "form-control"></div>
                                      <div><label></label><button type="submit" name="updateuserpic" class="btn btn-primary">Save</button></div>
                                        
                                        
                                      </div>
                                    </div>
                                    
                                  </fieldset>
                                  
                                  <button class="submitbtn" name="updateuser" type="submit">Submit</button>
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
    </div>

                            
</div>
<?php
include('includes/profileoptions.php');
?>