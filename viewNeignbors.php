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
        <b>Neighbor List</b>
        <br/>
        <br/>
        <div>
            <?php
            $my_id = $_SESSION['user_id'];
            $users = mysql_query("select user_id, email from User_Signup u , Neighbour f  where f.user1 = '$my_id' and f.user2 = u.user_id and f.status = 'yes' union select user_id, email from User_Signup u , Friendship f  where f.user2 = '$my_id' and f.user1 = u.user_id and f.status = 'yes' ");
            if (mysql_num_rows($users) == 0) {
                echo "<p> No Neighbors </p>";
            } else {
                while ($row = mysql_fetch_array($users)) {
                    $user_id = $row['user_id'];
                    $username = $row['email'];
                    echo "$username</p>";
                }
            }
            ?>
        </div>
    </body>
</html>