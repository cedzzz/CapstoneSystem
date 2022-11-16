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
                                <form action="/">
                                  <h1 class="title">Manage Residents</h1>
                                  <fieldset>
                                    <legend>
                                      <h3>Details</h3>
                                    </legend>
                                    <div  class="personal-details">
                                      <div>
                                        <div><label>Name</label><input type="text" name="name" required></div>
                                        <div><label>Birthplace</label><input type="text" name="name"></div>
                                        <div><label>Birthdate</label><input type="date" name="name" required></div>
                                        <div><label>Nationality</label><input type="text" name="name"></div>
                                      </div>
                                      <div>
                                        <div><label>Religion</label><input type="text" name="name"></div>
                                        <div><label>Martial Status</label><input type="text" name="name"></div>
                                        <div><label>Contact Number*</label><input type="text" name="name"></div>                                        
                                        <div>
                                            <label>Gender</label>              
                                            <select required>
                                              <option value=""></option>
                                              <option value="">Male</option>
                                              <option value="">Female</option>
                                
                                            </select>
                                          </div>
                                      </div>
                                    </div>
                                  </fieldset>
                                  
                                  <button class="submitbtn" type="submit" href="/">Submit</button>
                                </form>
                                </div> 
                        </div>

                       
                    </div>

                


            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
    </div>

                            
</div>
<?php
include('includes/profileoptions.php');
?>