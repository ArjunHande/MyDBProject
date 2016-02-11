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
                    $conn = mysql_connect($host, $user, $pass)or die(mysql_error());
                    $my_id = $_SESSION['user_id'];
                    $user = $_GET['user'];
                    $random = rand();
                    $message = $_POST['message'];
                    $check_block = mysql_query("select block_id from Block_Members where (user_id = '$my_id' AND status = 'member')");
                    $result = $conn->query($check_block);
                    $row = $result->fetch_assoc();
                    if ($row != null) {
                        $block_id = $row['block_id'];
                    }
                    $check_con = mysql_query("select hash from msg_block_group where (user1 = '$my_id' AND block_id = '$block_id')");
                    if (mysql_num_rows($check_con) == 1){
                        echo "<p>Conversation has already Started</p>";
                    }
                    else{
                        mysql_query("Insert into msg_block_group values('$my_id','$block_id','$random' )");
                        mysql_query("Insert into msg_block values('','$random','$my_id', '$message' )");
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
                $my_id = $_SESSION['user_id'];
                $user_list = mysql_query("select BM.block_id block_id, B.block_name block_name from Block_Members BM join Blocks B on BM.block_id = B.block_id where (BM.user_id = '$my_id' AND BM.status = 'member')");
                while($a = mysql_fetch_array($user_list)){
                    $block_id = $a['block_id'];
                    $block_name = $a['block_name'];
                    
                    echo "<a href='Blocksend.php?user=$block_id'>$block_name</a></p>"; 
                }
            }
            ?>
        </div>
    </body>
</html>
