<?php
session_start();
$conn = mysqli_connect("localhost", "root", "" , "cs74");
if (!$conn)
    die("Connection failed: " . mysqli_connect_error());

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title> CS 74 | Home - Friends Requests </title>

        <link href="../css/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="../css/Friends.css" rel="stylesheet" type="text/css">
    </head>

    <body>
        <nav class="navbar nav-pills sticky-top navbar-light bg-light nav-fill">
            <a href="Home.php" class="nav-item nav-link btn">DashBoard</a>
            <a href="Friends.php" class="nav-item nav-link btn">Friends</a>
            <a href="FriReq.php" class="nav-item nav-link btn active">Friend Requests</a>
            <a href="Account.php" class="nav-item nav-link btn">Account</a>
            <a href="" class="nav-item nav-link btn" data-toggle="modal" data-target="#exampleModal">Sign Out</a>
            <form class="form-inline my-2 my-lg-0" action="Search.php" target="_self" method="post">
                <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
            </form>
        </nav>

        <h2 class="display-2 text-center text-white"><strong> Friend Requests <span class="badge badge-primary">
            <?php
            $sql = 'select count(*) as \'num\' from request where request = ' . $_SESSION["id"] ;
            $result = mysqli_query($conn,$sql) ;
            echo mysqli_fetch_assoc($result)["num"] ;
            ?>
            </span></strong></h2>

        <div id="main">
            <div class="list-group">
                <?php
                $sql = "select id,uname,pic,about from profile where id in (select request.id from request where request = " . $_SESSION["id"] . ")";
                $result = mysqli_query($conn,$sql) ;
                if (mysqli_num_rows($result)) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo '<a class="list-group-item list-group-item-action" href="Myfriend.php?id='.$row['id'].'&friend=F">
	<div class="media">
		<img class="align-self-start mr-3" src="'.$row['pic'].'" alt="Generic placeholder" style="height:64px;width:64px;border-radius:100%;">
		<div class="media-body">
			<h4>'.$row['uname'].'</h4>
			<p>'.$row['about']. '</p>
		</div>
		<div class="media">
			<form action="temp.php" target="_self" method="post" class="mt-0">
				<input type="hidden" name="hide" value="accept">
				<input type="hidden" name="id" value="'.$row["id"].'">
				<button type="submit" class="btn btn-primary btn-lg">Accept</button>
			</form>
			<form action="temp.php" target="_self" method="post" >
				<input type="hidden" name="hide" value="reject">
				<input type="hidden" name="id" value="'.$row["id"].'">
				<button type="submit" class="btn btn-secondary btn-lg" style="margin-left:10%;margin-right:5%;">Reject</button>
			</form>
		</div>
	</div> 
</a>' ;
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