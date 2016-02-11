<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Simple Sidebar - Start Bootstrap Template</title>

        <!-- Bootstrap Core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="css/simple-sidebar.css" rel="stylesheet">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>

    <body>

        <div id="wrapper">

            <!-- Sidebar -->
            <div id="sidebar-wrapper">
                <ul class="sidebar-nav">
                    <?php
                    if (loggedin()) {
                        $username = $_SESSION['email'];
                        ?>
                        <li class="sidebar-brand">
                            <a href="#">
                                <?php echo $username; ?>
                            </a>
                        </li>
                        <li>
                            <a href='index.php'> Home </a>
                        </li>
                        <li>
                            <a href='messages.php'> Messages </a>
                        </li>
                        <li>
                            <a href='friends.php'> Friends </a>
                        </li>
                        <li>
                            <a href='neighbor.php'> Neighbors </a>
                        </li>
                        <li>
                            <a href='viewBlockRequest.php'> View Block Requests </a>
                        </li>
                        <li>
                            <a href='logout.php'> Logout </a>
                        </li>
                        

                    <?php } else { ?>
                        <li class="sidebar-brand">
                            <a href="#">
                                Welcome
                            </a>
                        </li>
                        <li>
                            <a href='index.php'> Home </a>
                        </li>
                        <li>
                            <a href='login.php'> Login </a>
                        </li>
                        <li>
                            <a href='register.php'> Register </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <!-- /#sidebar-wrapper -->

            <!-- Page Content -->
            <div id="page-content-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">