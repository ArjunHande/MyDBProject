

<div>

    <?php
    if (loggedin()) { ?>
        <a href='index.php'> Home </a> |
        <a href='messages.php'> Messages </a> |
        <a href='logout.php'> Logout </a> |
        <a href='friends.php'> Friends </a>
        <?php } else { ?>
    <a href='index.php'> Home </a> |
    <a href='login.php'> Login </a> |
    <a href='register.php'> Register </a> |
        <?php  } ?>
</div>