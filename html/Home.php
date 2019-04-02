<?php
session_start();
$conn = mysqli_connect("localhost", "root", "" , "cs74");
if (!$conn)
    die("Connection failed: " . mysqli_connect_error());

$sql = 'select * from profile where email = \'' . $_SESSION["email"] . '\'';
$result = mysqli_query($conn,$sql) ;
$row = mysqli_fetch_assoc($result) ;
$user_name = $row["uname"] ;
$pro_url = $row["pic"] ;
$about_me = $row["about"] ;
$_SESSION["id"] = $row["id"] ;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title> CS 74 | Home - DashBoard</title>
        <link href="../css/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="../css/Home.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <nav class="navbar nav-pills sticky-top navbar-light bg-light nav-fill">
            <a href="Home.php" class="nav-item nav-link btn active">DashBoard</a>
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
            <div class="card user text-center border-secondary text-white bg-secondary mb-3">
                <img class="card-img-top pro img-thumbnail" src="<?php echo $pro_url ; ?>">
                <div class="card-body">
                    <h4 class="card-title"><?php echo $user_name ;?></h4>
                    <p class="card-text"><?php echo $about_me ; ?></p>
                </div>
                <div class="card-footer text-center">
                    <a class="btn btn-default text-white btn-lg active" href="Friends.php">Friends <span class="badge badge-primary">
                        <?php
                        $sql = 'select count(*) as \'num\' from friendship where id = ' . $_SESSION["id"] ;
                        $result = mysqli_query($conn,$sql) ;
                        echo mysqli_fetch_assoc($result)["num"] ;
                        ?>
                        </span></a>
                </div>
                <div class="card-footer text-center">
                    <a class="btn btn-default text-white btn-lg active" href="FriReq.php">Friend Requests <span class="badge badge-primary">
                        <?php
                        $sql = 'select count(*) as \'num\' from request where request = ' . $_SESSION["id"] ;
                        $result = mysqli_query($conn,$sql) ;
                        echo mysqli_fetch_assoc($result)["num"] ;
                        ?>
                        </span></a>
                </div>
            </div>
            <div class="card mb-3" >
                <h5 class="card-title text-center">Write Post</h5>
                <form action="Post.php" target="_self" method="post">
                    <div class="form-group">
                        <textarea class="form-control" name="caption" placeholder="Write something..." rows="5" required></textarea>
                    </div>
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">image</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="img" id="inputGroupFile01" accept="image/gif, image/jpeg, image/png">
                                <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="public" name="type" value="public" class="custom-control-input form-control" checked>
                            <label class="custom-control-label" for="public">Public Post</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="private" value="private" name="type" class="custom-control-input form-control">
                            <label class="custom-control-label" for="private">Private Post</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="poster" class="btn btn-outline-primary btn-lg btn-block">Post</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="timeline">

            <div class="list-group">
                <?php
                $sql = 'select profile.uname,profile.pic,x.caption,x.image_url,x.post_time from 
(SELECT * FROM post where is_public="public" 
UNION select * from post where id = '. $_SESSION["id"].
                    ' UNION SELECT * FROM post WHERE id in 
(SELECT p2.id from friendship join profile as p1 on p1.id = friendship.id and friendship.id = '. $_SESSION["id"].
                    ' join profile as p2 on p2.id = friendship.friend)
) as x
join profile on profile.id = x.id ORDER BY x.post_time DESC' ;
                $result = mysqli_query($conn,$sql) ;
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo '<a class="list-group-item list-group-item-action">
                    <div class="media">
                        <img class="align-self-start mr-3" src="'.$row["pic"].'" alt="Generic placeholder" style="height:64px;width:64px;border-radius:100%;">
                        <div class="media-body">
                            <div class="d-flex flex-row w-100 justify-content-between">
                                <h5 class="mt-0">'.$row["uname"].'</h5>
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