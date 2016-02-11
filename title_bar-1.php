

<div>

    <?php
    if (loggedin()) { ?>
        <a href='index.php'> Home </a> |
        <a href='messages.php'> Messages </a> |
        <a href='friends.php'> Friends </a> |
        <a href='neighbor.php'> Neighbors </a> |
        <a href='logout.php'> Logout </a> |

        <?php } else { ?>
    <a href='index.php'> Home </a> |
    <a href='login.php'> Login </a> |
    <a href='register.php'> Register </a> |

    
        <?php  } ?>
</div>