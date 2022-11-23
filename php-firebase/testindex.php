<?php
include('includes/dashboard.php');

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
                                    <div class="col-sm-6">
                                        <h2>List of <b>Users</b></h2>
                                        <a href="#addUsers" class="btn btn-success" data-toggle="modal"><i
                                                class="material-icons">&#xE147;</i> <span>Add A User</span></a>
                                        <a href="#deleteAll" class="btn btn-danger" data-toggle="modal"><i
                                                class="material-icons">&#xE15C;</i> <span>Delete All Users</span></a>
                                                <br>
                            <br>
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
                                        <td><?php $claims = $auth->getUser($uid)->customClaims; if(isset($claims['admin']) == true) {echo "Admin";} elseif(isset($claims['super_admin']) == true) {echo "Super Admin";} elseif($claims == null) {echo "User";}?></td>
                                        <td><img src="<?=$user->photoUrl?>" class="img-fluid" alt="profile image"></td>
                                        <td>
                                            <a href="#editUsersModal" class="edit editbtn" data-toggle="modal"><i
                                                    class="material-icons" style= "color: #FFDF00;" data-toggle="tooltip"
                                                    title="Edit">&#xE254;</i> </a>
                                        </td>
                                        <td>
                                            <a href="#deleteUsers" style= "color: red;" class="delete deletebtn" data-toggle="modal"><i
                                                    class="material-icons" data-toggle="tooltip"
                                                    title="Delete" value="<?=$user->uid?>">&#xE872;</i></a>
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
                                    <h4 class="modal-title">Add a User</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label style="text-align: left;">Full Name</label>
                                        <input type="text" class="form-control" name="name" id="name"  required>
                                    </div>
                                    <div class="form-group">
                                        <label style="text-align: left;">Phone Number</label>
                                        <input type="text" placehodler= "926-345-7789" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" pattern="[0-9]{10}"  name="phone" id="phone"  required>
                                    </div>
                                    <div class="form-group">
                                        <label style="text-align: left;">Email Address</label>
                                        <input type="email" class="form-control" id= "email" name="email" required>
                                    </div>
                                    <div class="form-group">
                                        <label style="text-align: left;">Password</label>
                                        <input type="password" class="form-control" name="password" pattern="^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$" oninvalid="this.setCustomValidity('Your password must contain at least 8 characters, including at least one small letter, one capital letter, one special character, and must not contain spaces or emoji.')" id="password" onChange="onChange()" required>
                                    </div>
                                    <div class="form-group">
                                        <label style="text-align: left;">Confirm Password</label>
                                        <input type="password" class="form-control" name="confirmpassword"  required>
                                        <span class="input-group-text"><i class="bi bi-eye-slash" id="toggleConfirmPassword"></i></span>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                                    <button type="submit" name="adduser" class="btn btn-success">Add User</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>                

                <!-- Edit Modal HTML -->
                <div id="editBlottersModal" class="modal fade" data-backdrop="false">
                    <div class="modal-dialog  modal-dialog-centered">
                        <div class="modal-content">
                            <form action="actioncode.php" method="POST" enctype="multipart/form-data">
                                <div class="modal-header">
                                    <h4 class="modal-title">Edit User</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">
                                <input type="hidden" name="edit_id" id="edit_id">
                                <div class="form-group">
                                        <label style="text-align: left;">Complainant's First Name</label>
                                        <input type="text" class="form-control" name="complainant_firstname" id="complainant_firstname"  required>
                                    </div>
                                    <div class="form-group">
                                        <label style="text-align: left;">Complainant's Middle Name</label>
                                        <input type="text" class="form-control" name="complainant_middlename" id="complainant_middlename"  required>
                                    </div>
                                    <div class="form-group">
                                        <label style="text-align: left;">Complainant's Last Name</label>
                                        <input type="text" class="form-control" name="complainant_lastname" id="complainant_lastname" required>
                                    </div>
                                    <div class="form-group">
                                        <label style="text-align: left;">Complainant's Address</label>
                                        <input type="text" class="form-control" name="complainant_address" id="complainantaddress" required>
                                    </div>
                                    <div class="form-group">
                                        <label style="text-align: left;">Incident</label>
                                        <textarea name="incident" id="incident" class="text" cols="30" rows ="5" readonly></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label style="text-align: left;">Complainee's First Name</label>
                                        <input type="text" class="form-control" name="complainee_firstname" id="complainee_firstname"  required>
                                    </div>
                                    <div class="form-group">
                                        <label style="text-align: left;">Complainee's Middle Name</label>
                                        <input type="text" class="form-control" name="complainee_middlename" id="complainee_middlename"  required>
                                    </div>
                                    <div class="form-group">
                                        <label style="text-align: left;">Complainee's Last Name</label>
                                        <input type="text" class="form-control" name="complainee_lastname" id="complainee_lastname" required>
                                    </div>
                                    <div class="form-group">
                                        <label style="text-align: left;">Complainee's Address</label>
                                        <input type="text" class="form-control" name="complainee_address" id="complaineeaddress" required>
                                    </div>
                                    <div class="form-group">
                                        <label style="text-align: left;">Photo/Video of the Incident</label>
                                        <input type = "file" name = "blotter_evidence" id = "blotter_evidence" class = "form-control" disabled>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                                    <button type="submit" name="updateusers" class="btn btn-success">Save</button>
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
                                    <h4 class="modal-title">Delete a User</h4>
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
                                    <button type="submit" name="deleteusers" class="btn btn-danger">Delete</button>
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
                                    <h4 class="modal-title">Delete All Users</h4>
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
        $tr = $(this).closest('tr');
        var data = $tr.children("td").map(function() {
            return $(this).text();
        }).get();
        console.log(data);
        $('#del_id').val('<?=$user?>');
    });
    $('.editbtn').on('click', function(){
        $tr = $(this).closest('tr');
        var data = $tr.children("td").map(function() {
            return $(this).text();
        }).get();
        console.log(data);
        $('#edit_id').val('<?=$user?>');
        $('#complainant_firstname').val(data[1]);
        $('#complainant_middlename').val(data[2]);
        $('#complainant_lastname').val(data[3]);
        $('#complainantaddress').val(data[4]);
        $('#incident').val(data[5]);
        $('#complainee_firstname').val(data[6]);
        $('#complainee_middlename').val(data[7]);
        $('#complainee_lastname').val(data[8]);
        $('#complaineeaddress').val(data[9]);
    });
});
</script>
<?php
include('includes/profileoptions.php');
?>