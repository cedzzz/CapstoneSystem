<?php
include('includes/dashboard.php');
ob_start();
$claims = $auth->getUser($uid)->customClaims;
if(isset($claims['admin']) == false){

?>
<script type="text/javascript">
window.location.href = 'index.php';
</script>
<?php
    $_SESSION['statusred'] = "YOU ARE NOT AUTHORIZED TO VIEW THIS PAGE!";
    exit(0);
} 
?>
<head>
    <link rel = "icon" type = "image/png" href = "logo.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="popup.css">
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
</head>
<?php
                                if(isset($_GET['id']))
                                {
                                    $uid = $_GET['id'];
                                    try{
                                        $user=$auth->getUser($uid);
                                        ?>
<div class="container-xl">
                    <div class="table-responsive">
                        <div class="table-wrapper">
                            <div class="table-title">
                                <div class="row">
                                    <div class="col-sm-6" >
                                        <h2>List of <b>Users</b></h2>

                                        <a href="#addUsers" class="btn btn-success" data-toggle="modal"><i
                                                class="material-icons">&#xE147;</i> <span>Add A User</span></a>
                                    </div>
                                    <div class="col-sm-6">
                                        
                                    </div>
                                </div>
                            </div>
                            <table class="table table-striped table-hover">
                            <thead>
                                    <tr>
                                        <th>User No.</th>
                                        <th>User's Name</th>
                                        <th>User's Phone Number</th>
                                        <th>User's Email Address</th>
                                        <th>User's Account Status</th>
                                        <th>User's Role</th>
                                        <th>User's Profile Picture</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include('dbcon.php');
                                    $uid = $_SESSION['verified_user_id'];
                                    $users = $auth->listUsers();
                                    if ($users)
                                                    {
                                                        $x = 1;
                                                        foreach($users as $user) 
                                                        {
                                    ?>
                                    <tr>
                                        <td><?=$x++;?></td>
                                        <td><?=$user->displayName?></td>
                                        <td><?=$user->phoneNumber?></td>
                                        <td><?=$user->email?></td>
                                        <td><?php if($user->disabled) {echo "Disabled";} else{echo "Enabled";}?></td>
                                        <td><?php $claims = $auth->getUser($user->uid)->customClaims; if(isset($claims['admin']) == true) {echo "Admin";} elseif(isset($claims['super_admin']) == true) {echo "Super Admin";} elseif($claims == null) {echo "User";}?></td>
                                        <td><img src="<?=$user->photoUrl?>" class="img-fluid" alt="profile image"></td>
                                        <td>
                                            <a href= "editusers.php?id=<?=$user->uid;?>" class="edit editbtn"><i
                                                    class="material-icons" style= "color: #FFDF00;" data-toggle="tooltip"
                                                    title="Edit">&#xE254;</i> </a>
                                        </td>
                                        <td>
                                            <a href="#deleteUsers" style= "color: red;" class="delete deletebtn" data-item ="<?=$user->uid;?>" value="<?=$user->uid;?>" data-toggle="modal"><i
                                                    class="material-icons" data-toggle="tooltip"
                                                    title="Delete">&#xE872;</i></a>
                                        </td>
                                    </tr>
                                    <?php
                                                        }
                                                        
                                                    }
                                                    else{

                                                            echo "<h5 id='disappMsg' class='alert alert-danger'>"."NO USERS FOUND!"."</h5>";
                                                        }
                                                    ?>

                <!-- Add Modal  -->
                <div id="addUsers" class="modal fade" data-backdrop="false">
                    <div class="modal-dialog  modal-dialog-centered">
                        <div class="modal-content">
                            <form action="actioncode.php" method="POST">
                                <div class="modal-header">
                                    <h4 class="modal-title">Add User</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">
                                <div class="form-group input-group">
                                        <label style="text-align: left;">Full Name</label>
                                        <input type="text" class="form-control" placeholder="Juan Dela Cruz" name="name" id="name"  required>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Phone Number</label>
                                        <input name="phone" class="form-control" placeholder="923-456-9907" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" pattern="[0-9]{10}" oninvalid = "this.setCustomValidity('Your phone number should be 10 digits. Please remove the country code number (E.g. +63 or 0 on the start of your phone number)')" onchange="this.setCustomValidity('')" required="">
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Email Address</label>
                                        <input type="email" class="form-control" placeholder="juandelacruz@gmail.com" id= "email" name="email" required>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Password</label>
                                        <input type="password" class="form-control" name="password" pattern="^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$" oninvalid="this.setCustomValidity('Your password must contain at least 8 characters, including at least one small letter, one capital letter, one special character, and must not contain spaces or emoji.')" id="password" oninput="setCustomValidity('') " onChange="onChange()" required>
                                        <span class="input-group-text"><i class="bi bi-eye-slash" id="togglePassword"></i></span>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Confirm Password</label>
                                        <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" onChange="onChange()" required>
                                        <span class="input-group-text"><i class="bi bi-eye-slash" id="toggleConfirmPassword"></i></span>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                                    <button type="submit" name="addusers" class="btn btn-success">Add User</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>                

                <!-- Delete Modal HTML -->
                <div id="deleteUsers" class="modal fade" data-backdrop="false">
                    <div class="modal-dialog  modal-dialog-centered">
                        <div class="modal-content">
                            <form action="actioncode.php" method="POST">
                                <div class="modal-header">
                                    <h4 class="modal-title">Delete User</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="del_id" id="del_id">
                                    <p>Are you sure you want to delete this user?</p>
                                    <p class="text-warning"><small>This action cannot be undone!</small></p>
                                </div>
                                <div class="modal-footer">
                                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                                    <button type="submit" name="deleteusers" value="<?=$user->uid?>" class="btn btn-danger">Delete</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div id="deleteAll" class="modal fade" data-backdrop="false">
                    <div class="modal-dialog  modal-dialog-centered">
                        <div class="modal-content">
                            <form action="actioncode.php" method="POST">
                                <div class="modal-header">
                                    <h4 class="modal-title">Delete Users</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="del_id" id="del_id">
                                    <p>Are you sure you want to delete all the users?</p>
                                    <p class="text-warning"><small>This action cannot be undone!</small></p>
                                </div>
                                <div class="modal-footer">
                                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                                    <button type="submit" name="deleteallusers" class="btn btn-danger">Delete</button>
                                </div>
                            </form>
                        </div>
                    </div>
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
<script>
    $(document).ready(function () {
        $('.deletebtn').on('click', function(){
        var itemid = $(this).attr('value');
        $('#del_id').val(itemid);
    });

});
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
<?php
include('includes/profileoptions.php');
?>