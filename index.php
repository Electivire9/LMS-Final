<?php
include "./database/db.php";
$mes = "";
session_start();

if (isset($_POST['forgetpassword'])) {
    header("Location:./user/forgetpass.php");
}

if (isset($_POST['signin'])) {

    $iemail = mysqli_real_escape_string($conn, $_POST['email']);
    $ipassword = mysqli_real_escape_string($conn, $_POST['password']);

    //verify name of table
    $query = "select * from user where email = '$iemail' and password ='" . md5($ipassword) . "'";
    $res = mysqli_query($conn, $query) or die("query failed: " . mysqli_error($conn));

    $rnum = mysqli_num_rows($res);

    if ($rnum == 1) {
        $target = mysqli_fetch_assoc($res);
        $_SESSION['target'] = $target;
        if ($target['type'] === "admin") {
            header("Location: ./admin/profile.php ");
        } else {
            header("Location: ./user/profile.php ");
        }
    } else {
        $mes = "Incorrect email or password.";
    }
}

function test_input($data)
{
    $data = trim($data);
    $data = stripcslashes($data);
    $data = htmlspecialchars($data);
    return ($data);
}

$uName = $uPhone = $uEmail = $uPassword = $uPasswordc = "";
$uNameErr = $uPhoneErr = $uEmailErr = $uPasswordErr = $uPasswordcErr = "";

if (isset($_POST['signup'])) {

    // advanced validation
    $uName = test_input($_POST['name']);

    $uPhone = test_input($_POST['phone']);
    $uEmail = test_input($_POST['email']);
    $uPassword = test_input($_POST['password']);
    $uPasswordc = test_input($_POST['password_confirmation']);

    if (!preg_match("/[\w -]{1,}/", $uName)) {
        $uNameErr = "Invalid name format";
    }
    // start from 1, totally 11 digits
    // if (!preg_match("/^1[0-9]{10}$/", $uPhone)) {
    //     $uPhoneErr = "Invalid phone number";
    // }

    if (!filter_var($uEmail, FILTER_VALIDATE_EMAIL)) {
        $uEmailErr = "Invalid email format";
    }
    // at least 1 lowercase AND 1 uppercase AND 1 number AND 1 symbol
    $uppercase = preg_match('/[A-Z]/', $uPassword);
    $lowercase = preg_match('/[a-z]/', $uPassword);
    $number = preg_match('/[0-9]/', $uPassword);
    $specialChars = preg_match('/\W/', $uPassword);

    if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($uPassword) < 8) {
        $uPasswordErr = "Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.";
    }

    if ($uPasswordc !== $uPassword) {
        $uPasswordErr = "The two passwords are not same!";
    }

    // if ($uNameErr == "" && $uPhoneErr = "" && $uEmailErr == "" && $uPasswordErr == "" && $uPasswordcErr= ""){
    if (!($uNameErr || $uPhoneErr || $uEmailErr || $uPasswordErr || $uPasswordcErr)) {

        $uName = mysqli_real_escape_string($conn, $uName);

        $uPhone = mysqli_real_escape_string($conn, $uPhone);
        $uEmail = mysqli_real_escape_string($conn, $uEmail);
        $uPassword = mysqli_real_escape_string($conn, $uPassword);
        //? $issuDate = date("Y-m-d");
        $uExpireDate = date('Y-m-d H:i:s', strtotime('+1year'));

        // to do: verify name of table, fields and orders
        $str = "insert into user(name,email,phone,password,expireDate) values ('$uName', '$uEmail', '$uPhone','" . md5($uPassword) . "','$uExpireDate')";
        $res = mysqli_query($conn, $str);

        if ($res) {
            //    $mes = "Registration sucess! Please sign in the left.";
            echo "<script> alert('Registration success! Please sign in') </script>";
        } else {
            //    $mes = mysqli_error($conn);
            echo "<script> alert('Failed:$mes'); </script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Library</title>
    <!-- CSS only -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./style/index.css">

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <!-- header start -->
        <div class="row mt-3 pt-3 header">
            <div class="text-center">
                <h1>WELCOME TO <i>PHP</i> LIBRARY</h1>
            </div>
        </div>
        <!-- header end -->

        <div class="row mt-3 pt-5 pb-5">
            <div class="col-2"></div>
            <div class="col-8 sign-wrap pt-5 pb-5">
                <div class="container ">
                    <div class="col-5 text-left ms-3 login">
                        <h2>Sign In</h2>
                        <h3 style="font-size: 20px; color: brown;"><?php echo $mes; ?></h3>
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                            <input type="text" Name="email" placeholder="Email" required>
                            <input type="text" Name="password" placeholder="Password" required>
                            <br>
                            <br>
                            <button class="btn btn-outline-success btn-submit" type="submit" name="signin">Sign In</button>
                           
                        </form>
                    </div>
                    <div class="col-5 text-left register">
                        <h2>Sign Up</h2>
                        <!-- <h3><?php echo $mes; ?></h3> -->
                        <form action="index.php" method="post">
                            <input type="text" Name="name" placeholder="* Name" required>
                            <p class="error" style="font-size: 20px; color: brown;"><?php echo $uNameErr; ?></p>

                            <input type="text" Name="email" placeholder="* Email" required>
                            <p class="error" style="font-size: 20px; color: brown;"><?php echo $uEmailErr; ?></p>

                            <input id="phone" type="text" Name="phone" pattern="1[0-9]{10}" placeholder="* Phone Number" required>
                            <p class="error" style="font-size: 20px; color: brown;"><?php echo $uPhoneErr; ?></p>

                            <input type="text" Name="password" placeholder="* Password" required>
                            <p class="error" style="font-size: 20px; color: brown;"><?php echo $uPasswordErr; ?></p>    

                            <input type="text" Name="password_confirmation" placeholder="* Repeat Password" required>
                            <p class="error" style="font-size: 20px; color: brown;"><?php echo $uPasswordcErr; ?></p>
                            <p id="eMessg" style="font-size: 20px; color: brown;"></p>
                            <br>
                            <br>
                            <button class="btn btn-outline-success btn-submit" type="submit" name="signup" onclick="prevalidation()">Sign Up</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-2"></div>
            <!-- footer start-->
            <div class="row text-center mt-5">
                <p><b class="copyright">&copy;Library Management System & Group PHP </b> All rights reserved.</p>
            </div>
            <!-- footer end -->
        </div>
    </div>

    <script>
        function prevalidation() {
        console.log("1");
        const EMES = document.getElementById("eMessg");
        const EMA = document.getElementById("phone");
        if (!EMA.checkValidity()) {
            EMES.innerHTML = EMA.validationMessage;
        }
    }
    </script>
</body>

</html>