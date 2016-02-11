<html>
    <head>
        <meta charset="UTF-8">
        <title> Conversation</title>
    </head>
    <body>
        <?php
        include 'connect.php';
        include 'functions.php';
        include 'header.php';
        ?>
        <h3>Messaging System</h3>
        <?php include 'message_title_bar.php'; ?>
        <?php $my_id = $_SESSION['user_id'] ?>
        <br/>
        <br/>
        <b> Conversations: </b>
        <br/>
        <br/>
        <div>
            <?php
            if (isset($_GET['hash']) && !empty($_GET['hash'])) {
                $hash = $_GET['hash'];
                $message_query = mysql_query("select from_id, message from msg_block where group_hash = '$hash'");
                while ($run_message = mysql_fetch_array($message_query)) {
                    $from_id = $run_message['from_id'];
                    $message = $run_message['message'];

                    $user_query = mysql_query("select email from user_signup where user_id = '$from_id'");
                    $run_user = mysql_fetch_array($user_query);
                    $from_username = $run_user['email'];

                    echo "<p><b> $from_username</b><br/> $message</p>";
                }
                ?>
                <br/>
                <form method='post'>
                    <?php
                    if (isset($_POST['message']) && !empty($_POST['message'])) {
                        $new_message = $_POST['message'];
                        mysql_query("Insert into msg_block values('','$hash','$my_id','$new_message' )");
                        header('location: BlockConversations.php?hash=' . $hash);
                    }
                    ?>
                    Enter Message: <br/>
                    <textarea name = 'message' rows='6' cols='50' >
                        
                    </textarea>
                    <br/><br/>
                    <input type='submit' value="Send Message" />
                </form>

                <?php
            } else {
                echo "<b> Select Conversations: </b>";
                $my_id = $_SESSION['user_id'];
                $check_block = mysql_query("select block_id from Block_Members where (user_id = '$my_id' AND status = 'member')");
                while ($a = mysql_fetch_array($check_block)) {
                    $block_id = $a['block_id'];
                    $block_name = $a['block_name'];

//                            echo "<a href='Blocksend.php?user=$block_id'>$block_name</a></p>";
                }
                $get_con = mysql_query("Select hash, user1 , block_id,from_id,message from msg_block_group MB join msg_block M on M.group_hash = MB.hash WHERE user1 = '$my_id' AND block_id = '$block_id'");
                while ($run_con = mysql_fetch_array($get_con)) {
                    $hash = $run_con['hash'];
                    $user1 = $run_con['user1'];
                    $block_id = $run_con['block_id'];
                    $from_id = $run_con['from_id'];
                    $message = $run_con['message'];

                    if ($user1 == $my_id) {
                        $select_id = $user1;
                    } else {
                        $select_id = $user1;
                    }
                    $user_get = mysql_query("Select email from user_signup where user_id = '$select_id' ");
                    $run_user = mysql_fetch_array($user_get);
                    $selectusername = $run_user['email'];

                    echo "<a href='BlockConversations.php?hash=$hash'>$selectusername</a></p>";
                }
            }
            ?>
        </div>
    </body>
</html>
