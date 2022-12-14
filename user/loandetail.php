<?php
include "../database/db.php";
include "../authentation.php";
session_start();
$target = $_SESSION['target'];
// to do: verify field names 
$type = $target['type'];
if ($type == "cust")
    $userid = $target['id'];
else {
    header("Location:../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User - Loan</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./style/user.css">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>

</head>

<body>
    <div class="container">
        <!-- header start-->
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
                                <a class="nav-link" href="../logout.php">
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
        <!-- body start-->
        <div class="row">
            <!-- sidebar start -->
            <div class="col-3 mt-5">
                <nav id="sidebar" class="col sidebar">
                    <ul class="nav flex-column vertical-nav ">
                        <li class="nav-item ">
                            <a class="nav-link" href="./profile.php">
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
                            <a class="nav-link active" href="./loan.php">
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
            <!-- main content start-->
            <div class="col-8 mt-5">
                <?php
                if ($_SERVER['REQUEST_METHOD'] == "GET") {
                    $id = $_GET["id"];
                    $sql = "SELECT * FROM records R inner join books B on R.bookid=B.bookid WHERE R.recordid = $id";
                    $query = $conn->query($sql);
                    $result = $query->fetch_assoc();

                    $query->free();
                    $conn->close();
                }
                ?>
                <div class="card">
                    <div class="card-header">
                        <h3>Loan Details</h3>
                    </div>
                    <div class="card-body">
                        <table  class="table table-striped table-hover table-light" style="margin-top: 1%;">
                            <tr>
                                <td><p class="card-text"><b>Record ID:</b>&nbsp;#<?php echo $result['recordid']; ?></p></td>
                                <td rowspan="4"><b>Images: </b><img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($result['images']); ?>" width="98" height="140" /></td>
                            </tr>
                            <tr>
                                <td><b>ISBN:</b>&nbsp;<?php echo $result['isbn']; ?></td>
                              
                            </tr>
                            <tr>
                                <td><b>Title:</b>&nbsp;<?php echo $result['booktitle']; ?></td>
                              
                            </tr>
                            <tr>
                                <td><b>Author:</b>&nbsp;<?php echo $result['author']; ?></td>
                               
                            </tr>
                            <tr>
                                <td><b>Out Date:</b>&nbsp;<?php echo $result['outdate']; ?></td>
                                <td><b>Due Date:</b>&nbsp;<?php echo $result['duedate']; ?></td>
                            </tr>                            
                        </table>
                        <a href="loan.php" class="btn btn-primary">Go back</a>
                    </div>
                </div>

            </div>
            <!-- main content end -->
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