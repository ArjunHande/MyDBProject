<?php ob_start(); ?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
    </head>
    <body>
        <?php
        include 'connect.php';
        include 'functions.php';
        include 'header.php';
        ?>
        <div>
            <h3>Login</h3>
            <form method = 'post'>
                <?php
                        
                if(isset($_POST['login'])){
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    if(empty($username) or empty($password)){
                        $message = "Feilds empty";
                    }
                    else{
                        $checklogin = mysql_query("select * from User_Signup where email = '$username' and password = '$password'");
                        
                        if (mysql_num_rows($checklogin) == 1) {
				$run_login = mysql_fetch_array($checklogin);
                                $user_id =  $run_login['user_id'];
                                $email = $run_login['email'];
                                $_SESSION['user_id'] = $user_id;
                                $_SESSION['email'] = $email;
                                echo $_SESSION['user_id'];
                                header('location: index.php');
                                
			}else{
                            $message = "Username or password incorrect";
                        }
                        
                        echo "<p>$message</p>";
                    }
                }
                ?>
                Username : <br/>
                <input type="text" name='username' />
                <br/>
                <br/>
                Password <br/>
                <input type="password" name='password' />
                <br/>
                <br/>
                <input type="submit" name='login' value="Log In" />
            </form>
        </div>
    </body>