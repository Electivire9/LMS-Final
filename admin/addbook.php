<?php
include "../database/db.php";
include "../authentation.php";
$target = $_SESSION['target'];
$type = $target['type'];
if($type !== "admin"){
    header("Location:../index.php");
    exit();
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

//define variables and set to empty values
$isbnErr = "";
$isbn =  "";
$isbnv = true;

$status = $statusMsg = '';

if (isset($_POST["submit"])) {
    $status = 'error';
    // ISBN validation
    if (empty($_POST["isbn"])) {
        $isbnErr = " ISBN is required / ";
        $isbnv = false;
    } else {
        $isbn = test_input($_POST["isbn"]);
        if (!preg_match("@^978-\d{10}$@", $isbn)) {
            $isbnErr = " Please Enter 13 digits ISBN. Format: xxx-xxxxxxxxxx/ ";
            $isbnv = false;
        }
    }

    if (!empty($_FILES["image"]["name"])) {
        // Get file info 
        $fileName = basename($_FILES["image"]["name"]);
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

        // Allow certain file formats 
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
        if (in_array($fileType, $allowTypes) && $isbnv) {
            $bookid = $_REQUEST['bookid'];
            $isbn = $_REQUEST['isbn'];
            $booktitle = $_REQUEST['booktitle'];
            $author = $_REQUEST['author'];

            $image = $_FILES['image']['tmp_name'];
            $imgContent = addslashes(file_get_contents($image));
            // Insert image content into database 
            $insert = $conn->query("INSERT into books (bookid,isbn,booktitle,author,images) VALUES ('$bookid','$isbn','$booktitle','$author','$imgContent')");

            if ($insert) {
                $status = "Book added successfully.";
                $record = "ADD | Book ID: ". $bookid . ", ISBN: " . $isbn . ", Book Title: " . $booktitle . ", Author: " . $author . ", Edit time: " . date("Y-m-d H:i:s", time()-6*60*60) . "\n";
                file_put_contents("Record.txt", $record, FILE_APPEND) > 0;
            } else {
                $statusMsg = "File upload failed, please try again.";
            }
        } else {
            $statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.';
        }
    } else {
        $statusMsg = 'Please select an image file to upload.';
    }
}

// Display status message 
// echo $statusMsg; 
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Add Book</title>
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
        <div class="row">
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
                            <a class="nav-link active" href="./managebook.php">
                                <i class="bi bi-bookmarks-fill"></i>
                                Manage Books
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./userinfo.php">
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
            <div class="col-8 mt-5">
                <div class="form" align="center">
                    <div>
                        <h1 mt-5 style="color:#FF0000;"><?php echo $status; ?></h1>
                        <form name="form" method="post" action="" enctype="multipart/form-data">
                            <input type="hidden" name="new" value="1" />
                            <table class="table table-striped table-hover table-light" style="margin-top: 8%;">
                                <tr>
                                    <td colspan="2">
                                        <h1>Insert New Book</h1>
                                    </td>
                                </tr>
                                <tr class="table-secondary">
                                    <td>Book ID: </td>
                                    <td><input type="text" name="bookid" /></td>
                                </tr>
                                <tr class="table-secondary">
                                    <td>ISBN: </td>
                                    <td><input type="text" name="isbn" required /></td>
                                    <span class="error"><?php echo $isbnErr; ?></span>
                                </tr>
                                <tr class="table-secondary">
                                    <td>Book Title:</td>
                                    <td><input type="text" name="booktitle" required /></td>
                                </tr>
                                <tr class="table-secondary">
                                    <td>Author:</td>
                                    <td><input type="text" name="author" required /></td>
                                </tr>
                                <tr class="table-secondary">
                                    <td>Image:</td>
                                    <td><input type="file" name="image"></td>
                                </tr>
                            </table>
                            <button class="btn btn-info btn-search" name="submit">Submit</button>
                        </form>
                    </div>
                </div>
            </div><!-- main content end -->
        </div>
        <!--body end -->

        <!-- footer -->
        <div class="row mt-5">
            <div class="footer fixed-bottom">
                <div class="container mt-3">
                    <b class="copyright">&copy;Library Management System & Group PHP </b>All rights reserved.
                </div>
            </div>
        </div>
    </div>
</body>

</html>