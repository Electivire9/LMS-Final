<?php
include "../database/db.php";
include "../authentation.php";
$target = $_SESSION['target'];
$type = $target['type'];
if($type !== "admin"){
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
    <title>Admin - Manage Books</title>
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
                                Admin Profile
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="./managebook.php">
                                <i class="bi bi-bookmarks-fill"></i>
                                Manage Books
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="./userinfo.php">
                                <i class="bi bi-briefcase-fill"></i>
                                User Info
                            </a>
                        </li>

                        <li class="nav-item mt-5">
                            <a class="nav-link" href="../index.php">
                                <i class="bi bi-door-open-fill"></i>
                                Logout
                            </a>
                        </li>
                    </ul>
                </nav>
            </div><!-- sidebar end -->
            <!-- main content start-->
            <div class="col-9 mt-5">
                <center>
                    <!-- search bar start-->
                    <div class="container-fluid searchbar">
                        <form class="d-flex" role="search" method="post">
                            <input class="form-control me-2" type="search" name="search" placeholder="Enter Book Title/Author" aria-label="Search">
                            <button class="btn btn-outline-success btn-search" type="submit" name="submit">Search</button>
                            &nbsp;&nbsp;
                            <button class="btn btn-success"><a href="addbook.php">Add</a></button>
                        </form>
                    </div>
                    <!--search bar end-->
                    <!-- table start-->
                    <table class="table table-striped table-hover table-light mt-1">
                        <thead>
                            <tr class="table-secondary">
                                <th>Book ID</th>
                                <th>ISBN</th>
                                <th>Title</th>
                                <th>Image</th>
                                <th>Author</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            if (isset($_POST['submit'])) {
                                $condition = $_POST['search'];
                                if ($condition == '') {
                                    $sel_query = "SELECT * FROM books";
                                } else {
                                    $sel_query = "SELECT * FROM books WHERE booktitle LIKE '%$condition%' OR author LIKE '%$condition%'";
                                }
                            } else {
                                $sel_query = "SELECT * FROM books";
                            }

                            $result = mysqli_query($conn, $sel_query);

                            while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td class="align-middle"><?php echo $row["bookid"]; ?></td>
                                    <td class="align-middle"><?php echo $row["isbn"]; ?></td>
                                    <td class="align-middle"><?php echo $row["booktitle"]; ?></td>
                                    <td><img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['images']); ?>" width="70" height="100" /></td>
                                    <td class="align-middle"><?php echo $row["author"]; ?></td>
                                    <td class="align-middle">
                                        <button class="btn btn-info"><a href="./editbook.php?bookid=<?php echo $row["bookid"]; ?>">Edit</a></button>
                                        <button class="btn btn-danger"><a href="./deletebook.php?bookid=<?php echo $row["bookid"]; ?>">Delete</a></button>
                                    </td>
                                </tr>
                            <?php $count++;
                            } ?>
                        </tbody>
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