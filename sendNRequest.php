<html>
    <head>
        <meta charset="UTF-8">
        <title>Friends</title>
    </head>
    <body>
        <?php
        include 'connect.php';
        include 'functions.php';
        include 'header.php';
        ?>
        <h3>People from your Neighborhood</h3>
        <?php include 'neighbor_title_bar.php'; ?>
        <br/>
        <br/>
        <b>Click to Add as a neighbor</b>
        <div>
            <?php
            if (isset($_GET['user']) && !empty($_GET['user'])) {
                $my_id = $_SESSION['user_id'];
                $user = $_GET['user'];
                $check_con = mysql_query("select * from Neighbour where ((user1 = '$my_id' and user2 = '$user') OR (user1 = '$user' and user2 = '$my_id' )) and status = 'yes' ");
                if (mysql_num_rows($check_con) == 1) {
                    echo "<p> Already a Neighbor </p>";
                } else {
                    

                        mysql_query("Insert into Neighbour values('$my_id','$user','yes' )");
                        echo "<p> Neighbor Added</p>";   
                }
            }
            else{
            ?>
            <?php
            $my_id = $_SESSION['user_id'];
            $users = mysql_query(" select user_id,email from User_Signup where user_id in (select a.user_id from Hood_Members a where hood_id = (select hood_id from Hood_Members where user_id = '$my_id') ) and user_id <> '$my_id' ");
            while ($row = mysql_fetch_array($users)) {
                $user_id = $row['user_id'];
                $username = $row['email'];
                echo "<a href='sendNRequest.php?user=$user_id'>$username</a></p>";
            }
            }
            ?>
        </div>
    </body>
</html>
