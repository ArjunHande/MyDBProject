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
        <?php include 'friends_title_bar.php'; ?>
        <br/>
        <br/>
        <b>Click to Send Request</b>
        <div>
            <?php
            if (isset($_GET['user']) && !empty($_GET['user'])) {
                $my_id = $_SESSION['user_id'];
                $user = $_GET['user'];
                $check_con = mysql_query("select * from Friendship where ((user1 = '$my_id' and user2 = '$user') OR (user1 = '$user' and user2 = '$my_id' )) and status = 'accepted' ");
                if (mysql_num_rows($check_con) == 1) {
                    echo "<p> Already a friend </p>";
                } else {
                    $check_con1 = mysql_query("select * from Friendship where ((user1 = '$my_id' and user2 = '$user') OR (user1 = '$user' and user2 = '$my_id' )) and status = 'pending' ");
                    if (mysql_num_rows($check_con1) == 1) {
                        echo "<p> Friend Request Already Sent </p>";
                    } else {

                        mysql_query("Insert into Friendship values('$my_id','$user','pending' )");

                        echo "<p>Friend Request Sent </p>";
                    }
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
                echo "<a href='sendRequest.php?user=$user_id'>$username</a></p>";
            }
            }
            ?>
        </div>
    </body>
</html>
