<?php
session_start();

include '../DataBase.php';

$user_id =
    $first_name =
    $last_name =
    $user_name =
    $email =
    $password =
    $pass = 
    $city =
    $birthday =
    $gender =
    $pro_url = "";

$conn = mysqli_connect("localhost", "root", "" , "cs74");
if (!$conn)
    die("Connection failed: " . mysqli_connect_error());

if ($_POST){
    $email = $_POST["email"] ;
    $password = $_POST["pass"] ;
    $_SESSION["email"] = $email ;

    if ($_POST["form"] === "signup") {
        $first_name = $_POST["fname"] ;
        $last_name = $_POST["lname"] ;
        $user_name = $_POST["uname"] ;
        $city = $_POST["city"] ;
        $birthday = $_POST["dob"] ;
        $gender = $_POST["gender"] ;

        if ($user_name === "")
            $user_name .= $first_name .' '. $last_name ;

        if ($gender === "male")
            $pro_url = "../image/male.png" ;
        else
            $pro_url = "../image/female.png" ;

        $sql = "insert into profile (fname,lname,uname,pass,email,gender,birth,pic,city)
	        values ('$first_name','$last_name','$user_name',AES_ENCRYPT('$password','Ahmed'),'$email','$gender','$birthday','$pro_url','$city')" ;
        if (!mysqli_query($conn,$sql))
            echo "Error inserting new profile: " . mysqli_error($conn) ;
        header("Location: Home.php");
    }
    else {
        $sql = "select AES_DECRYPT(pass,'Ahmed') As 'pass' from profile where email = '".$email."'" ;
        $result = mysqli_query($conn,$sql) ;
        if (mysqli_num_rows($result) > 0)
            $pass = mysqli_fetch_assoc($result)["pass"] ;

        if ($pass == $password)
            header("Location: Home.php");
        else
            echo '<div class="alert alert-danger" role="alert"> Your Email/Password Doesn\'t match any user !</div>' ;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title> CS 74 </title>
        <link href="../css/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="../css/style.css" type="text/css" rel="stylesheet">
    </head>
    <body>
        <div class="forms">
            <h1 class="display-4 text-center text-white"><strong> Welcome to CS 74</strong></h1>
            <nav class="nav nav-pills nav-justified">
                <a class="nav-link nav-item" href="#signin">Log In</a>
                <a class="nav-link nav-item" href="#signup">Sign Up</a>
            </nav>
            <form action="Sign.php" id="signin" method="post">
                <input type="hidden" name="form" value="signin">
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email Address" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label for="pass">Password</label>
                        <input type="password" class="form-control" id="pass" name="pass" placeholder="Password" aria-describedby="passHelp" required>
                    </div>
                </div>
                <button class="btn btn-primary" type="submit">Sign In</button>
            </form>
            <form action="Sign.php" id="signup" method="post">
                <input type="hidden" name="form" value="signup">
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label for="fname">First name</label>
                        <input type="text" class="form-control" id="fname" name="fname" placeholder="First name" required>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="lname">Last name</label>
                        <input type="text" class="form-control" id="lname" name="lname" placeholder="Last name" required>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="validationDefaultUsername">Username</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="uname">@</span>
                            </div>
                            <input type="text" class="form-control" id="uname" name="uname" placeholder="Username" aria-describedby="inputGroupPrepend2">
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email Address" required>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="pass">Password</label>
                        <input type="password" class="form-control" id="pass" name="pass" placeholder="Password" aria-describedby="passHelp" required>
                        <small id="passHelp" class="form-text text-muted">make your password a combination of numbers,letters,symbols</small>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label for="city">City</label>
                        <input type="text" class="form-control" id="city" name="city" placeholder="City or Home Town">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="dob">Birth Day</label>
                        <input type="date" class="form-control" id="dob" name="dob" required>
                    </div>
                </div>
                <div class="form-row">
                    <label >Gender</label><br>
                </div>
                <div class="form-row">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" value="male" id="male" name="gender" class="custom-control-input">
                        <label class="custom-control-label" for="male">Male</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" value="female" id="female" name="gender" class="custom-control-input">
                        <label class="custom-control-label" for="female">Female</label>
                    </div>
                </div>
                <br>
                <button class="btn btn-primary" type="submit">Sign Up</button>
            </form>
        </div>
        <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
        <script type="text/javascript">
            $('#signup').hide() ;
            $(document).ready(function(){
                $('nav a').on('click', function (e) {
                    e.preventDefault();

                    $(this).parent().addClass('active');
                    $(this).parent().siblings().removeClass('active');

                    var href = $(this).attr('href');
                    $('.forms > form').hide();
                    $(href).fadeIn(500);
                });
            });
        </script>
    </body>
</html>