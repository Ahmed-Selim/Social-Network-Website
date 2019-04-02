<?php
session_start();
//echo $_GET["id"] . '<br>' . $_GET["friend"] ;
$conn = mysqli_connect("localhost", "root", "" , "cs74");
if (!$conn)
    die("Connection failed: " . mysqli_connect_error());

$sql = 'select * from profile where id = ' . $_GET["id"] ;
$result = mysqli_query($conn,$sql) ;
$row = mysqli_fetch_assoc($result) ;
$user_name = $row["uname"] ;
$pro_url = $row["pic"] ;
$about_me = $row["about"] ;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title> CS 74 </title>

        <link href="../css/bootstrap.css" rel="stylesheet" type="text/css"><link href="../css/Home.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <nav class="navbar nav-pills sticky-top navbar-light bg-light nav-fill">
            <a href="Home.php" class="nav-item nav-link btn">DashBoard</a>
            <a href="Friends.php" class="nav-item nav-link btn">Friends</a>
            <a href="FriReq.php" class="nav-item nav-link btn">Friend Requests</a>
            <a href="Account.php" class="nav-item nav-link btn">Account</a>
            <a href="" class="nav-item nav-link btn" data-toggle="modal" data-target="#exampleModal">Sign Out</a>
            <form class="form-inline my-2 my-lg-0" action="Search.php" target="_self" method="post">
                <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
            </form>
        </nav>
        <div class="left side-bar" >
            <div class="card user text-center border-secondary bg-secondary mb-3">
                <img class="card-img-top pro img-thumbnail" src="<?php echo $pro_url ; ?>">
                <div class="card-body text-secondary">
                    <h4 class="card-title text-white"><?php echo $user_name ;?></h4>
                    <p class="card-text text-white"><?php if ($_GET["friend"] == "T") echo "Friend" ; elseif ($_GET["friend"] == "F") echo "Pending Approval"; else echo "User" ; ?></p>
                    <ul class="list-group list-group-flush  bg-secondary">
                        <li class="list-group-item list-group-item-secondary">
                            <p class="card-text">First Name : <?php echo $row["fname"] ; ?></p>
                        </li>
                        <li class="list-group-item list-group-item-secondary">
                            <p class="card-text">Last Name : <?php echo $row["lname"] ; ?></p>
                        </li>
                        <li class="list-group-item list-group-item-secondary">
                            <p class="card-text">User Name : <?php echo $row["uname"] ; ?></p>
                        </li>
                        <li class="list-group-item list-group-item-secondary">
                            <p class="card-text">Email : <?php echo $row["email"] ; ?></p>
                        </li>
                        <li class="list-group-item list-group-item-secondary">
                            <p class="card-text">Gender : <?php echo $row["gender"] ; ?></p>
                        </li>
                        <li class="list-group-item list-group-item-secondary">
                            <p class="card-text">city : <?php echo $row["city"] ; ?></p>
                        </li>
                        <li class="list-group-item list-group-item-secondary">
                            <p class="card-text">Marital Status : <?php echo $row["status"] ; ?></p>
                        </li>
                        <?php
                        $sql = "select phone from call_me where id = ".$_GET["id"] ;
                        $result = mysqli_query($conn,$sql) ;
                        if (mysqli_num_rows($result) > 0) {
                            while($phone = mysqli_fetch_assoc($result)) {
                                echo '
                                <li class="list-group-item list-group-item-secondary">
                            <p class="card-text">'.$phone["phone"].'</p>
                        </li>' ;
                            }
                        }

                        if ($_GET["friend"] == "T") echo '
                        <li class="list-group-item list-group-item-secondary">
                            <p class="card-text">Birth Day : '.$row["birth"].'</p>
                        </li>
                        <li class="list-group-item list-group-item-secondary">
                            <p class="card-text"> About : '.$row["about"].'</p>
                        </li> ' ;
                        ?>
                    </ul>
                </div>
            </div>

        </div>
        <div class="timeline">

            <div class="list-group">
                <?php
                if ($_GET["friend"] == "T")
                    $sql = 'select caption,image_url,post_time,post.is_public from post where id = '. $_GET["id"] . ' ORDER BY post_time DESC' ;
                else
                    $sql = 'select caption,image_url,post_time,post.is_public from post where is_public = "public" and id = '. $_GET["id"] . ' ORDER BY post_time DESC' ;
                $result = mysqli_query($conn,$sql) ;
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo '<a class="list-group-item list-group-item-action">
                    <div class="media">
                        <img class="align-self-start mr-3" src="'.$pro_url.'" alt="Generic placeholder" style="height:64px;width:64px;border-radius:100%;">
                        <div class="media-body">
                            <div class="d-flex flex-row w-100 justify-content-between">
                                <h5 class="mt-0">'.$user_name.'</h5>
                                <small class="text-muted">'.$row["post_time"].'</small>
                            </div>
                            <p>'.$row["caption"].'</p>' ;
                        if ($row["image_url"] !== "../image/")
                            echo '<img src="'.$row["image_url"].'" >' ;
                        echo '
                        </div>
                    </div> 
                </a>';
                    }
                }
                ?>
            </div>

        </div>
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
