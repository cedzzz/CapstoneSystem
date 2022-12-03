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
                                        <br>
                                        <br>
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
                                        <th>House Number And Street</th>
                                        <th>Barangay</th>
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
                                        <td><?=$row['housenostreet'];?></td>
                                        <td><?=$row['barangay'];?></td>
                                        <td><?=$row['city'];?></td>
                                        <td><?=$row['province'];?></td>
                                        <td><?=$row['zipcode'];?></td>
                                        <td><?=$row['manager'];?></td>
                                        <td><?=$fetchkey?></td>
                                        <td style= "display: none;"><?=$row['key'];?></td>
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

                <!-- Add Modal  -->
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
                                        <label style="text-align: left;">Household Member's First Name</label>
                                        <input type="text" class="form-control" placeholder="Juan" title="Enter the first name of the household member" name="first_name"  required>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Household Member's  Middle Name</label>
                                        <input type="text" class="form-control" name="middle_name" title="Enter the middle name of the household member" placeholder="Ruiz"  required>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Household Member's Last Name</label>
                                        <input type="text" class="form-control" name="last_name" title="Enter the last name of the household member" placeholder="Dela Cruz" required>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Household Member's Gender</label>
                                        <select class="form-control" name="gender" title="Select the gender of the household member from the list" required="">
		                                     <option disabled selected value="">-- select a gender --</option>
		                                     <option value="Male">Male</option>
		                                     <option value="Female">Female</option>
		                                    </select>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Household Member's Birthdate</label>
                                        <input type="date" class="form-control" title="MM/DD/YYYY" name="birthdate" required>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Household Member's Religion</label>
                                        <select class="form-control" name="religion" title="Select the religion of the household member from the list"  required="">
		                                     <option disabled selected value="">-- select a religion --</option>
		                                     <option value="Roman Catholic">Roman Catholic</option>
		                                     <option value="Iglesia Ni Kristo">Iglesia Ni Kristo</option>
                                             <option value="Jehovah's Witness">Jehovah's Witness</option>
                                             <option value="Islam">Islam</option>
                                             <option value="Aglipayan">Aglipayan</option>
		                                    </select>
                                    </div>

                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Household Member's Marital Status</label>
                                        <select class="form-control" name="marital_status" title="Select the marital status of the household member from the list"  required="">
		                                     <option disabled selected value="">-- select a marital status --</option>
		                                     <option value="Single">Single</option>
		                                     <option value="Married">Married</option>
                                             <option value="Divorced">Divorced</option>
                                             <option value="Separated">Separated</option>
		                                    </select>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Household Member's Contact Number</label>
                                        <input name="contactnum"  class="form-control"  title="Enter the contact number of the household member" placeholder="09653219934" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" pattern="[0-9]{11}" required="">
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Household Member's Nationality</label>
                                        <select class="form-control" name="nationality" title="Select the nationality of the household member from the list" required="">
		                                     <option disabled selected value="">-- select a nationality --</option>
		                                     <option value="Filipino">Filipino</option>
		                                     <option value="Non-Filipino">Non-Filipino</option>
		                                    </select>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Household Member's House Number And Street</label>
                                        <input type="text" class="form-control" title="Enter the house number and street of the household member" placeholder="80 Conception Street" name="housenostreet"   required>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Manager/User's Unique ID</label>
                                        <input type="text" class="form-control" title="Enter the unique ID of the manager of the household" placeholder="qAMn6tJReAADGSJKLAKzc2BAfB8GTF42" name="manageruid"   required>
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
                            <form action="actioncode.php" method="POST">
                                <div class="modal-header">
                                    <h4 class="modal-title">Edit User Residents</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">
                                <input type="hidden" name="edit_id" id="edit_id">
                                <input type="hidden" name="edit_uid" id="edit_uid">
                                <input type="hidden" name="key" id="key">
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Household Member's First Name</label>
                                        <input type="text" class="form-control" placeholder="Juan" title="Enter the first name of the household member" name="first_name" id="first_name" required>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Household Member's Middle Name</label>
                                        <input type="text" class="form-control" name="middle_name" title="Enter the middle name of the household member" placeholder="Ruiz" id="middle_name" required>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Household Member's Last Name</label>
                                        <input type="text" class="form-control" name="last_name" title="Enter the last name of the household member" placeholder="Dela Cruz" id="last_name" required>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Household Member's Gender</label>
                                        <select class="form-control" name="gender" id="gender" title="Select the gender of the household member from the list" required="">
		                                     <option disabled selected value="">-- select a gender --</option>
		                                     <option value="Male">Male</option>
		                                     <option value="Female">Female</option>
		                                    </select>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Household Member's Birthdate</label>
                                        <input type="date" class="form-control" name="birthdate" title="MM/DD/YYYY" id="birthdate" required>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Household Member's Religion</label>
                                        <select class="form-control" name="religion" id="religion"  required="">
		                                     <option disabled selected value="">-- select a religion --</option>
                                             <option value="Roman Catholic">Roman Catholic</option>
		                                     <option value="Iglesia Ni Kristo">Iglesia Ni Kristo</option>
                                             <option value="Jehovah's Witness">Jehovah's Witness</option>
                                             <option value="Islam">Islam</option>
                                             <option value="Aglipayan">Aglipayan</option>
		                                    </select>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Household Member's Marital Status</label>
                                        <select class="form-control" name="marital_status" id="marital_status" required="">
		                                     <option disabled selected value="">-- select a marital status --</option>
		                                     <option value="Single">Single</option>
		                                     <option value="Married">Married</option>
                                             <option value="Divorced">Divorced</option>
                                             <option value="Separated">Separated</option>
		                                    </select>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Household Member's Contact Number</label>
                                        <input name="contactnum" id="contactnum" title="Enter the contact number of the household member" placeholder="09653219934" class="form-control" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" pattern="[0-9]{11}" required="">
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Household Member's Nationality</label>
                                        <select class="form-control" name="nationality" id="nationality" title="Select the nationality of the household member from the list" required="">
		                                     <option disabled selected value="">-- select a nationality --</option>
		                                     <option value="Filipino">Filipino</option>
		                                     <option value="Non-Filipino">Non-Filipino</option>
		                                    </select>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Household Member's House Number And Street</label>
                                        <input type="text" class="form-control" placeholder="80 Conception Street" title="Enter the house number and street of the household member" name="housenostreet" id="housenostreet"  required>
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
                                    <h4 class="modal-title">Delete Resident</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">
                                <input type="hidden" name="del_id" id="del_id">
                                <input type="hidden" name="del_uid" id="del_uid">
                                <input type="hidden" name="key" id="delkey">
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
                                    <h4 class="modal-title">Delete Resident</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="del_id" id="del_id">
                                    <p>Are you sure you want to delete all records?</p>
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
        $('#del_uid').val(data[17]);
        $('#delkey').val(data[18]);
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
        $('#birthdate').val(data[6]);
        $('#religion').val(data[7]);
        $('#marital_status').val(data[8]);
        $('#contactnum').val(data[9]);
        $('#nationality').val(data[10]);
        $('#housenostreet').val(data[11]);
        $('#edit_uid').val(data[17]);
        $('#key').val(data[18]);
        
    });
});
</script>
<?php
include('includes/profileoptions.php');
?>