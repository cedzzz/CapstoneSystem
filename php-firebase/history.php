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
                            <span class="badge bg-success float-end">4</span>
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
                                    <a href="resident.php?id=<?=$user->uid;?>">Residents</a>
                                </li>
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
                    <div class="container-fluid">
                    <h2>History</h2>
                    <h3>Barangay Santol</h3>
                    <p>Barangay Santol is one of the 38 barangays in the fourth district of Quezon City. It was created way back in 1956.

                        It was a part of a vast tract of land and was allegedly owned by the original residents whose claim to ownership was fortified by Spanish titles. In 1957, Tuazon Estate, administered by the Araneta's as the land owner and started sub-dividing the land and sold it to the present residents. Thru a court case, the Tuazon estate won over the original owners which are being recognized up to the present time.
                        
                        In 1953, a portion of the area was named Barangay Santol and its boundaries were well-defined only in the early sixties.</p>



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
                        
                    </script>

</body>

</html>