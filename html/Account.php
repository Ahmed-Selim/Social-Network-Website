<?php
session_start();
$conn = mysqli_connect("localhost", "root", "" , "cs74");
if (!$conn)
    die("Connection failed: " . mysqli_connect_error());

$sql = 'select fname,lname,uname,AES_DECRYPT(pass,\'Ahmed\') as pass,email,gender,birth,pic,city,status,about from profile where id = ' . $_SESSION["id"] ;
$result = mysqli_query($conn,$sql) ;
$row = mysqli_fetch_assoc($result) ;
$fname = $row["fname"] ;
$lname = $row["lname"] ;
$user_name = $row["uname"] ;
$pass = $row["pass"] ;
$email = $row["email"] ;
$gender = $row["gender"] ;
$birth = $row["birth"] ;
$pro_url = $row["pic"] ;
$city = $row["city"] ;
$status = $row["status"] ;
$about_me = $row["about"] ;

$sql = 'select count(*) as \'num\' from friendship where id = ' . $_SESSION["id"];
$result = mysqli_query($conn,$sql) ;
$friends = mysqli_fetch_assoc($result)["num"] ;

$sql = 'select count(*) as \'num\' from request where request = ' . $_SESSION["id"];
$result = mysqli_query($conn,$sql) ;
$fri_req = mysqli_fetch_assoc($result)["num"] ;

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title> CS 74 | Home - Account </title>

        <link href="../css/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="../css/profile.css" rel="stylesheet" type="text/css">
    </head>

    <body>
        <nav class="navbar nav-pills sticky-top navbar-light bg-light nav-fill">
            <a href="Home.php" class="nav-item nav-link btn">DashBoard</a>
            <a href="Friends.php" class="nav-item nav-link btn">Friends</a>
            <a href="FriReq.php" class="nav-item nav-link btn">Friend Requests</a>
            <a href="Account.php" class="nav-item nav-link btn active">Account</a>
            <a href="" class="nav-item nav-link btn" data-toggle="modal" data-target="#exampleModal">Sign Out</a>
            <form class="form-inline my-2 my-lg-0" action="Search.php" target="_self" method="post">
                <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
            </form>
        </nav>
        <form class="main" action="Save.php" target="_self" method="post">
            <div class="card user text-center border-secondary text-white bg-secondary mb-3">
                <img class="card-img-top pro img-thumbnail" src="<?php echo $pro_url ; ?>">
                <div class="card-body">
                    <h4 class="card-title"><?php echo $user_name ;?></h4>
                    <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                    <p class="card-text"><?php echo $about_me ; ?></p>
                    <a href="Friends.php" class="card-link btn btn-default text-white btn-lg"><strong> Friends <span class="badge badge-primary"><?php echo $friends ;?></span></strong></a>
                    <a href="FriReq.php" class="card-link btn btn-default text-white btn-lg"><strong> Friend Requests <span class="badge badge-primary"><?php echo $fri_req ;?></span></strong></a>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text border border-primary"><strong>First Name</strong></span>
                            </div>
                            <input type="text" readonly class="form-control" value="<?php echo $fname; ?>" aria-label="" aria-describedby="basic-addon1">
                            <input type="text" class="form-control" name="fname" value="<?php echo $fname; ?>" aria-label="" aria-describedby="basic-addon1">
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text border border-primary"><strong>Last Name</strong></span>
                            </div>
                            <input type="text" readonly class="form-control" value="<?php echo $lname; ?>" aria-label="" aria-describedby="basic-addon1">
                            <input type="text" class="form-control" name="lname" value="<?php echo $lname; ?>" aria-label="" aria-describedby="basic-addon1">
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text border border-primary"><strong>User Name</strong></span>
                            </div>
                            <input type="text" readonly class="form-control" value="<?php echo $user_name; ?>" aria-label="" aria-describedby="basic-addon1">
                            <input type="text" class="form-control" name="uname" value="<?php echo $user_name; ?>" aria-label="" aria-describedby="basic-addon1">
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text border border-primary"><strong>Password</strong></span>
                            </div>
                            <input type="text" readonly class="form-control" value="<?php echo $pass; ?>" aria-label="" aria-describedby="basic-addon1">
                            <input type="password" class="form-control" name="pass" value="<?php echo $pass; ?>" aria-label="" aria-describedby="basic-addon1">
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text border border-primary"><strong>Email</strong></span>
                            </div>
                            <input type="text" readonly class="form-control" value="<?php echo $email; ?>" aria-label="" aria-describedby="basic-addon1">
                            <input type="email" class="form-control" name="email" value="<?php echo $email; ?>" aria-label="" aria-describedby="basic-addon1">
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text border border-primary"><strong>Gender</strong></span>
                            </div>
                            <input type="text" readonly class="form-control" value="<?php echo $gender; ?>" aria-label="" aria-describedby="basic-addon1">
                            <select class="form-control custom-control custom-select" name="gender">
                                <option>male</option>
                                <option>female</option>
                            </select>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text border border-primary"><strong>Birth Day</strong></span>
                            </div>
                            <input type="text" readonly class="form-control" value="<?php echo $birth; ?>" aria-label="" aria-describedby="basic-addon1">
                            <input type="date" class="form-control custom-control" name="birth" value="<?php echo $birth; ?>" aria-label="" aria-describedby="basic-addon1">
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="input-group  custom-control-inline">
                            <div class="input-group-prepend">
                                <span class="input-group-text border border-primary"><strong>Profile Picture</strong></span>
                            </div>
                            <input type="text" readonly class="form-control" value="<?php echo $pro_url; ?>" aria-label="" aria-describedby="basic-addon1">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="pic" id="validatedCustomFile">
                                <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                            </div>
                        </div>
                        <div class="custom-control custom-checkbox custom-control-inline ">
                            <input type="checkbox" class="custom-control-input" id="remove" name="rmpic" value="T">
                            <label class="custom-control-label" for="remove" style="color:dodgerblue;"><strong>Remove</strong></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text border border-primary"><strong>City</strong></span>
                            </div>
                            <input type="text" readonly class="form-control" value="<?php echo $city; ?>" aria-label="" aria-describedby="basic-addon1">
                            <input type="text" class="form-control" name="city" value="<?php echo $city; ?>" aria-label="" aria-describedby="basic-addon1">
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text border border-primary"><strong>Marital Status</strong></span>
                            </div>
                            <input type="text" readonly class="form-control" value="<?php echo $status; ?>" aria-label="" aria-describedby="basic-addon1">
                            <select class="form-control" name="status" value="<?php echo $status; ?>" aria-label="" aria-describedby="basic-addon1">
                                <option value=""></option>
                                <option value="single">single</option>
                                <option value="engaged">engaged</option>
                                <option value="married">married</option>
                            </select>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text border border-primary"><strong>About Me</strong></span>
                            </div>
                            <textarea readonly class="form-control" aria-label="" aria-describedby="basic-addon1"><?php echo $about_me; ?></textarea>
                            <textarea class="form-control" name="about" aria-label="" aria-describedby="basic-addon1"><?php echo $about_me; ?></textarea>
                        </div>
                    </li>
                    <?php
                    $sql = "select phone from call_me where id = " .$_SESSION["id"] ;
                    $result = mysqli_query($conn,$sql) ;
                    $i = 1 ;
                    if (mysqli_num_rows($result) > 0) {
                        while($phone = mysqli_fetch_assoc($result)) {
                            echo '
                                <li class="list-group-item">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text border border-primary"><strong>Phone</strong></span>
                            </div>
                            <input readonly class="form-control" aria-label="" aria-describedby="basic-addon1" value="'.$phone["phone"].'">
                            <div class="custom-control custom-checkbox custom-control-inline ">
                                <input type="checkbox" class="custom-control-input" id="'.$i.'" name="'.$i.'" value="'.$phone["phone"].'">
                                <label class="custom-control-label" for="'.$i.'" style="color:dodgerblue;"><strong>Remove</strong></label>
                            </div>
                        </div>
                    </li>
                                ' ;
                            ++ $i ;
                        }
                    }
                    ?>
                    <li class="list-group-item">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text border border-primary"><strong>Add Phone</strong></span>
                            </div>
                            <input type="text" class="form-control" name="phono" aria-label="" aria-describedby="basic-addon1">
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="form-row">
                            <input type="hidden" name="loop" value="<?php echo $i-1 ; ?>">
                            <button class="btn btn-outline-primary btn-lg btn-block" type="submit" >Save</button>
                        </div>
                    </li>
                </ul>
            </div>
        </form>

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Confirm Sign Out</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to sign out ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="logout">Yes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
        <script src="../js/bootstrap.min.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).on("click", "#logout", function(event){
                window.location.replace("Sign.php");
            });
        </script>
    </body>
</html>