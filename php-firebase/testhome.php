<?php
include('authenticate.php');
include('includes/header.php');
?>

<div class ="container">
    <div class = "row justify-content-center">
        <div class = "col-md-12">
            <div class="card-header">

        <?php
        if(isset($_SESSION['status']))
        {
            echo "<h5 class='alert alert-success'>".$_SESSION['status']."</h5>";
            unset($_SESSION['status']);
        }
        elseif(isset($_SESSION['statusinfo']))
        {
            echo "<h5 class='alert alert-info'>".$_SESSION['statusinfo']."</h5>";
            unset($_SESSION['statusinfo']);
        }
        ?>

        <h2> TEST HOME PAGE </h2>
                </div>
        </div>
    </div>
</div>
