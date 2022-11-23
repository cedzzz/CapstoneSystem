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
                                        <h2>Manage <b>Documents</b></h2>
                                        <a href="#requestDocuments" class="btn btn-success" data-toggle="modal"><i
                                                class="material-icons">&#xE147;</i> <span>Request A Document</span></a>
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
                                    $fetchdata = $database->getReference($ref_table)->getChild($uid)->getValue();
                                    if ($fetchdata > 0)
                                                    {
                                                        $x = 1;
                                                        foreach($fetchdata as $key  => $row)
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
                                        <td><?=$row['nationality'];?></td>
                                        <td><?=$row['documenttype'];?></td>
                                        <td><?=$row['permitcertificatetype'];?></td>
                                        <td style= "display: none;"><?=$row['documents'];?></td>
                                        <td><a href="<?=$row['documents'];?>" download="<?=$row['firstname'].' '.$row['lastname'].$row['documenttype'];?>" class = "btn btn-success btn-sm">Download</a></td>
                                        <td><?=$row['status'];?></td>
                                        <td>
                                            <a href="#deleteDocuments" style= "color: red;" class="delete deletebtn" data-toggle="modal"><i
                                                    class="material-icons" data-toggle="tooltip"
                                                    title="Delete" value="<?=$key?>">&#xE872;</i></a>
                                        </td>
                                        <td>
                                            <a href="#viewPDFModal" style= "color: blue;" class="view viewbtn" data-toggle="modal"><i
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
                                                    else{

                                                            echo "<h5 id='disappMsg' class='alert alert-danger'>"."NO RECORDS FOUND!"."</h5>";
                                                        }
                                                    ?>

                <!-- Request Modal  -->
                <div id="requestDocuments" class="modal fade" data-backdrop="false">
                    <div class="modal-dialog  modal-dialog-centered">
                        <div class="modal-content">
                            <form action="actioncode.php" method="POST" enctype="multipart/form-data">
                                <div class="modal-header">
                                    <h4 class="modal-title">Request a Document</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">First Name</label>
                                        <input type="text" class="form-control" name="first_name"  required>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Middle Name</label>
                                        <input type="text" class="form-control" name="middle_name"  required>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Last Name</label>
                                        <input type="text" class="form-control" name="last_name" required>
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
                                        <input name="age" class="form-control"  placeholder="" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  required="">
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Birthdate</label>
                                        <input type="date" name="birthdate" class="form-control" required>
                                    </div>
                                    <div class="form-group input-group">
                                        <label style="text-align: left;">Religion</label>
                                        <input type="text" class="form-control" name="religion">
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
                                        <label style="text-align: left;">Nationality</label>
                                        <input type="text" class="form-control" name="nationality"  required>
                                    </div>
                                    <div class="form-group input-group">
                                    <label style="text-align: left;">Type of Document</label>
                                    <select class="form-control" name="document_type" id="document_type" required="" onchange='toggleDropdown(this);'>
		                                     <option disabled selected value="">-- select a document to be requested --</option>
		                                     <option value="Barangay Business Permit">Barangay Business Permit</option>
		                                     <option value="Barangay Permit">Barangay Permit</option>
                                             <option value="Barangay Certificate">Barangay Certificate</option>
                                             <option value="Barangay Working Permit">Barangay Working Permit</option>
		                                    </select>

                                            <select class="form-control" name="permitcertificate_type" id="businesspermit_type" style="display:none;" onchange = 'otherToggle(this)'>
		                                     <option disabled selected value="">-- select a business permit type to be requested --</option>
		                                     <option value="Sari-Sari Store">Sari-Sari Store</option>
		                                     <option value="Liquor">Liquor Permit</option>
                                             <option value="Ambulant">Ambulant</option>
		                                     <option value="Banks And Factories">Banks and Factories</option>
                                             <option value="Gasoline Station">Gasoline Station</option>
                                             <option value="Lessor">Lessor</option>
                                             <option value="Warehouse Depot">Warehouse/Depot</option>
                                             <option value="Contractor">Contractor</option>
                                             <option value="Others">Others</option>
		                                    </select>
                                            

                                            <select class="form-control" name="permitcertificate_type" id="barangaypermit_type" style="display:none;">
		                                     <option disabled selected value="">-- select a permit type to be requested --</option>
		                                     <option value="Cable Wire Installation">For Cable and Wire Installation</option>
		                                     <option value="Excavation">For Excavation (Digging of Hole)</option>
                                             <option value="Demolition">For Demolition</option>
		                                     <option value="Construction">For Construction</option>
                                             <option value="Renovation Repair">For Renovation and Repair of Comm'l Edifice</option>
                                             <option value="Fence Construction">For Construction of Fence</option>
                                             <option value="Telcom Tower">For Telecommunication Tower</option>
		                                    </select>

                                            <select class="form-control" name="permitcertificate_type" id="barangaycertificate_type" style="display:none;">
		                                     <option disabled selected value="">-- select the purpose of the certificate to be requested --</option>
		                                     <option value="Residency ID">Residency/Identification</option>
		                                     <option value="Local Employment">Local Employment</option>
                                             <option value="Travel Overseas">Travel/Overseas Employment</option>
		                                     <option value="Loan">Loan Purposes</option>
                                             <option value="Passport Visa">Passport/VISA</option>
                                             <option value="Good Moral">Good Moral Character</option>
                                             <option value="Birth Requirement">Birth Certificate Requirement</option>
                                             <option value="Death Requirement">Death Certificate Requirement</option>
                                             <option value="Marriage Requirement">Marriage Certificate Requirement</option>
                                             <option value="Bail">Bail Bond Requirement</option>
                                             <option value="Firearms">Firearms License Requirement</option>
                                             <option value="Driver License">Driver's License Requirements</option>
                                             <option value="Postal ID">Postal ID Application/Requirements</option>
                                             <option value="GSIS Requirement">GSIS Requirements</option>
                                             <option value="SSS Requirement">SSS Requirements</option>
                                             <option value="Trike Terminal">Trike Terminal Requirements</option>
                                             <option value="Tru Franchise">Tru Franchise</option>
                                             <option value="Lipat Bahay">Lipat Bahay/ Transporting of Belongings</option>
		                                    </select>

                                    </div>
                                         <div class="form-group input-group" id = "otherspermit" style = "display:none;"> <label style= "text-align: left;">Others</label><input type = "text" class = "form-control" id= "othersinput" placeholder ="State the business type that you want a permit" name = "permitcertificate_type" disabled></div>
                                </div>
                                <div class="modal-footer">
                                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                                    <button type="submit" name="reqdoc" class="btn btn-success">Request Document</button>
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
                                    <p>Are you sure you want to delete this record?</p>
                                    <p class="text-warning"><small>This action cannot be undone!</small></p>
                                </div>
                                <div class="modal-footer">
                                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                                    <button type="submit" name="deletedoc" class="btn btn-danger">Delete</button>
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
                                    <h4 class="modal-title">Delete Documents</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="del_id" id="del_id">
                                    <p>Are you sure you want to delete all your documents?</p>
                                    <p class="text-warning"><small>This action cannot be undone!</small></p>
                                </div>
                                <div class="modal-footer">
                                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                                    <button type="submit" name="deletealldoc" class="btn btn-danger">Delete</button>
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
    $('.viewbtn').on('click', function(){
        $tr = $(this).closest('tr');
        var data = $tr.children("td").map(function() {
            return $(this).text();
        }).get();
        console.log(data);
        $('#view_id').val('<?=$key?>');
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