<?php
include "../database/db.php";
include "../authentation.php";
$target = $_SESSION['target'];
$type = $target['type'];
if($type !== "cust"){
    header("Location: ../index.php");
    exit();
}

// to do: verify field names 
$name = $target['name'];
$id = $target['id'];
$email = $target['email'];
$password = $target['password'];
// 



    // to do: verify name of table, field name 
$query = "select * from user where email = '$email' and password ='".md5($password)."' ";

$res = mysqli_query($conn, $query) or die("Failed:".mysqli_error($conn));

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User-Library Management System</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./style/user.css">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>

</head>

<body>
    <!-- header -->
    <div class="container">
        <div class="row ">
            <div class="header fixed-top">
                <nav class="navbar navbar-expand-lg bg-light">
                    <div class="brand">
                        <i class="bi bi-book-half"></i>
                        <span class="navbar-brand ms-3">Library Management System</span>
                    </div>

                    <div class="collapse navbar-collapse mx-3" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-person-circle"></i>
                                    Account
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="dropdown-item"><i class="bi bi-person-circle"></i><b> Hello, <?php echo $_SESSION['target']['name']; ?></b></li>
                                    <li><a class="dropdown-item" href="./profile.php">User profile</a></li>
                                    <li><a class="dropdown-item" href="./editProfile.php">User setting</a></li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../index.php">
                                    <i class="bi bi-door-open-fill"></i>
                                    Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!-- header end -->
        <!-- body -->
        <div class="row">
            <!-- sidebar -->
            <div class="col-3 mt-5">
                <nav id="sidebar" class="col sidebar">
                    <ul class="nav flex-column vertical-nav ">
                        <li class="nav-item ">
                            <a class="nav-link active" href="./profile.php">
                                <i class="bi bi-person-circle"></i>
                                User Profile
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./searchbook.php">
                                <i class="bi bi-bookmarks-fill"></i>
                                Search Books
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./loan.php">
                                <i class="bi bi-briefcase-fill"></i>
                                Loan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./loanhistory.php">
                                <i class="bi bi-hourglass-bottom"></i>
                                Loan History
                            </a>
                        </li>
                        <li class="nav-item mt-5">
                            <a class="nav-link" href="../logout.php">
                                <i class="bi bi-door-open-fill"></i>
                                Logout
                            </a>
                        </li>
                    </ul>
                </nav>
            </div><!-- sidebar end -->
            <!-- main content -->
            <div class="col-8 mt-5">
                <center>
                    <div class="card" style="width: 50%;">
                        <img style="width: 50%;" src="../images/profile.png" class="card-img-top" alt="profile">
                        <div class="card-body">
                            <center>
                                <h1 class="card-title"><?php echo $name; ?></h1>
                            </center>
                            <p class="card-text">User ID:<?php echo $id; ?></p>
                            <p class="card-text">Email: <?php echo $email; ?></p>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="./editProfile.php" class="btn btn-secondary btn-search" tabindex="-1" role="button" aria-disabled="true">Edit Profile</a>
                    </div>
                </center>
            </div> <!-- main content end -->
        </div>
        <!--body end -->
      <!-- footer start-->
      <div class="row mt-5 text-center fixed-bottom footer">
            <div class="container pb-3 mt-3">
                <b class="copyright">&copy;Library Management System & Group PHP </b>All rights reserved.
            </div>
        </div>
        <!-- footer end-->
    </div>
</body>

</html>