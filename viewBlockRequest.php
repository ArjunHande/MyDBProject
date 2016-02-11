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
        <br/>
        <br/>
        <b>Click to Approve Block Joining Request</b>
        <div>
            <?php
            if (isset($_GET['user']) && !empty($_GET['user'])) {
                $my_id = $_SESSION['user_id'];
                $user = $_GET['user'];
                $check_con = mysql_query("select * from block_approval where status = 'pending' AND approving_user_id = '$my_id' and applying_user_id = '$user'");
                if (mysql_num_rows($check_con) == 0 ) {
                    echo "<p> Some Error </p>";
                } else {
                    //$check_con1 = mysql_query("select * from block_approval where status = 'pending' AND approving_user_id = '$my_id' and applying_user_id = '$user'");
                    if (mysql_num_rows($check_con) == 1) {
                        $block_id = $check_con['block_id'];
                        mysql_query("update block_approval set status = 'approved' where approving_user_id = '$my_id' and applying_user_id ='$user'");
                        mysql_query("commit");
                        $exec = "CALL block_membership('$user','$block_id');";
                        $a = mysql_query($exec);
                        echo "<p> Request Approved </p>";
                    }
                }
            }
            else{
            ?>
            <?php
            $my_id = $_SESSION['user_id'];
            $users = mysql_query(" select user_id, email from user_signup u , block_approval  b where b.applying_user_id = u.user_id and b.status = 'pending' AND b.approving_user_id = '$my_id' ");
            while ($row = mysql_fetch_array($users)) {
                $user_id = $row['user_id'];
                $username = $row['email'];
                echo "<a href='viewBlockRequest.php?user=$user_id'>$username</a></p>";
            }
            }
            ?>
        </div>
    </body>
</html>
