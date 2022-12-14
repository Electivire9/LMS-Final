<?PHP
include "../database/db.php";
include "../authentation.php";
$target = $_SESSION['target'];
$type = $target['type'];
if($type !== "admin"){
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - User Info</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./style/admin.css">
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
                                    <li><a class="dropdown-item" href="./profile.php">Admin profile</a></li>
                                    <li><a class="dropdown-item" href="./editProfile.php">Admin setting</a></li>
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
        <!-- body start-->
        <div class="row">
            <!-- sidebar start -->
            <div class="col-3 mt-5">
                <nav id="sidebar" class="col sidebar">
                    <ul class="nav flex-column vertical-nav ">
                        <li class="nav-item ">
                            <a class="nav-link" href="./profile.php">
                                <i class="bi bi-person-circle"></i>
                                Admin Profile
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./managebook.php">
                                <i class="bi bi-bookmarks-fill"></i>
                                Manage Books
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="./userinfo.php">
                                <i class="bi bi-briefcase-fill"></i>
                                User Info
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
                <center>
                    <!-- search bar start-->
                    <div class="container-fluid searchbar">
                        <form class="d-flex" role="search" action="userinfo.php" method="post">
                            <input class="form-control me-2" type="search" name="search_bar" placeholder="Enter User ID/Name/Email" aria-label="Search">
                            <!-- <button class="btn btn-search" type="submit" name="search">Search</button> -->
                            <button class="btn btn-outline-success btn-search" type="submit" name="search">Search</button>
                        </form>
                    </div>
                    <br>
                    <!--search bar end-->
                    <!-- table start-->
                    <?php
                    if (isset($_POST['search'])) {
                        $search = $_POST['search_bar'];
                        $sql = "SELECT * FROM user WHERE (id = '$search' or name like '%$search%' or email = '$search') and type='cust' ORDER BY id DESC";
                    } else {
                        $sql = "SELECT * FROM user WHERE type = 'cust' ORDER BY id DESC";
                    }
                    $result =  $conn->query($sql);
                    $rowcount = mysqli_num_rows($result);
                    if (!$rowcount) {
                        echo "<br><center><h2 style='color:aliceblue;'><b><i>No Results</i></b></h2></center>
                        <a href='./userinfo.php' class='btn btn-primary btn-search'>Go back</a>
                        ";
                    } else {
                    ?>
                        <table class="table table-striped table-hover table-light mt-1">
                            <tr class="table-secondary">
                                <th>User ID</th>
                                <th>User Name</th>
                                <th>Email</th>
                                <th>Expire Date</th>
                                <th>Action</th>
                            </tr>
                        <?php
                        while ($row = $result->fetch_assoc()) {

                            echo "
                                <tr>
                                    <td>$row[id]</td>
                                    <td>$row[name]</td>
                                    <td>$row[email]</td>
                                    <td>$row[expireDate]</td>
                                    <td>
                                        <button class='btn btn-info btn-search'><a href='./userdetail.php?id=$row[id]'>Detail</a></button>
                                    </td>
                                </tr>
                                ";
                        }

                        $result->free();
                        $conn->close();
                    } ?>
                        </table>
                        <!-- table end -->
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