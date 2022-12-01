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
                                        <th>Type of Document</th>
                                        <th>Type of Permit/Certificate</th>
                                        <th>PDF Document</th>
                                        <th>Status</th>
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
                                        <td><?=$row['documenttype'];?></td>
                                        <td><?=$row['permitcertificatetype'];?></td>
                                        <td style= "display: none;"><?=$row['documents'];?></td>
                                        <td><a href="<?=$row['documents'];?>" download="<?=$row['firstname'].' '.$row['lastname'].$row['documenttype'];?>" class = "btn btn-success btn-sm">Download</a></td>
                                        <td><?=$row['status'];?></td>
                                        <td style= "display: none;"><?=$fetchkey?></td>
                                        <td>
                                            <a href="#editDocumentsModal" class="edit editbtn" data-toggle="modal"><i
                                                    class="material-icons" style= "color: #FFDF00;" data-toggle="tooltip"
                                                    title="Edit">&#xE254;</i> </a>
                                        </td>
                                        <td>
                                            <a href="#deleteDocuments" style= "color: red;" class="delete deletebtn" data-toggle="modal"><i
                                                    class="material-icons" data-toggle="tooltip"
                                                    title="Delete">&#xE872;</i></a>
                                        </td>
                                        <td>
                                            <a href="#viewPDFModal" style= "color: blue;" class="view viewpdfbtn" data-toggle="modal"><i
                                                    class="material-icons" data-toggle="tooltip"
                                                    title="View" value="<?=$key?>">&#xf1c5;</i></a>
                                        </td>
                                        <td>
                                            <a href="#generateQR" style= "color: blue;" class="qrcode qrcodebtn" data-toggle="modal"><i
                                                    class="material-icons" data-toggle="tooltip"
                                                    title="QR" value="<?=$key?>">&#xef6b;</i></a>
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
     <!-- Edit Modal HTML -->
     <div id="editDocumentsModal" class="modal fade" data-backdrop="false">
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
                                <input type="hidden" name="edit_uid" id="edit_uid">
                                
                                    
                                </div>
                                <div class="modal-footer">
                                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                                    <button type="submit" name="updateadmindocu" class="btn btn-success">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div id="generateQR" class="modal fade" data-backdrop="false">
                    <div class="modal-dialog modal-xl modal-dialog-centered" style="width: 1000px;">
                        <div class="modal-content">
                            <form action="actioncode.php" method="POST" enctype="multipart/form-data">
                                <div class="modal-header">
                                    <h4 class="modal-title">Generate QR Code</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">
                                <input type="hidden" name="qr_id" id="qr_id">
                                <div class="form-group input-group">
                                        <label style="text-align: left;">Your QR Code</label>
                                        <img src="" id="qrdocu" width="100%" height="100%" />
                                    </div>
                                    
                                </div>
                                <div class="modal-footer">
                                    <input type="button" class="btn btn-primary" data-dismiss="modal" value="OK">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div id="viewPDFModal" class="modal fade" data-backdrop="false">
                    <div class="modal-dialog modal-xl modal-dialog-centered" style="width: 1000px;">
                        <div class="modal-content">
                            <form action="actioncode.php" method="POST" enctype="multipart/form-data">
                                <div class="modal-header">
                                    <h4 class="modal-title">View PDF</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">
                                <input type="hidden" name="view_id" id="view_id">
                                <div class="form-group input-group">
                                        <label style="text-align: left;">Your Document In PDF</label>
                                        <embed type="application/pdf" id="documentpdf" width="100%" height="300px" />
                                    </div>
                                    
                                </div>
                                <div class="modal-footer">
                                    <input type="button" class="btn btn-primary" data-dismiss="modal" value="OK">
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
        $('#del_uid').val(data[15]);
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
        $('#nationality').val(data[9]);
        $('#document_type').val(data[10]);
        $('.permitcertificatetype').val(data[11]);
        $('#documentstatus').val(data[14]);
        $('#edit_uid').val(data[15]);
        
    });
    $('.viewpdfbtn').on('click', function(){
        $tr = $(this).closest('tr');
        var data = $tr.children("td").map(function() {
            return $(this).text();
        }).get();
        console.log(data);
        var storedata = data[12];
        var pdf = document.getElementById('documentpdf');
        pdf.setAttribute('src', storedata+'#toolbar=0&navpanes=0&scrollbar=0');
        pdf.contentDocument.location.reload();

    });

    $('.qrcodebtn').on('click', function(){
        $tr = $(this).closest('tr');
        var data = $tr.children("td").map(function() {
            return $(this).text();
        }).get();
        console.log(data);
        var qr = document.getElementById('qrdocu');
        qr.src = "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl="+data[12];
    });

});
</script>
<script>
  function toggleDropdown(selObj) {
                            if(selObj.value == "Barangay Business Permit")
                            {
                                document.getElementById("businesspermit_type").style.display = "";
                                document.getElementById("barangaypermit_type").style.display = "none";
                                document.getElementById("barangaycertificate_type").style.display = "none";
                                document.getElementById("barangaypermit_type").selectedIndex = 0;
                                document.getElementById("barangaycertificate_type").selectedIndex = 0;


                            }
                            else if (selObj.value == "Barangay Permit")
                            {
                                document.getElementById("businesspermit_type").style.display = "none";
                                document.getElementById("barangaypermit_type").style.display = "";
                                document.getElementById("barangaycertificate_type").style.display = "none";
                                document.getElementById("businesspermit_type").selectedIndex = 0;
                                document.getElementById("barangaycertificate_type").selectedIndex = 0;
                                document.getElementById("otherspermit").style.display = "none";
                            }
                            else if (selObj.value == "Barangay Certificate")
                            {
                                document.getElementById("businesspermit_type").style.display = "none";
                                document.getElementById("barangaypermit_type").style.display = "none";
                                document.getElementById("barangaycertificate_type").style.display = "";
                                document.getElementById("businesspermit_type").selectedIndex = 0;
                                document.getElementById("barangaypermit_type").selectedIndex = 0;
                                document.getElementById("otherspermit").style.display = "none";
                            }
                            else 
                            {
                                document.getElementById("businesspermit_type").style.display = "none";
                                document.getElementById("barangaypermit_type").style.display = "none";
                                document.getElementById("barangaycertificate_type").style.display = "none";
                                document.getElementById("businesspermit_type").selectedIndex = 0;
                                document.getElementById("barangaypermit_type").selectedIndex = 0;
                                document.getElementById("barangaycertificate_type").selectedIndex = 0;
                                document.getElementById("otherspermit").style.display = "none";

                            }

                        }
                    function otherToggle(selectObj)
                    {
                        if(selectObj.value == "Others")
                                {
                                    document.getElementById("otherspermit").style.display = "";
                                    document.getElementById("othersinput").disabled = false;
                                }
                                else
                                {
                                    document.getElementById("otherspermit").style.display = "none";
                                    document.getElementById("othersinput").disabled = true;
                                }
                    }
</script>
<?php
include('includes/profileoptions.php');
?>