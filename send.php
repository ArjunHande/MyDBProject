<html>
    <head>
        <meta charset="UTF-8">
        <title>New Message </title>
    </head>
    <body>
        <?php
        include 'connect.php';
        include 'functions.php';
        include 'header.php';
        ?>
        <h3>Messaging System</h3>
        <?php include 'message_title_bar.php'; ?>
        <br/>
        <div>
            <?php
            if(isset($_GET['user']) && !empty($_GET['user'])){
             ?>
            <form method = 'post'>
                <?php
                if(isset($_POST['message']) && !empty($_POST['message'])){
                    $my_id = $_SESSION['user_id'];
                    $user = $_GET['user'];
                    $random = rand();
                    $message = $_POST['message'];
                    $check_con = mysql_query("select hash from msg_group where (user1 = '$my_id' AND user2 = '$user') OR (user1= '$user' AND user2 = '$my_id') ");
                    if (mysql_num_rows($check_con) == 1){
                        echo "<p>Conversation has already Started</p>";
                    }
                    else{
                        mysql_query("Insert into msg_group values('$my_id','$user','$random' )");
                        mysql_query("Insert into msg values('','$random','$my_id', '$message' )");
                        echo "<p>Conversation Started </p>";
                    }
                }
                ?>
                Enter Message : <br/>
                <textarea name = message rows = '7' cols = '60'></textarea>
                <br/>
                <br/>
                <input type= 'submit' value = "Send Message" />
            </form>
            <?php
            }
            else{
                $user_list = mysql_query('select user_id, email from User_Signup');
                while($a = mysql_fetch_array($user_list)){
                    $user_id = $a['user_id'];
                    $username = $a['email'];
                    
                    echo "<a href='send.php?user=$user_id'>$username</a></p>"; 
                }
            }
            ?>
        </div>
    </body>
</html>
