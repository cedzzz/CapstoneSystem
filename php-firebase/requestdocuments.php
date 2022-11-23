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
                                <form action="actioncode.php" method = "POST">
                                  <h1 class="title">Request Documents</h1>
                                  <fieldset>
                                    <legend>
                                      <h3>Personal Information</h3>
                                    </legend>
                                    <div  class="personal-details">
                                      <div>
                                        <div><label>First Name</label><input type="text" class="form-control" name="first_name" required></div>
                                        <div><label>Middle Name</label><input type="text" class="form-control" name="middle_name" required></div>
                                        <div><label>Last Name</label><input type="text" class="form-control" name="last_name" required></div>
                                        <div>
                                            <label>Gender</label>              
                                            <select class="form-control" name="gender" required="">
		                                     <option disabled selected value="">-- select a gender --</option>
		                                     <option value="Male">Male</option>
		                                     <option value="Female">Female</option>
		                                    </select>
                                          </div><div><label>Age</label><input name="age" class="form-control"  placeholder="" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  required=""></div>
                                        
                                       
                                        
                                      </div>
                                      <div>
                                      <div><label>Birthdate</label><input type="date" name="birthdate" class="form-control" required></div>
                                        <div><label>Religion</label><input type="text" class="form-control" name="religion"></div>
                                        <div>
                                            <label>Marital Status</label>              
                                            <select class="form-control" name="marital_status" required="">
		                                     <option disabled selected value="">-- select a marital status --</option>
		                                     <option value="Single">Single</option>
		                                     <option value="Married">Married</option>
                                             <option value="Divorced">Divorced</option>
                                             <option value="Separated">Separated</option>
		                                    </select>
                                          </div>
                                          <div><label>Nationality</label><input type="text" class="form-control" name="nationality"></div>
                                          <div>
                                          <label>Type of Document</label>              
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

                                         <div id = "otherspermit" style = "display:none;"> <label>Others</label><input type = "text" class = "form-control" id= "othersinput" placeholder ="State the business type that you want a permit" name = "permitcertificate_type" disabled></div>
                                         
                                       
                            
                                                                                
                                        
                                      </div>
                                    </div>
                                  </fieldset>
                                  
                                  <button class="submitbtn" name="reqdoc" type="submit">Submit</button>
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