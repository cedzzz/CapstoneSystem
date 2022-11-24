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
                                        <h2>Manage <b>User Residents</b></h2>
                                        <a href="#addUserResidents" class="btn btn-success addbtn" data-toggle="modal"><i
                                                class="material-icons">&#xE147;</i> <span>Add New User Resident</span></a>
                                        <a href="#deleteAll" class="btn btn-danger" data-toggle="modal"><i
                                                class="material-icons">&#xE15C;</i> <span>Delete All User Residents</span></a>
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
                                        <th>Household Member</th>
                                        <th>First Name</th>
                                        <th>Middle Name</th>
                                        <th>Last Name</th>
                                        <th>Gender</th>
                                        <th>Age</th>
                                        <th>Birthdate</th>
                                        <th>Religion</th>
                                        <th>Marital Status</th>
                                        <th>Contact Number</th>
                                        <th>Nationality</th>
                                        <th>Address</th>
                                        <th>City</th>
                                        <th>Province</th>
                                        <th>ZIP Code</th>
                                        <th>Manager</th>   
                                        <th>User ID</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include('dbcon.php');
                                    $uid = $_SESSION['verified_user_id'];
                                    $ref_table = "resident";
                                    $fetchdata = $database->getReference($ref_table)->getValue();
                                    if ($fetchdata > 0)
                                                    {
                                                        $x = 1;
                                                        foreach($fetchdata as $fetchkey  => $keyrow)
                                                        {
                                                            $fetchchildren = $database->getReference($ref_table)->getChild($fetchkey)->getValue();
                                                            foreach($fetchchildren as $key => $row)
                                                            {
                                                                
                                                            
                                    ?>
                                    <tr>
                                    <td><?=$x++;?></td>
                                        <td><?=$row['firstname'];?></td>
                                        <td><?=$row['middlename'];?></td>
                                        <td><?=$row['lastname'];?></td>
                                        <td><?=$row['gender'];?></td>
                                        <td><?=$row['age'];?></td>
                                        <td><?=$row['birthdate'];?></td>
                                        <td><?=$row['religion'];?></td>
                                        <td><?=$row['maritalstatus'];?></td>
                                        <td><?=$row['contactnum'];?></td>
                                        <td><?=$row['nationality'];?></td>
                                        <td><?=$row['address'];?></td>
                                        <td><?=$row['city'];?></td>
                                        <td><?=$row['province'];?></td>
                                        <td><?=$row['zipcode'];?></td>
                                        <td><?=$row['manager'];?></td>
                                        <td><?=$fetchkey?></td>
                                        <td>
                                            <a href="#editUserResidentsModal" class="edit editbtn" data-toggle="modal"><i
                                                    class="material-icons" style= "color: #FFDF00;" data-toggle="tooltip"
                                                    title="Edit">&#xE254;</i> </a>
                                        </td>
                                        <td>
                                            <a href="#deleteResidents" style= "color: red;" class="delete deletebtn" data-toggle="modal"><i
                                                    class="material-icons" data-toggle="tooltip"
                                                    title="Delete" value="<?=$key?>">&#xE872;</i></a>
                                        </td>
                                    </tr>
                                    <?php
                                                        }
                                                    }
                                                        
                                                    }
                                                    else{

                                                            echo "<h5 id='disappMsg' class='alert alert-danger'>"."NO RECORDS FOUND!"."</h5>";
                                                        }
                                                    ?>

                <div id="addUserResidents" class="modal fade" data-backdrop="false">
                    <div class="modal-dialog  modal-dialog-centered">
                        <div class="modal-content">
                            <form action="actioncode.php" method="POST">
                                <div class="modal-header">
                                    <h4 class="modal-title">Add Resident</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">First Name</label>
                                        <input type="text" class="form-control" placeholder ="Enter resident's first name" name="first_name"  required>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Middle Name</label>
                                        <input type="text" class="form-control" placeholder ="Enter resident's middle name" name="middle_name"  required>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Last Name</label>
                                        <input type="text" class="form-control" placeholder ="Enter resident's last name" name="last_name" required>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Gender</label>
                                        <select class="form-control" name="gender" required="">
		                                     <option disabled selected value="">-- select a gender --</option>
		                                     <option value="Male">Male</option>
		                                     <option value="Female">Female</option>
		                                    </select>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Age</label>
                                        <input name="age" class="form-control"   placeholder ="Enter resident's age" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  required="">
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Birthdate</label>
                                        <input type="date" class="form-control" name="birthdate" required>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Religion</label>
                                        <input type="text" class="form-control" placeholder ="Enter resident's religion" name="religion"  required>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Marital Status</label>
                                        <select class="form-control" name="marital_status"  required="">
		                                     <option disabled selected value="">-- select a marital status --</option>
		                                     <option value="Single">Single</option>
		                                     <option value="Married">Married</option>
                                             <option value="Divorced">Divorced</option>
                                             <option value="Separated">Separated</option>
		                                    </select>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Contact Number</label>
                                        <input name="contactnum"  class="form-control"  placeholder ="Enter resident's contact number" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" pattern="[0-9]{10}" required="">
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Nationality</label>
                                        <input type="text" class="form-control"  placeholder ="Enter resident's nationality" name="nationality"  required>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">House Number</label>
                                        <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control" name="houseno" placeholder="Enter resident's current residing house number">
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Street</label>
                                        <input type="text" class="form-control" name="street" placeholder = "Enter resident's current residing street"   required>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Barangay</label>
                                        <input type="text" class="form-control" name="barangay" placeholder = "Enter resident's current residing brangay"  required>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">City</label>
                                        <input type="text" class="form-control" name="city" placeholder = "Enter resident's current residing city" required>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Province</label>
                                        <input type="text" class="form-control" name="province" placeholder = "Enter resident's current residing province" required>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">ZIP Code</label>
                                        <input name="zipcode"  class="form-control"placeholder = "Enter resident's current residing zip code/postal code"  type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" pattern="[0-9]{4}" required="">
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Manager's User ID</label>
                                        <input name="manageruid"  class="form-control" placeholder = "Enter the resident's manager user id"  type="text" required="">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                                    <button type="submit" name="adminaddres" class="btn btn-success">Add Resident</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>                

                <!-- Edit Modal HTML -->
                <div id="editUserResidentsModal" class="modal fade" data-backdrop="false">
                    <div class="modal-dialog  modal-dialog-centered">
                        <div class="modal-content">
                            <form action="actioncode.php" method="POST" enctype="multipart/form-data">
                                <div class="modal-header">
                                    <h4 class="modal-title">Edit User Resident</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">
                                <input type="hidden" name="edit_id" id="edit_id">
                                <input type="hidden" name="edit_uid" id="edit_uid">
                                <div class="form-group input-group">
                                        <label style="text-align: left;">First Name</label>
                                        <input type="text" class="form-control"  name="first_name" id="first_name" required>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Middle Name</label>
                                        <input type="text" class="form-control"  name="middle_name" id="middle_name" required>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Last Name</label>
                                        <input type="text" class="form-control"  name="last_name" id="last_name" required>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Gender</label>
                                        <select class="form-control" name="gender" id="gender" required="">
		                                     <option disabled selected value="">-- select a gender --</option>
		                                     <option value="Male">Male</option>
		                                     <option value="Female">Female</option>
		                                    </select>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Age</label>
                                        <input name="age" id="age" class="form-control" placeholder="" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  required="">
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Birthdate</label>
                                        <input type="date" class="form-control" name="birthdate" id="birthdate" required>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Religion</label>
                                        <input type="text" class="form-control"  name="religion" id="religion" required>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Marital Status</label>
                                        <select class="form-control" name="marital_status" id="marital_status" required="">
		                                     <option disabled selected value="">-- select a marital status --</option>
		                                     <option value="Single">Single</option>
		                                     <option value="Married">Married</option>
                                             <option value="Divorced">Divorced</option>
                                             <option value="Separated">Separated</option>
		                                    </select>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Contact Number</label>
                                        <input name="contactnum" id="contactnum" class="form-control"  placeholder="" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" pattern="[0-9]{10}" required="">
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Nationality</label>
                                        <input type="text" class="form-control" name="nationality" id="nationality"  required>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Address</label>
                                        <input type="text" class="form-control" name="address" id="address"  required>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">City</label>
                                        <input type="text" class="form-control" name="city" id="city" required>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Province</label>
                                        <input type="text" class="form-control" name="province"  id="province" required>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">ZIP Code</label>
                                        <input name="zipcode" id="zipcode" class="form-control" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" pattern="[0-9]{4}" required="">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                                    <button type="submit" name="updateadminres" class="btn btn-success">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Delete Modal HTML -->
                <div id="deleteResidents" class="modal fade" data-backdrop="false">
                    <div class="modal-dialog  modal-dialog-centered">
                        <div class="modal-content">
                            <form action="actioncode.php" method="POST">
                                <div class="modal-header">
                                    <h4 class="modal-title">Delete Blotter</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="del_id" id="del_id">
                                    <input type="hidden" name="del_uid" id="del_uid">
                                    <p>Are you sure you want to delete this record?</p>
                                    <p class="text-warning"><small>This action cannot be undone!</small></p>
                                </div>
                                <div class="modal-footer">
                                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                                    <button type="submit" name="deleteadminres" class="btn btn-danger">Delete</button>
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
                                    <h4 class="modal-title">Delete All Residents</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="del_id" id="del_id">
                                    <p>Are you sure you want to delete all residents from all users?</p>
                                    <p class="text-warning"><small>This action cannot be undone!</small></p>
                                </div>
                                <div class="modal-footer">
                                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                                    <button type="submit" name="deletealluserres" class="btn btn-danger">Delete</button>
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
        $('#del_id').val('<?=$key?>');
        $('#del_uid').val(data[16]);
    });
    $('.editbtn').on('click', function(){
        $tr = $(this).closest('tr');
        var data = $tr.children("td").map(function() {
            return $(this).text();
        }).get();
        console.log(data);
        $('#edit_id').val('<?=$key?>');
        $('#first_name').val(data[1]);
        $('#middle_name').val(data[2]);
        $('#last_name').val(data[3]);
        $('#gender').val(data[4]);
        $('#age').val(data[5]);
        $('#birthdate').val(data[6]);
        $('#religion').val(data[7]);
        $('#marital_status').val(data[8]);
        $('#contactnum').val(data[9]);
        $('#nationality').val(data[10]);
        $('#address').val(data[11]);
        $('#city').val(data[12]);
        $('#province').val(data[13]);
        $('#zipcode').val(data[14]);
        $('#edit_uid').val(data[16]);
        
    });
});
</script>
<?php
include('includes/profileoptions.php');
?>