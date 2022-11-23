<?php
include('authenticate.php');
include('dbcon.php');
$accountstatus = $auth->getUser($uid);
if($accountstatus->disabled){


?>
<script type="text/javascript">
window.location.href = 'logout.php';
</script>
<?php
    $_SESSION['statusred'] = "YOUR ACCOUNT HAS BEEN DISABLED!";
    exit(0);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Barangay Santol: Baranagay Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link href="/Capstone_System/assets/css/icons.min.css" rel="stylesheet" type="text/css">
    <link href="/Capstone_System/assets/css/app.min.css" rel="stylesheet" type="text/css" id="light-style">
    <link href="/Capstone_System/assets/css/app-dark.min.css" rel="stylesheet" type="text/css" id="dark-style">
    <link rel = "icon" type = "image/png" href = "logo.png">
</head>


<body class="loading"
    data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": false}'>

    <div class="wrapper">

        <div class="leftside-menu">


            <a href="index.php" style="text-decoration:none;" class="logo text-center logo-light">
                <span class="logo-lg">
                    <img src="logo.png" alt="" height="75">
                    <span>Barangay Santol</span>


                </span>

            </a>


            <a href="index.php" class="logo text-center logo-dark">
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
                            aria-controls="sidebarDashboards" class="side-nav-link" >
                            <i class="uil-home-alt"></i>
                            <span> Dashboard </span>
                        </a>
                        <div class="collapse" id="sidebarDashboards">
                            <ul class="side-nav-second-level">
                            <?php $claims = $auth->getUser($uid)->customClaims; if(isset($claims['admin']) == true):?>
                                <li>
                                    <a href="#" >Analytics</a>
                                </li>
                                <li>
                                    <a href="users.php?id=<?=$user->uid;?>">Manage Users</a>
                                </li>
                                <li>
                                    <a href="#">Manage Blotters</a>
                                </li>
                                <li>
                                    <a href="#">Manage Documents</a>
                                </li>
                            <?php else : ?>
                                <li>
                                    <a href="resident.php?id=<?=$user->uid;?>" style="text-decoration:none;"> Residents</a>
                                </li>
                                <li>
                                    <a href="blotter.php?id=<?=$user->uid;?>" style="text-decoration:none;">E-Blotter</a>
                                </li>
                                <li>
                                    <a href="history.php" style="text-decoration:none;">History</a>
                                </li>
                                <li>
                                    <a href="documents.php?id=<?=$user->uid;?>" style="text-decoration:none;">Documents</a>
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
                                        <a class="nav-link" href="index.php">
                                            <i class="dripicons-home noti-icon link-secondary"></i>
                                        </a>
                                    </li>

                                    <li class="dropdown notification-list">
                                        <a class="nav-link  arrow-none" data-bs-toggle="dropdown"
                                            href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                            <i class="dripicons-bell noti-icon link-secondary"></i>
                                            
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


                                    <?php
                                        $uid = $_SESSION['verified_user_id'];
                                        $user = $auth->getUser($uid);
                                    ?>
                                    <li class="dropdown notification-list">
                                        <a class="nav-link nav-user arrow-none me-0"
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
                                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
                                     
                                            <div class="dropdown-header noti-title">
                                                <h6 class="text-overflow m-0">Welcome <?=$user->displayName;?>! </h6>
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
                                    elseif(isset($_SESSION['statusred']))
                                    {
                                        echo "<h5 id='disappMsg' class='alert alert-danger'>".$_SESSION['statusred']."</h5>";
                                        unset($_SESSION['statusred']);
                                    }
                                    ?>
                           

                    
