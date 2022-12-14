<?php
include "../database/db.php";
include "../authentation.php";
$target = $_SESSION['target'];
$type = $target['type'];
if($type !== "admin"){
    header("Location: ../index.php");
    exit();
}
// to do: verify field names
$uName = $target['name'];
$userId = $target['id'];
$uEmail = $target['email'];
$uPhone = $target['phone'];
$expireDate = $target['expireDate'];
$type = $target['type'];

//
function test_input($data)
{
    $data = trim($data);
    $data = stripcslashes($data);
    $data = htmlspecialchars($data);
    return ($data);
}

$uPhoneErr = $uEmailErr = "";

if (isset($_POST['update'])) {

    // todo: validation and reset the values of phone and email
    $uName = test_input($_POST['name']);
    $uEmail = test_input($_POST['email']);
    $uPhone = test_input($_POST['phone']);

    if (!preg_match("/^1[0-9]{10}$/", $uPhone)) {
        $uPhoneErr = "Invalid phone number";
    }

    if (!filter_var($uEmail, FILTER_VALIDATE_EMAIL)) {
        $uEmailErr = "Invalid email format";
    }

    if (!($uPhoneErr || $uEmailErr)) {
        $uPhone = mysqli_real_escape_string($conn, $uPhone);
        $uEmail = mysqli_real_escape_string($conn, $uEmail);
        // to do: verify name of table, field name
        $str = "update user set name = '$uName',phone ='$uPhone', email = '$uEmail' where id = '$userId'";
        $res = mysqli_query($conn, $str);

        if ($res) {
            $query = "select * from user where id = '$userId'";
            $nres = mysqli_query($conn, $query) or die("Failed:".mysqli_error($conn)); 
            $_SESSION['target']= mysqli_fetch_assoc($nres);
            echo '<script> alert("Your info has been updated successfully");</script>';
            header("Location:./profile.php");
        } else {
            $mes = mysqli_error($conn);
            echo "<script> alert('Failed:$mes'); </script>";
        }
    }
}

// if(isset($_POST['modify'])){

//     // todo: validation and reset the password
//     // to do: verify name of table, field name
// $str = "update personnel set email = '$email', phone ='$phone' where userId = '$id'";
// $res = mysqli_query($conn, $str);

// if($res){
//     echo '<script> alert("Your password has been updated successfully");</script>';
// } else {
//     $mes =mysqli_error($conn);
//     echo  "<script> alert('Failed:$mes'); </script>";
// }
//}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Edit Profile</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./style/admin.css">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>

</head>

<body>
    <div class="container">
    <!-- header start -->
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
        <!-- body -->
        <div class="row">
            <!-- sidebar -->
            <div class="col-3 mt-5">
                <nav id="sidebar" class="col sidebar">
                    <ul class="nav flex-column vertical-nav ">
                        <li class="nav-item ">
                            <a class="nav-link active" href="./profile.php">
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
                            <a class="nav-link" href="./userinfo.php">
                                <i class="bi bi-briefcase-fill"></i>
                                User Info
                            </a>
                        </li>

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

            <!-- main start -->
            <div class="col-8 mt-5">
                <center>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                        <div class="card" style="width: 70%;">
                            <img style="width: 30%;" src="../images/profile.png" class="card-img-top" alt="profile">
                            <div class="card-body text-center">
                                <div class="mb-3 row">
                                    <label for="name" class="col-3 col-form-label">Name</label>
                                    <div class="col-9">
                                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $uName; ?>">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="email" class="col-3 col-form-label">Email</label>
                                    <div class="col-9">
                                        <input type="text" class="form-control" id="email" name="email" value="<?php echo $uEmail; ?>">
                                    </div>
                                    <p class="error"><?php echo $uEmailErr; ?></p>
                                </div>
                                <div class="mb-3 row">
                                    <label for="phone" class="col-3 col-form-label">Phone Number</label>
                                    <div class="col-9">
                                        <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $uPhone; ?>">
                                    </div>
                                    <p class="error"><?php echo $uPhoneErr; ?></p>
                                </div>
                                <div class="mb-3 row">
                                    <?php
                                    if ($type == "cust") {
                                        echo "<label for='expireDate' class='col-sm-2 col-form-label'>Expire Date:</label>";
                                        echo "<div class='col-sm-10'>
                                                <input type='text' id='expireDate' name='expireDate' class='form-control' value = '$expireDate' disabled /><br>
                                              </div>
                                    ";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button class="btn btn-outline-success btn-submit btn-search" type="submit" name="update">Update</button>
                            <button class="btn btn-outline-success btn-submit btn-search" type="submit" name="modify"><a href="./modifyPassword.php">Modify Password</a></button>
                        </div>
                    </form>
                </center>
            </div>
            <!-- main end -->
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