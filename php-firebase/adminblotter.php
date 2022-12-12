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
                                        <h2>Manage <b>User Blotters</b></h2>
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
                                        <th>Complainant's Address</th>
                                        <th>Type of Blotter</th>
                                        <th>Complaint</th>
                                        <th>Date of Occurence</th>
                                        <th>Complainee's First Name</th>
                                        <th>Complainee's Middle Name</th>
                                        <th>Complainee's Last Name</th>
                                        <th>Complainee's Address</th>
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
                                    $fetchdata = $database->getReference($ref_table)->getValue();
                                    if ($fetchdata > 0)
                                                    {
                                                        $x = 1;
                                                        foreach($fetchdata as $fetchkey  => $keyrow)
                                                        {
                                                            $fetchchildren = $database->getReference($ref_table)->getChild($fetchkey)->getValue();
                                                            foreach($fetchchildren as $key => $row){

                                                            
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
                                        <td style= "display: none;"><?=$fetchkey?></td>
                                        <td style= "display: none;"><?=$row['key'];?></td>
                                        <td style= "display: none;"><?=$row['incidentevidence'];?></td>
                                        <td>
                                            <a href="#summaryBlottersModal" class="generate generatebtn" data-toggle="modal"><i
                                                    class="material-icons" style= "color: #3944BC;" data-toggle="tooltip"
                                                    title="Generate Blotter Report">&#xF071;</i> </a>
                                        </td>
                                        <td>
                                            <a href="#approveBlottersModal" class="edit approvebtn" data-toggle="modal"><i
                                                    class="material-icons" style= "color: #00FF00;" data-toggle="tooltip"
                                                    title="Approve">&#xE876;</i> </a>
                                        </td>
                                        <td>
                                            <a href="#rejectBlottersModal" style= "color: red;" class="edit rejectbtn" data-toggle="modal"><i
                                                    class="material-icons" data-toggle="tooltip"
                                                    title="Reject">&#xE14B;</i></a>
                                        </td>
                                        <td>
                                            <a href="#deleteBlotters" style= "color: red;" class="delete deletebtn" data-toggle="modal"><i
                                                    class="material-icons" data-toggle="tooltip"
                                                    title="Delete">&#xE872;</i></a>
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

                <div id="approveBlottersModal" class="modal fade" data-backdrop="false">
                    <div class="modal-dialog  modal-dialog-centered">
                        <div class="modal-content">
                            <form action="actioncode.php" method="POST" enctype="multipart/form-data">
                                <div class="modal-header">
                                    <h4 class="modal-title">Approve Blotter</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">
                                <input type="hidden" name="approve_id" id="approve_id">
                                <input type="hidden" name="approve_uid" id="approve_uid">
                                <input type="hidden" name="key" id="key">
                                <input type="hidden" name="status" id="documentstatus">
                                <p>Are you sure you want to approve this blotter record?</p>
                                <p class="text-warning"><small>This action cannot be undone!</small></p>
                                </div>
                                <div class="modal-footer">
                                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                                    <button type="submit" name="approveadminblot" class="btn btn-success">Approve</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                  <div id="summaryBlottersModal" class="modal fade" data-backdrop="false">
                    <div class="modal-dialog  modal-dialog-centered">
                        <div class="modal-content">
                            <form action="actioncode.php" method="POST" enctype="multipart/form-data">
                                <div class="modal-header">
                                    <h4 class="modal-title">Generate Blotter Summary</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">
                                <input type="hidden" name="generate_id" id="generate_id">
                                <input type="hidden" name="generate_uid" id="generate_uid">
                                <input type="hidden" name="key" id="key">
                                <input type="hidden" name="complainant_firstname" id="generatecomplainant_firstname">
                                <input type="hidden" name="complainant_middlename" id="generatecomplainant_middlename">
                                <input type="hidden" name="complainant_lastname" id="generatecomplainant_lastname">
                                <input type="hidden" name="complainantaddress" id="generatecomplainantaddress">
                                <input type="hidden" name="blottertype" id="generateblottertype">
                                <input type="hidden" name="incident" id="generateincident">
                                <input type="hidden" name="incidentdate" id="generateincidentdate">
                                <input type="hidden" name="complainee_firstname" id="generatecomplainee_firstname">
                                <input type="hidden" name="complainee_middlename" id="generatecomplainee_middlename">
                                <input type="hidden" name="complainee_lastname" id="generatecomplainee_lastname">
                                <input type="hidden" name="complaineeaddress" id="generatecomplaineeaddress">
                                <input type="hidden" name="incidentevidence" id="generateincidentevidence">
                                <input type="hidden" name="status" id="generatedocumentstatus">
                                <p>Are you sure you want to get the summary of this blotter record?</p>
                                <p class="text-warning"><small>This action cannot be undone!</small></p>
                                </div>
                                <div class="modal-footer">
                                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                                    <button type="submit" name="generateadminblot" class="btn btn-success">Generate Report</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

         
                <div id="rejectBlottersModal" class="modal fade" data-backdrop="false">
                    <div class="modal-dialog  modal-dialog-centered">
                        <div class="modal-content">
                            <form action="actioncode.php" method="POST" enctype="multipart/form-data">
                                <div class="modal-header">
                                    <h4 class="modal-title">Reject Blotter</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">
                                <input type="hidden" name="reject_id" id="reject_id">
                                <input type="hidden" name="reject_uid" id="reject_uid">
                                <input type="hidden" name="key" id="rejectkey">
                                <input type="hidden" name="status" id="rejectdocumentstatus">
                                <p>Are you sure you want to reject this blotter record?</p>
                                <p class="text-warning"><small>This action cannot be undone!</small></p>
                                </div>
                                <div class="modal-footer">
                                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                                    <button type="submit" name="rejectadminblot" class="btn btn-danger">Reject</button>
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
                                    <input type="hidden" name="del_uid" id="del_uid">
                                    <input type="hidden" name="key" id="delkey">
                                    <p>Are you sure you want to delete this blotter request record?</p>
                                    <p class="text-warning"><small>This action cannot be undone!</small></p>
                                </div>
                                <div class="modal-footer">
                                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                                    <button type="submit" name="deleteadminblot" class="btn btn-danger">Delete</button>
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
                                    <h4 class="modal-title">Delete All Blotters</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="del_id" id="del_id">
                                    <p>Are you sure you want to delete all blotters from all users?</p>
                                    <p class="text-warning"><small>This action cannot be undone!</small></p>
                                </div>
                                <div class="modal-footer">
                                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                                    <button type="submit" name="deletealluserblot" class="btn btn-danger">Delete</button>
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
        $('#del_uid').val(data[14]);
        $('#delkey').val(data[15]);
    });
    $('.approvebtn').on('click', function(){
        $tr = $(this).closest('tr');
        var data = $tr.children("td").map(function() {
            return $(this).text();
        }).get();
        console.log(data);
        $('#approve_id').val('<?=$key?>');
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
        $('#documentstatus').val(data[13]);
        $('#approve_uid').val(data[14]);
        $('#key').val(data[15]);
        
    });

    $('.generatebtn').on('click', function(){
        $tr = $(this).closest('tr');
        var data = $tr.children("td").map(function() {
            return $(this).text();
        }).get();
        console.log(data);
        $('#generate_id').val('<?=$key?>');
        $('#generatecomplainant_firstname').val(data[1]);
        $('#generatecomplainant_middlename').val(data[2]);
        $('#generatecomplainant_lastname').val(data[3]);
        $('#generatecomplainantaddress').val(data[4]);
        $('#generateblottertype').val(data[5]);
        $('#generateincident').val(data[6]);
        $('#generateincidentdate').val(data[7]);
        $('#generatecomplainee_firstname').val(data[8]);
        $('#generatecomplainee_middlename').val(data[9]);
        $('#generatecomplainee_lastname').val(data[10]);
        $('#generatecomplaineeaddress').val(data[11]);
        $('#generateincidentevidence').val(data[16]);
        $('#generatedocumentstatus').val(data[13]);
        $('#generate_uid').val(data[14]);
        $('#key').val(data[15]);
        
    });

    $('.rejectbtn').on('click', function(){
        $tr = $(this).closest('tr');
        var data = $tr.children("td").map(function() {
            return $(this).text();
        }).get();
        console.log(data);
        $('#reject_id').val('<?=$key?>');
        $('#rejectcomplainant_firstname').val(data[1]);
        $('#rejectcomplainant_middlename').val(data[2]);
        $('#rejectcomplainant_lastname').val(data[3]);
        $('#rejectcomplainantaddress').val(data[4]);
        $('#rejectblottertype').val(data[5]);
        $('#rejectincident').val(data[6]);
        $('#rejectincidentdate').val(data[7]);
        $('#rejectcomplainee_firstname').val(data[8]);
        $('#rejectcomplainee_middlename').val(data[9]);
        $('#rejectcomplainee_lastname').val(data[10]);
        $('#rejectcomplaineeaddress').val(data[11]);
        $('#rejectdocumentstatus').val(data[13]);
        $('#reject_uid').val(data[14]);
        $('#rejectkey').val(data[15]);
        
    });
});
</script>
<?php
include('includes/profileoptions.php');
?>