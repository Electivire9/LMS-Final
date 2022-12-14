<?php
include "../database/db.php";
include "../authentation.php";
$target = $_SESSION['target'];
$type = $target['type'];
if ($type !== "admin") {
    header("Location: ../index.php");
    exit();
}
// to do: verify field names
$id = $target['id'];

function test_input($data)
{
    $data = trim($data);
    $data = stripcslashes($data);
    $data = htmlspecialchars($data);
    return ($data);
}

$uPassword = $uPasswordc = "";
$uPasswordErr = $uPasswordcErr = "";

//

if (isset($_POST['modify'])) {
  

        $uPassword = test_input($_POST['newPass1']);
        $uPasswordc = test_input($_POST['newPass2']);
        // todo: validation and reset the password
        // to do: verify name of table, field name

        $uppercase = preg_match('/[A-Z]/', $uPassword);
        $lowercase = preg_match('/[a-z]/', $uPassword);
        $number = preg_match('/[0-9]/', $uPassword);
        $specialChars = preg_match('/\W/', $uPassword);

        if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($uPassword) < 8) {
            $uPasswordErr = "Invalid password: Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.";
        }

        if ($uPasswordc !== $uPassword) {
            $uPasswordcErr = "Two passwords are not same!";
        }

        if (!($uPasswordErr || $uPasswordcErr)) {
            $password = test_input($_POST['newPass1']);
            $str = "update user set password = '" . md5($password) . "' where id = '$id'";
            $res = mysqli_query($conn, $str);

            if ($res) {
                echo '<script> alert("Your password has been updated successfully");
                           window.location.href="../index.php";
                  </script>';
            } else {
                $mes = mysqli_error($conn);
                echo "<script> alert('Failed:$mes'); </script>";
            }
        }
    }else {
        
    }

 

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Modify Password</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./style/admin.css">
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
                            <a class="nav-link" href="../index.php">
                                <i class="bi bi-door-open-fill"></i>
                                Logout
                            </a>
                        </li>
                    </ul>
                </nav>
            </div><!-- sidebar end -->
            <!-- main content -->
            <div class="col-8 mt-5">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <div class="card">
                        <div class="card-header">
                            <h3>Modify Password</h3>
                        </div>
                        <div class="card-body text-left">
                        <div class="mb-3 row">
                                <label for="oldPass" class="col-2 col-form-label"><b>Old Password</b></label>
                                <div class="col-9">
                                    <input type="password" class="form-control" id="oldPass" name="oldPass">
                                    <input type="submit" name="confirm" value="Confirm" /> 
                                </div>
                               
                            </div>
                            <?php 
                            if(isset($_POST['confirm'])){
                                $uoPassword = test_input($_POST['oldPass']);
                                if ($target['password'] === md5($uoPassword)) {
                            ?>
                            <div class="mb-3 row">
                                <label for="newPass1" class="col-2 col-form-label"><b>New Password</b></label>
                                <div class="col-9">
                                    <input type="password" class="form-control" id="newPass1" name="newPass1">
                                </div>
                                <p class="error"><?php echo $uPasswordErr; ?></p>
                            </div>
                            <div class="mb-3 row">
                                <label for="newPass2" class="col-2 col-form-label"><b>Repeat New Password</b></label>
                                <div class="col-9">
                                    <input type="password" class="form-control" id="newPass1" name="newPass2">
                                </div>
                                <p class="error"><?php echo $uPasswordcErr; ?></p>
                            </div>
                            <button class="btn btn-primary" type="submit" name="modify">Modify</button>
                            <?php }
                            else {
                                echo "<script> alert('Your old password is not correct! please try again') </script>";
                            }
                        }?>
                        </div>
                    </div>
                </form>
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