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
                                        <h2>Manage <b>User Documents</b></h2>
                                        <a href="#deleteAll" class="btn btn-danger" data-toggle="modal"><i
                                                class="material-icons">&#xE15C;</i> <span>Delete All Documents</span></a>
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
                                        <th>Document No.</th>
                                        <th>First Name</th>
                                        <th>Middle Name</th>
                                        <th>Last Name</th>
                                        <th>Gender</th>
                                        <th>Age</th>
                                        <th>Birthdate</th>
                                        <th>Religion</th>
                                        <th>Marital Status</th>
                                        <th>Nationality</th>
                                        <th>House Number And Street</th>
                                        <th>Barangay</th>
                                        <th>City</th>
                                        <th>Type of Document</th>
                                        <th>Type of Permit/Certificate</th>
                                        <th>Status</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include('dbcon.php');
                                    $uid = $_SESSION['verified_user_id'];
                                    $ref_table = "documents";
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
                                    <td><?=$row['firstname'];?></td>
                                        <td><?=$row['middlename'];?></td>
                                        <td><?=$row['lastname'];?></td>
                                        <td><?=$row['gender'];?></td>
                                        <td><?=$row['age'];?></td>
                                        <td><?=$row['birthdate'];?></td>
                                        <td><?=$row['religion'];?></td>
                                        <td><?=$row['maritalstatus'];?></td>
                                        <td><?=$row['nationality'];?></td>
                                        <td><?=$row['housenostreet'];?></td>
                                        <td><?=$row['barangay'];?></td>
                                        <td><?=$row['city'];?></td>
                                        <td><?=$row['documenttype'];?></td>
                                        <td><?=$row['permitcertificatetype'];?></td>
                                        <td style= "display: none;"><?=$row['documents'];?></td>
                                        <td><?=$row['status'];?></td>
                                        <td style= "display: none;"><?=$fetchkey?></td>
                                        <td style= "display: none;"><?=$row['key'];?></td>
                                        <td>
                                            <a href="#approveDocumentsModal" class="edit approvebtn" data-toggle="modal"><i
                                                    class="material-icons" style= "color: #00FF00;" data-toggle="tooltip"
                                                    title="Approve">&#xE876;</i> </a>
                                        </td>
                                        <td>
                                            <a href="#rejectDocumentsModal" style= "color: red;" class="edit rejectbtn" data-toggle="modal"><i
                                                    class="material-icons" data-toggle="tooltip"
                                                    title="Reject">&#xE14B;</i></a>
                                        </td>
                                        <td>
                                            <a href="#deleteDocuments" style= "color: red;" class="delete deletebtn" data-toggle="modal"><i
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


                <div id="approveDocumentsModal" class="modal fade" data-backdrop="false">
                    <div class="modal-dialog  modal-dialog-centered">
                        <div class="modal-content">
                            <form action="actioncode.php" method="POST" enctype="multipart/form-data">
                                <div class="modal-header">
                                    <h4 class="modal-title">Approve Request</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">
                                <input type="hidden" name="approve_id" id="approve_id">
                                <input type="hidden" name="approve_uid" id="approve_uid">
                                <input type="hidden" name="key" id="key">
                                <input type="hidden" name="first_name" id="first_name">
                                <input type="hidden" name="middle_name" id="middle_name">
                                <input type="hidden" name="last_name" id="last_name">
                                <input type="hidden" name="gender" id="gender">
                                <input type="hidden" name="age" id="age">
                                <input type="hidden" name="birthdate" id="birthdate">
                                <input type="hidden" name="marital_status" id="marital_status">
                                <input type="hidden" name="nationality" id="nationality">
                                <input type="hidden" name="housenostreet" id="housenostreet">
                                <input type="hidden" name="barangay" id="barangay">
                                <input type="hidden" name="city" id="city">
                                <input type="hidden" name="document_type" id="document_type">
                                <input type="hidden" name="permitcertificate_type" id="permitcertificatetype">
                                <input type="hidden" name="religion" id="religion">
                                <input type="hidden" name="status" id="documentstatus">
                                <p>Are you sure you want to approve this document request?</p>
                                <p class="text-warning"><small>This action cannot be undone!</small></p>   
                                </div>
                                <div class="modal-footer">
                                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                                    <button type="submit" name="approveadmindocu" class="btn btn-success">Approve</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div id="rejectDocumentsModal" class="modal fade" data-backdrop="false">
                    <div class="modal-dialog  modal-dialog-centered">
                        <div class="modal-content">
                            <form action="actioncode.php" method="POST" enctype="multipart/form-data">
                                <div class="modal-header">
                                    <h4 class="modal-title">Reject Request</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">
                                <input type="hidden" name="reject_id" id="reject_id">
                                <input type="hidden" name="reject_uid" id="reject_uid">
                                <input type="hidden" name="status" id="rejectdocumentstatus">
                                <input type="hidden" name="key" id="rejectkey">
                                <p>Are you sure you want to reject this document request?</p>
                                <p class="text-warning"><small>This action cannot be undone!</small></p>    
                                </div>
                                <div class="modal-footer">
                                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                                    <button type="submit" name="rejectadmindocu" class="btn btn-danger">Reject</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Delete Modal HTML -->
                <div id="deleteDocuments" class="modal fade" data-backdrop="false">
                    <div class="modal-dialog  modal-dialog-centered">
                        <div class="modal-content">
                            <form action="actioncode.php" method="POST">
                                <div class="modal-header">
                                    <h4 class="modal-title">Delete Document</h4>
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
                                    <button type="submit" name="deleteadmindocu" class="btn btn-danger">Delete</button>
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
                                    <h4 class="modal-title">Delete All Documents</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="del_id" id="del_id">
                                    <p>Are you sure you want to delete all documents from all users?</p>
                                    <p class="text-warning"><small>This action cannot be undone!</small></p>
                                </div>
                                <div class="modal-footer">
                                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                                    <button type="submit" name="deletealluserdocu" class="btn btn-danger">Delete</button>
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

    $('.approvebtn').on('click', function(){
        $tr = $(this).closest('tr');
        var data = $tr.children("td").map(function() {
            return $(this).text();
        }).get();
        console.log(data);
        $('#approve_id').val('<?=$key?>');
        $('#approve_uid').val(data[17]);
        $('#first_name').val(data[1]);
        $('#middle_name').val(data[2]);
        $('#last_name').val(data[3]);
        $('#gender').val(data[4]);
        $('#age').val(data[5]);
        $('#birthdate').val(data[6]);
        $('#religion').val(data[7]);
        $('#marital_status').val(data[8]);
        $('#nationality').val(data[9]);
        $('#housenostreet').val(data[10]);
        $('#barangay').val(data[11]);
        $('#city').val(data[12]);
        $('#document_type').val(data[13]);
        $('#permitcertificatetype').val(data[14]);
        $('#documents').val(data[15]);
        $('#documentstatus').val(data[16]);
        $('#key').val(data[18]);
        
    });

    $('.rejectbtn').on('click', function(){
        $tr = $(this).closest('tr');
        var data = $tr.children("td").map(function() {
            return $(this).text();
        }).get();
        console.log(data);
        $('#reject_id').val('<?=$key?>');
        $('#rejectdocumentstatus').val(data[16]);
        $('#reject_uid').val(data[17]);
        $('#rejectkey').val(data[18]);

        
    });

});
</script>
<?php
include('includes/profileoptions.php');
?>