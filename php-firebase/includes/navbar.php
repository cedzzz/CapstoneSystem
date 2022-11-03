<nav class = "navbar navbar-expand-lg navbar-dark bg-dark">
    
    <div class = "container-fluid">
        <a class = "navbar-brand" href="#"> 
        <img src="logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
            BARANGAY SANTOL MANAGEMENT SYSTEM
        </a>
        <button class = "navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target = "#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class = "collapse navbar-collapse" id="navbarSupportedContent">
            <ul class = "nav navbar-nav ml-auto mb-2 mb-lg-0">
                
                <li class = "nav-item">
                    <a class= "nav-link" href = "testhome.php">Home</a>
                </li>
                <li class = "nav-item">
                    <a class= "nav-link" href = "#">About</a>
                </li>
                
                <?php if(!isset($_SESSION['verified_user_id'])) : ?>
                <li class = "nav-item">
                    <a class= "nav-link" href = "register.php">Register</a>
                </li>
                <li class = "nav-item">
                    <a class= "nav-link" href = "login.php">Login</a>
                </li>
                <?php else : ?>
                <li class = "nav-item">
                    <a class= "nav-link" href = "logout.php">Logout</a>
                </li>
                <?php endif; ?>
</div>
</div>
</nav>
                