<?php
include('includes/dashboard.php');

?>
<head>
<link href="/Capstone_System/assets/css/icons.min.css" rel="stylesheet" type="text/css">
    <link href="/Capstone_System/assets/css/app.min.css" rel="stylesheet" type="text/css" id="light-style">
    <link rel = "icon" type = "image/png" href = "logo.png">
    <link rel="stylesheet" href="popup.css">
</head>
<div class="container-fluid">
                            <div class="main-block">
                                <form action="actioncode.php" method = "POST" enctype="multipart/form-data">
                                  <h1 class="title">E-Blotter</h1>
                                  <fieldset>
                                    <legend>
                                      <h3>Add Blotter</h3>
                                    </legend>
                                    <div  class="personal-details">
                                      <div>
                                        <div><label>Complainant's First Name</label><input type="text" name="complainant_firstname"  required></div>
                                        <div><label>Complainant's Middle Name</label><input type="text" name="complainant_middlename"  required></div>
                                        <div><label>Complainant's Last Name</label><input type="text" name="complainant_lastname"  required></div>
                                        <div><label>Complainant's Address</label><input type="text" name="complainant_address" required></div>
                                        <div><label>Incident</label><textarea name="incident" id="incident1" class="text" cols="30" rows ="10" required></textarea></div>
                                        
                                      </div>
                                      <div>
                                      <div><label>Complainee's First Name</label><input type="text" name="complainee_firstname"></div>
                                        <div><label>Complainee's Middle Name</label><input type="text" name="complainee_middlename"></div>
                                        <div><label>Complainee's Last Name</label><input type="text" name="complainee_lastname"></div>
                                        <div><label>Complainee's Address</label><input type="text" name="complainee_address" required></div>
                                        <div><label>Photo/Video of the Incident</label><input type = "file" name = "blotter_evidence" class = "form-control" required></div>
                                      </div>
                                    </div>
                                  </fieldset>
                                  
                                  <button class="submitbtn" name="addblot" type="submit">Submit</button>
                                </form>
                                </div>

                            </div>
        </div>
    </div>

                            
</div>
<?php
include('includes/profileoptions.php');
?>