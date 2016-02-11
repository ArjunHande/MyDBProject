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
        <b>Click to Accept Request</b>
        <div>
            <?php
            if (isset($_GET['user']) && !empty($_GET['user'])) {
                $my_id = $_SESSION['user_id'];
                $user = $_GET['user'];
                $check_con = mysql_query("select * from Friendship where  user1 = '$user' and user2 = '$my_id'  and status = 'pending' ");
                if (mysql_num_rows($check_con) == 1) {
                    mysql_query("update friendship set status = 'accepted' where user1 = '$user' and user2 = '$my_id' ");
                    echo "<p> Friend Request Accepted </p>";
                } else {
                    echo "Some Error";
                }
            } else {
                ?>
                <?php
                $my_id = $_SESSION['user_id'];
                $users = mysql_query("select user_id, email from user_signup u , friendship f where u.user_id = user1 and f.user2 ='$my_id' and f.status = 'pending' ");
                if (mysql_num_rows($users) == 0) {
                    echo "<p> No Pending Requests </p>";
                } else {
                while ($row = mysql_fetch_array($users)) {
                    $user_id = $row['user_id'];
                    $username = $row['email'];
                    echo "<a href='viewRequests.php?user=$user_id'>$username</a></p>";
                }
            }
            }
            ?>
        </div>
    </body>
</html>
