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
            if(isset($_GET['hash']) && !empty($_GET['hash'])){
                $hash = $_GET['hash'];
                $message_query = mysql_query("select from_id, message from msg_hood where group_hash = '$hash'" );
                while($run_message = mysql_fetch_array($message_query)){
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
                if(isset($_POST['message']) && !empty($_POST['message'])){
                    $new_message = $_POST['message'];   
                     mysql_query("Insert into msg_hood values('','$hash','$my_id','$new_message' )");
                     header('location: conversations.php?hash='.$hash);
                }
                ?>
                Enter Message: <br/>
                <textarea name = 'message' rows='6' cols='50' >
                    
                </textarea>
                <br/><br/>
                <input type='submit' value="Send Message" />
            </form>
            
            <?php    
            }
            else{
                echo "<b> Select Conversations: </b>";
                $get_con = mysql_query("Select hash, user1 , user2 from msg_hood_group WHERE user1 = '$my_id' OR user2 = '$my_id'");
                while( $run_con = mysql_fetch_array($get_con)){
                    $hash = $run_con['hash'];
                    $user1 = $run_con['user1'];
                    $user2 = $run_con['user2'];
                    
                    if($user1 == $my_id){
                        $select_id = $user1;
                    }
                    else{
                        $select_id = $user1;
                    }
                    $user_get = mysql_query("Select email from user_signup where user_id = '$select_id' ");
                    $run_user= mysql_fetch_array($user_get);
                    $selectusername = $run_user['email'];
                    
                    echo "<a href='conversations.php?hash=$hash'>$selectusername</a></p>"; 
                }
            }
            ?>
        </div>
    </body>
</html>
