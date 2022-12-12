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
                                        <h2>Manage <b>Blotters</b></h2>
                                        <a href="#addBlotters" class="btn btn-success" data-toggle="modal"><i
                                                class="material-icons">&#xE147;</i> <span>Add A Blotter</span></a>
                                        <a href="#deleteAll" class="btn btn-danger" data-toggle="modal"><i
                                                class="material-icons">&#xE15C;</i> <span>Delete All Blotters</span></a>
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
                                        <th>Complaint No.</th>
                                        <th>Complainant's First Name</th>
                                        <th>Complainant's Middle Name</th>
                                        <th>Complainant's Last Name</th>
                                        <th>Complainant's House Number And Street</th>
                                        <th>Type of Blotter</th>
                                        <th>Complaint</th>
                                        <th>Date of Occurence</th>
                                        <th>Complainee's First Name</th>
                                        <th>Complainee's Middle Name</th>
                                        <th>Complainee's Last Name</th>
                                        <th>Complainee's House Number And Street</th>
                                        <th>Evidence of the Complaint</th>
                                        <th>Status</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include('dbcon.php');
                                    $uid = $_SESSION['verified_user_id'];
                                    $ref_table = "blotter";
                                    $fetchdata = $database->getReference($ref_table)->getChild($uid)->getValue();
                                    if ($fetchdata > 0)
                                                    {
                                                        $x = 1;
                                                        foreach($fetchdata as $key  => $row)
                                                        {
                                    ?>
                                    <tr>
                                        <td><?=$x++;?></td>
                                        <td><?=$row['complainant_firstname'];?></td>
                                        <td><?=$row['complainant_middlename'];?></td>
                                        <td><?=$row['complainant_lastname'];?></td>
                                        <td><?=$row['complainantaddress'];?></td>
                                        <td><?=$row['blottertype'];?></td>
                                        <td><?=$row['incident'];?></td>
                                        <td><?=$row['incidentdate'];?></td>
                                        <td><?=$row['complainee_firstname'];?></td>
                                        <td><?=$row['complainee_middlename'];?></td>
                                        <td><?=$row['complainee_lastname'];?></td>
                                        <td><?=$row['complaineeaddress'];?></td>
                                        <td><img src="<?=$row['incidentevidence'];?>" class="img-fluid" alt="profile image"></td>
                                        <td><?=$row['status'];?></td>
                                        <td>
                                            <a href="#editBlottersModal" class="edit editbtn" data-toggle="modal"><i
                                                    class="material-icons" style= "color: #FFDF00;" data-toggle="tooltip"
                                                    title="Edit">&#xE254;</i> </a>
                                        </td>
                                        <td>
                                            <a href="#deleteBlotters" style= "color: red;" class="delete deletebtn" data-toggle="modal"><i
                                                    class="material-icons" data-toggle="tooltip"
                                                    title="Delete" value="<?=$key?>">&#xE872;</i></a>
                                        </td>
                                    </tr>
                                    <?php
                                                        }
                                                        
                                                    }
                                                    else{

                                                            echo "<h5 id='disappMsg' class='alert alert-danger'>"."NO RECORDS FOUND!"."</h5>";
                                                        }
                                                    ?>

                <!-- Add Modal  -->
                <div id="addBlotters" class="modal fade" data-backdrop="false">
                    <div class="modal-dialog  modal-dialog-centered">
                        <div class="modal-content">
                            <form action="actioncode.php" method="POST" enctype="multipart/form-data">
                                <div class="modal-header">
                                    <h4 class="modal-title">Add Blotter</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Complainant's First Name</label>
                                        <input type="text" class="form-control" placeholder="Juan" title="Enter the first name of the complainant" name="complainant_firstname"  required>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Complainant's Middle Name</label>
                                        <input type="text" class="form-control" placeholder="Ruiz"  title="Enter the middle name of the complainant" name="complainant_middlename"  required>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Complainant's Last Name</label>
                                        <input type="text" class="form-control" placeholder="Dela Cruz"  title="Enter the last name of the complainant" name="complainant_lastname" required>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Complainant's House Number And Street</label>
                                        <input type="text" class="form-control" placeholder="30 Conception Street"  title="Enter the residing house number and street of the complainant" name="complainant_address" required>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Type of Blotter</label>
                                        <select class="form-control" name="blottertype" title="Select the blotter type from the list" required="">
		                                     <option disabled selected value="">-- select a blotter type --</option>
		                                     <option value="Robbery">Robbery</option>
		                                     <option value="Resident Dispute">Resident Dispute</option>
                                             <option value="Car Collision">Car Collision</option>
		                                     <option value="Others">Others</option>
		                                    </select>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Incident</label>
                                        <textarea name="incident" id="incident1" class="text" cols="30" rows ="10" required></textarea>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Incident Date/Date of Occurence</label>
                                        <input type="date" class="form-control" title="MM/DD/YYYY" name="incidentdate" required>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Complainee's First Name</label>
                                        <input type="text" class="form-control" placeholder="Pedro" title="Enter the first name of the complainee" name="complainee_firstname"  required>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Complainee's Middle Name</label>
                                        <input type="text" class="form-control" placeholder="Bakal" title="Enter the middle name of the complainee" name="complainee_middlename"  required>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Complainee's Last Name</label>
                                        <input type="text" class="form-control" placeholder="Penduko" title="Enter the last name of the complainee" name="complainee_lastname" required>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Complainee's House Number And Street</label>
                                        <input type="text" class="form-control" placeholder="20 Santol Street" title="Enter the residing house number and street of the complainee" name="complainee_address" required>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Photo of the Incident</label>
                                        <input type = "file" name = "blotter_evidence" title="Please upload a photo of the incident as proof" class = "form-control" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                                    <button type="submit" name="addblot" class="btn btn-success">Add Blotter</button>
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
                                    <h4 class="modal-title">Edit Blotter</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">
                                <input type="hidden" name="edit_id" id="edit_id">
                                <input type="hidden" name="status" id="status">
                                <div class="form-group input-group">
                                        <label style="text-align: left;">Complainant's First Name</label>
                                        <input type="text" class="form-control" placeholder="Juan"  title="Enter the first name of the complainant" name="complainant_firstname" id="complainant_firstname"  required>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Complainant's Middle Name</label>
                                        <input type="text" class="form-control" placeholder="Ruiz"  title="Enter the middle name of the complainant" name="complainant_middlename" id="complainant_middlename"  required>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Complainant's Last Name</label>
                                        <input type="text" class="form-control" placeholder="Juan"  title="Enter the last name of the complainant" name="complainant_lastname" id="complainant_lastname" required>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Complainant's House Number And Street</label>
                                        <input type="text" class="form-control" placeholder="30 Conception Street" title="Enter the residing house number and street of the complainant" name="complainant_address" id="complainantaddress" required>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Type of Blotter</label>
                                        <select class="form-control" name="blottertype" title="Select the blotter type from the list" id="blottertype" disabled>
		                                     <option disabled selected value="">-- select a blotter type --</option>
		                                     <option value="Robbery">Robbery</option>
		                                     <option value="Resident Dispute">Resident Dispute</option>
                                             <option value="Car Collision">Car Collision</option>
		                                     <option value="Others">Others</option>
		                                    </select>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Incident</label>
                                        <textarea name="incident" id="incident" class="text" cols="30" rows ="5" readonly></textarea>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Incident Date/Date of Occurence</label>
                                        <input type="date" class="form-control" title="MM/DD/YYYY" name="incidentdate" id = "incidentdate" disabled>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Complainee's First Name</label>
                                        <input type="text" class="form-control" placeholder="Pedro" title="Enter the first name of the complainee" name="complainee_firstname" id="complainee_firstname"  required>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Complainee's Middle Name</label>
                                        <input type="text" class="form-control" placeholder="Bakal" title="Enter the middle name of the complainee" name="complainee_middlename" id="complainee_middlename"  required>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Complainee's Last Name</label>
                                        <input type="text" class="form-control" placeholder="Penduko" title="Enter the last name of the complainee" name="complainee_lastname" id="complainee_lastname" required>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Complainee's House Number And Street</label>
                                        <input type="text" class="form-control" placeholder="20 Santol Street" title="Enter the residing house number and street of the complainee" name="complainee_address" id="complaineeaddress" required>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Photo of the Incident</label>
                                        <input type = "file" name = "blotter_evidence" title="Please upload a photo of the incident as proof" id = "blotter_evidence" class = "form-control" disabled>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                                    <button type="submit" name="updateblot" class="btn btn-success">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Delete Modal HTML -->
                <div id="deleteBlotters" class="modal fade" data-backdrop="false">
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
                                    <p>Are you sure you want to delete this record?</p>
                                    <p class="text-warning"><small>This action cannot be undone!</small></p>
                                </div>
                                <div class="modal-footer">
                                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                                    <button type="submit" name="deleteblot" class="btn btn-danger">Delete</button>
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
                                    <h4 class="modal-title">Delete Blotters</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="del_id" id="del_id">
                                    <p>Are you sure you want to delete all your blotters?</p>
                                    <p class="text-warning"><small>This action cannot be undone!</small></p>
                                </div>
                                <div class="modal-footer">
                                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                                    <button type="submit" name="deleteallblot" class="btn btn-danger">Delete</button>
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
    });
    $('.editbtn').on('click', function(){
        $tr = $(this).closest('tr');
        var data = $tr.children("td").map(function() {
            return $(this).text();
        }).get();
        console.log(data);
        $('#edit_id').val('<?=$key?>');
        $('#complainant_firstname').val(data[1]);
        $('#complainant_middlename').val(data[2]);
        $('#complainant_lastname').val(data[3]);
        $('#complainantaddress').val(data[4]);
        $('#blottertype').val(data[5]);
        $('#incident').val(data[6]);
        $('#incidentdate').val(data[7]);
        $('#complainee_firstname').val(data[8]);
        $('#complainee_middlename').val(data[9]);
        $('#complainee_lastname').val(data[10]);
        $('#complaineeaddress').val(data[11]);
        $('#status').val(data[13]);
    });
});
</script>
<?php
include('includes/profileoptions.php');
?>