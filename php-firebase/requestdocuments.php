<?php
include('authenticate.php');
include('dbcon.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Barangay Santol: Baranagay Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/Capstone_System/assets/css/icons.min.css" rel="stylesheet" type="text/css">
    <link href="/Capstone_System/assets/css/app.min.css" rel="stylesheet" type="text/css" id="light-style">
    <link href="/Capstone_System/assets/css/app-dark.min.css" rel="stylesheet" type="text/css" id="dark-style">
    <link rel = "icon" type = "image/png" href = "logo.png">
    <link rel="stylesheet" href="popup.css">

</head>


<body class="loading"
    data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>

    <div class="wrapper">

        <div class="leftside-menu">


            <a href="dashboard.php" class="logo text-center logo-light">
                <span class="logo-lg">
                    <img src="logo.png" alt="" height="75">
                    <span>Barangay Santol</span>


                </span>

            </a>


            <a href="dashboard.php" class="logo text-center logo-dark">
                <span class="logo-lg">
                    <img src="logo-dark.png" alt="" height="16">
                </span>
                <span class="logo-sm">
                    <img src="logo_sm_dark.png" alt="" height="16">
                </span>
            </a>

            <div class="h-100" id="leftside-menu-container" data-simplebar="" style="overflow-x:hidden;overflow-y:hidden;">


                <ul class="side-nav">
                <?php
                $uid = $_SESSION['verified_user_id'];
                $user = $auth->getUser($uid);
                ?>
                    <li class="side-nav-title side-nav-item">Navigation</li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarDashboards" aria-expanded="false"
                            aria-controls="sidebarDashboards" class="side-nav-link">
                            <i class="uil-home-alt"></i>
                            <span class="badge bg-success float-end"></span>
                            <span> Dashboards </span>
                        </a>
                        <div class="collapse" id="sidebarDashboards">
                            <ul class="side-nav-second-level">
                            <?php $claims = $auth->getUser($uid)->customClaims; if(isset($claims['admin']) == true):?>
                                <li>
                                    <a href="#">Analytics</a>
                                </li>
                            <?php else : ?>
                                <li>
                                    <a href="#">Barangay Officials</a>
                                </li>
                                <li>
                                    <a href="blotter.php?id=<?=$user->uid;?>">E-Blotter</a>
                                </li>
                                <li>
                                    <a href="history.php">History</a>
                                </li>
                                <li>
                                    <a href="viewdocuments.php?id=<?=$user->uid;?>">Manage Documents</a>
                                </li>
                                <li>
                                    <a href="requestdocuments.php?id=<?=$user->uid;?>">Request Documents</a>
                                </li>
                                <li>
                                    <a href="resident.php?id=<?=$user->uid;?>">Residents</a>
                                </li>
                            <?php endif; ?>
                            </ul>
                        </div>
                    </li>



                    <div class="content-page">
                        <div class="content">

                            <div class="navbar-custom">
                                <ul class="list-unstyled topbar-menu float-end mb-0">
                                    <li class="dropdown notification-list d-lg-none">
                                        <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown"
                                            href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                            <i class="dripicons-search noti-icon"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-animated dropdown-lg p-0">
                                            <form class="p-3">
                                                <input type="text" class="form-control" placeholder="Search ..."
                                                    aria-label="Recipient's username">
                                            </form>
                                        </div>
                                    </li>
                                    <li class="notification-list">
                                        <a class="nav-link" href="dashboard.php">
                                            <i class="dripicons-home noti-icon link-secondary"></i>
                                        </a>
                                    </li>

                                    <li class="dropdown notification-list">
                                        <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown"
                                            href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                            <i class="dripicons-bell noti-icon link-secondary"></i>
                                            <span class="noti-icon-badge"></span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg">

                                           
                                            <div class="dropdown-item noti-title">
                                                <h5 class="m-0">
                                                    <span class="float-end">
                                                        <a href="javascript: void(0);" class="text-dark">
                                                            <small>Clear All</small>
                                                        </a>
                                                    </span>Notification
                                                </h5>
                                            </div>



                                      
                                            <a href="javascript:void(0);"
                                                class="dropdown-item text-center text-primary notify-item notify-all">
                                                View All
                                            </a>

                                        </div>
                                    </li>


                                    <li class="notification-list">
                                        <a class="nav-link end-bar-toggle" href="javascript: void(0);">
                                            <i class="dripicons-gear noti-icon link-secondary"></i>
                                        </a>
                                    </li>
                                    <?php
                                        $uid = $_SESSION['verified_user_id'];
                                        $user = $auth->getUser($uid);
                                    ?>
                                    <li class="dropdown notification-list">
                                        <a class="nav-link dropdown-toggle nav-user arrow-none me-0"
                                            data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                                            aria-expanded="false">
                                            <span class="account-user-avatar">
                                                <img src="<?=$user->photoUrl;?>" alt="user-image" onerror="this.src='logo.png';"
                                                    class="rounded-circle">
                                            </span>
                                            <span>
                                                

                                                <span class="account-user-name"><?=$user->displayName;?></span>
                                                <span class="account-position"><?php $claims = $auth->getUser($uid)->customClaims; if(isset($claims['admin']) == true) {echo "Admin";} elseif(isset($claims['super_admin']) == true) {echo "Super Admin";} elseif($claims == null) {echo "User";}?></span>
                                                

                                            </span>
                                        </a>
                                        <div
                                            class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
                                     
                                            <div class=" dropdown-header noti-title">
                                                <h6 class="text-overflow m-0">Welcome <?=$user->displayName;?> ! </h6>
                                            </div>

                                        
                                            <a href="profile.php?id=<?=$user->uid;?>" class="dropdown-item notify-item">
                                                <i class="mdi mdi-account-circle me-1"></i>
                                                <span>Profile</span>
                                            </a>

                                       
                                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                                <i class="mdi mdi-lifebuoy me-1"></i>
                                                <span>Support</span>
                                            </a>

                                    
                                            <a href="changepassword.php?id=<?=$user->uid;?>" class="dropdown-item notify-item">
                                                <i class="mdi mdi-lock-outline me-1"></i>
                                                <span>Change Password</span>
                                            </a>


                                            <a href="logout.php" class="dropdown-item notify-item">
                                                <i class="mdi mdi-logout me-1"></i>
                                                <span>Logout</span>
                                            </a>
                                        </div>
                                    </li>

                                </ul>
                                

                                <?php
                                    if(isset($_SESSION['status']))
                                    {
                                        echo "<h5 id='disappMsg' class='alert alert-success'>".$_SESSION['status']."</h5>";
                                        unset($_SESSION['status']);
                                    }
                                    elseif(isset($_SESSION['statusinfo']))
                                    {
                                        echo "<h5 id='disappMsg' class='alert alert-info'>".$_SESSION['statusinfo']."</h5>";
                                        unset($_SESSION['statusinfo']);
                                    }
                                    ?>
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
		                                     <option value="Barangay_BusinessPermit">Barangay Business Permit</option>
		                                     <option value="Barangay_Permit">Barangay Permit</option>
                                             <option value="Barangay_Certificate">Barangay Certificate</option>
                                             <option value="Barangay_WorkingPermit">Barangay Working Permit</option>
		                                    </select>

                                            <select class="form-control" name="businesspermit_type" id="businesspermit_type" style="display:none;" onchange = 'otherToggle(this)'>
		                                     <option disabled selected value="">-- select a business permit type to be requested --</option>
		                                     <option value="Sari-Sari_Store">Sari-Sari Store</option>
		                                     <option value="Liquor">Liquor Permit</option>
                                             <option value="Ambulant">Ambulant</option>
		                                     <option value="Bank_Factories">Banks and Factories</option>
                                             <option value="Gasoline_Station">Gasoline Station</option>
                                             <option value="Lessor">Lessor</option>
                                             <option value="Warehouse_Depot">Warehouse/Depot</option>
                                             <option value="Contractor">Contractor</option>
                                             <option value="Others">Others</option>
		                                    </select>
                                            

                                            <select class="form-control" name="barangaypermit_type" id="barangaypermit_type" style="display:none;">
		                                     <option disabled selected value="">-- select a permit type to be requested --</option>
		                                     <option value="Cable_Wire_Installation">For Cable and Wire Installation</option>
		                                     <option value="Excavation">For Excavation (Digging of Hole)</option>
                                             <option value="Demolition">For Demolition</option>
		                                     <option value="Construction">For Construction</option>
                                             <option value="Renovation_Repair">For Renovation and Repair of Comm'l Edifice</option>
                                             <option value="Fence_Construction">For Construction of Fence</option>
                                             <option value="Telcom_Tower">For Telecommunication Tower</option>
		                                    </select>

                                            <select class="form-control" name="barangaycertificate_type" id="barangaycertificate_type" style="display:none;">
		                                     <option disabled selected value="">-- select the purpose of the certificate to be requested --</option>
		                                     <option value="Residency_ID">Residency/Identification</option>
		                                     <option value="Local_Employment">Local Employment</option>
                                             <option value="Travel_Overseas">Travel/Overseas Employment</option>
		                                     <option value="Loan">Loan Purposes</option>
                                             <option value="Passport_Visa">Passport/VISA</option>
                                             <option value="Good_Moral">Good Moral Character</option>
                                             <option value="Birth_Requirement">Birth Certificate Requirement</option>
                                             <option value="Death_Requirement">Death Certificate Requirement</option>
                                             <option value="Marriage_Requirement">Marriage Certificate Requirement</option>
                                             <option value="Bail">Bail Bond Requirement</option>
                                             <option value="Firearms">Firearms License Requirement</option>
                                             <option value="Driver_License">Driver's License Requirements</option>
                                             <option value="Postal_ID">Postal ID Application/Requirements</option>
                                             <option value="GSIS_Requirement">GSIS Requirements</option>
                                             <option value="SSS_Requirement">SSS Requirements</option>
                                             <option value="Trike_Terminal">Trike Terminal Requirements</option>
                                             <option value="Tru_Franchise">Tru Franchise</option>
                                             <option value="Lipat_Bahay">Lipat Bahay/ Transporting of Belongings</option>
		                                    </select>
                                          </div>

                                         <div id = "otherspermit" style = "display:none;"> <label>Others</label><input type = "text" class = "form-control" placeholder ="State the business type that you want a permit" name = "othersbusiness"></div>
                                         
                                       
                            
                                                                                
                                        
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
                    
                      


                    </div>
                   
                    <div class="end-bar">

                        <div class="rightbar-title">
                            <a href="javascript:void(0);" class="end-bar-toggle float-end">
                                <i class="dripicons-cross noti-icon"></i>
                            </a>
                            <h5 class="m-0">Settings</h5>
                        </div>

                        <div class="rightbar-content h-100" data-simplebar="">

                            <div class="p-3">


                                <h5 class="mt-3">Color Scheme</h5>
                                <hr class="mt-1">

                                <div class="form-check form-switch mb-1">
                                    <input class="form-check-input" type="checkbox" name="color-scheme-mode"
                                        value="light" id="light-mode-check" checked="">
                                    <label class="form-check-label" for="light-mode-check">Light Mode</label>
                                </div>

                                <div class="form-check form-switch mb-1">
                                    <input class="form-check-input" type="checkbox" name="color-scheme-mode"
                                        value="dark" id="dark-mode-check">
                                    <label class="form-check-label" for="dark-mode-check">Dark Mode</label>
                                </div>
                                
                            </div> 

                        </div>
                    </div>
                    <div class="rightbar-overlay"></div>
                 
                    <script src="/Capstone_System/assets/js/vendor.min.js"></script>
                    <script src="/Capstone_System/assets/js/app.min.js"></script>

                  
                    <script src="/Capstone_System/assets/js/vendor/apexcharts.min.js"></script>
                    <script src="/Capstone_System/assets/js/vendor/jquery-jvectormap-1.2.2.min.js"></script>
                    <script src="/Capstone_System/assets/js/vendor/jquery-jvectormap-world-mill-en.js"></script>
                 
                    <script src="/Capstone_System/assets/js/pages/demo.dashboard.js"></script>
                    <script>
                        function hideMessage() {
                            document.getElementById("disappMsg").style.display = "none";
                        };
                        setTimeout(hideMessage, 2000);
                        function toggleDropdown(selObj) {
                            if(selObj.value == "Barangay_BusinessPermit")
                            {
                                document.getElementById("businesspermit_type").style.display = "";
                                document.getElementById("barangaypermit_type").style.display = "none";
                                document.getElementById("barangaycertificate_type").style.display = "none";
                                document.getElementById("barangaypermit_type").selectedIndex = 0;
                                document.getElementById("barangaycertificate_type").selectedIndex = 0;
                                
                                
                            }
                            else if (selObj.value == "Barangay_Permit")
                            {
                                document.getElementById("businesspermit_type").style.display = "none";
                                document.getElementById("barangaypermit_type").style.display = "";
                                document.getElementById("barangaycertificate_type").style.display = "none";
                                document.getElementById("businesspermit_type").selectedIndex = 0;
                                document.getElementById("barangaycertificate_type").selectedIndex = 0;
                                document.getElementById("otherspermit").style.display = "none";
                            }
                            else if (selObj.value == "Barangay_Certificate")
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
                                }
                                else
                                {
                                    document.getElementById("otherspermit").style.display = "none";
                                }
                    }
                    </script>

</body>

</html>