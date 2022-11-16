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
                                  <h1 class="title">View Documents</h1>
                                  <fieldset>
                                    <legend>
                                      <h3>Details</h3>
                                    </legend>
                                    <div  class="personal-details">
                                      <div class = "row">
                                      <h4>Total No. of Documents:
                                                <?php
                                                 $uid = $_SESSION['verified_user_id'];
                                                $ref_table = 'userdocuments';
                                                $total_count =  $database->getReference($ref_table)->getChild($uid)->getSnapshot()->numChildren();
                                                echo $total_count;
                                                ?>
                                            </h4>
                                        <div class = "card-body">
                                            
                                            <table class = "table table-hover table-bordered table-dark table-striped">
                                                <thead>
                                                    <tr class = "d-flex">
                                                        <th>Row No</th>
                                                        <th>First Name</th>
                                                        <th>Middle Name</th>
                                                        <th>Last Name</th>
                                                        <th>Document</th>
                                                        <th>Download Document</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $uid = $_SESSION['verified_user_id'];
                                                    $ref_table = 'userdocuments';
                                                    $fetchdata = $database->getReference($ref_table)->getChild($uid)->getValue();
                                                    if ($fetchdata > 0)
                                                    {
                                                        $x = 1;
                                                        foreach($fetchdata as $key  => $row)
                                                        {
                                                            ?>
                                                            <tr class = "d-flex">
                                                                <td><?=$x++;?></td>
                                                                <td><?=$row['firstname'];?></td>
                                                                <td><?=$row['middlename'];?></td>
                                                                <td><?=$row['lastname'];?></td>
                                                                <td><img src="<?= $row['documents'];?>" class="img-fluid"></td>
                                                                <td>
                                                                    <a href="<?=$row['documents'];?>" download="<?=$row['documents'];?>" class = "btn btn-success btn-sm">Download</a>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>

                                      </div>
                                    </div>
                                  </fieldset>
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