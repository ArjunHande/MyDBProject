<?php
session_start();
ob_start();
$AddLine1Err = $AddLine2Err = $EmailErr = $CityErr =$StateErr= $PassErr1 = $PassErr2 =$ZipErr= "";
$AddLine1 =$_GET['add1'];
$AddLine2 =$_GET['add2'];
$Email =$_GET['email'];
$City =$_GET['city'];
$State=$_GET['state'];
$Pass1 = $Pass2 ="";
$Zip= $_GET['cat'];
$flag = "";
$error = "";
$hood_name="";
$Block_Name="";
$cat="";
//date_default_timezone_set();
$date = date('Y-m-d H:i:s');
//error_reporting(E_ALL);
//ini_set('display_errors', TRUE);
//require('header.php');
require("connect.php");
//require("header.php");
if(!$_GET['cat']==""){
$cat=$_GET['cat'];
}
$quer="SELECT hood_id,hood_name FROM Hoods where hood_zip=$Zip";
$hood_id = mysql_query($quer);
$prodrow = mysql_fetch_assoc($hood_id);
$hood=$prodrow['hood_id'];
$hood_name=$prodrow['hood_name'];

$quer1="SELECT block_id,block_name FROM Blocks where hood_id=$hood";
$block = mysql_query($quer1);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $flag = 0;
    $hood_name=$_POST["hood"];
    $Block_Name=$_POST["block"];
    
    if (empty($_POST["AddLine1"])) {
        $AddLine1Err = "Address is required";
        $flag = 1;
    } else {
        $AddLine1 = test_input($_POST["AddLine1"]);
    }


    $AddLine2 = test_input($_POST["AddLine2"]);
    
    if (empty($_POST["state"])) {
        $StateErr = "State is required";
        $flag = 1;
    } else {
        $State = test_input($_POST["state"]);
                if (!preg_match("/^[a-zA-Z ]*$/", $State)) {
            $StateErr = "Only letters and white space allowed";
            $flag = 1;
        }
    }
    
    if (empty($_POST["city"])) {
        $CityErr = "City is required";
        $flag = 1;
    } else {
        $City = test_input($_POST["city"]);
                if (!preg_match("/^[a-zA-Z ]*$/", $City)) {
            $CityErr = "Only letters and white space allowed";
            $flag = 1;
        }
    }

    if (empty($_POST["email"])) {
        $EmailErr = "Email is required";
        $flag = 1;
    } else {
        $Email = test_input($_POST["email"]);
        // check if e-mail address is well-formed
        if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
            $EmailErr = "Invalid email format";
            $flag = 1;
        }
    }
    
    if (empty($_POST["zip"])) {
        $ZipErr = "Zip is required";
        $flag = 1;
    } else {
        $Zip = test_input($_POST["zip"]);
        // check if e-mail address is well-formed
        if (!is_numeric($Zip)) {
            $ZipErr = "Only numbers allowed";
            $flag = 1;
        }
    }



    if (empty($_POST["pass1"])) {
        $PassErr1 = "Password required";
        $flag = 1;
        //header("Location: " . $basedir . "register.php");
    } elseif (empty($_POST["pass2"])) {
        $PassErr2 = "Please re-type the password";
        $flag = 1;
        //header("Location: " . $basedir . "register.php");
    }

    if (!empty($_POST["pass1"]) && ($_POST["pass1"] == $_POST["pass2"])) {
        $Pass1 = test_input($_POST["pass1"]);
        $Pass2 = test_input($_POST["pass2"]);
        if (strlen($_POST["pass1"]) <= '8') {
            $PassErr1 = "Your Password Must Contain At Least 8 Characters!";
            $flag = 1;
        } elseif (!preg_match("#[0-9]+#", $Pass1)) {
            $PassErr1 = "Your Password Must Contain At Least 1 Number!";
            $flag = 1;
        } elseif (!preg_match("#[A-Z]+#", $Pass1)) {
            $PassErr1 = "Your Password Must Contain At Least 1 Capital Letter!";
            $flag = 1;
        } elseif (!preg_match("#[a-z]+#", $Pass1)) {
            $PassErr1 = "Your Password Must Contain At Least 1 Lowercase Letter!";
            $flag = 1;
        }
    } elseif (!empty($_POST["pass1"])) {
        $PassErr2 = "Please Check You've Entered Or Confirmed Your Password!";
        $flag = 1;
    }

    $sqlchk = mysql_query("SELECT * FROM User_Signup");
    while ($custrow = mysql_fetch_assoc($sqlchk)) {
        if ($custrow['email'] == $Email) {
            $error = "You are already registered, please login";
            $flag = 1;
        }
    }


    if ($flag == 0) {
        $addcust = "INSERT INTO User_Signup(email, password, last_login, add_line1, add_line2,add_city,add_state,add_zip)VALUES('" . $Email . "', '" . $Pass1 . "', '" . $date . "', '" . $AddLine1 . "', '" .$AddLine2. "', '" .$City. "', '" .$State. "', " .$Zip.")";
        mysql_query($addcust);
        $custid = mysql_insert_id();
         $sqlchk = mysql_query("SELECT * FROM User_Signup where email='".$Email."'");
         $custrow = mysql_fetch_assoc($sqlchk);
         $sqlchk2 = mysql_query("SELECT * FROM Hoods where hood_zip=".$Zip);
         $custrow2 = mysql_fetch_assoc($sqlchk2);
        $addlogin = "INSERT INTO Hood_Members(hood_id, user_id, startdate)VALUES(" . $custrow2['hood_id'] . ", " . $custrow['user_id'] . ", '" . $date . "')";
        mysql_query($addlogin);
        $sqlchk1 = mysql_query("SELECT * FROM Blocks where block_name='".$Block_Name."'");
         $custrow1 = mysql_fetch_assoc($sqlchk1);
         
        $addlogin1 = "INSERT INTO Block_Members(block_id, user_id, startdate)VALUES(" . $custrow1['block_id'] . ", " . $custrow['user_id'] . ", '" . $date . "')";
        mysql_query($addlogin1);

        header("Location:" . $config_basedir . "index.php");
    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


?>
<SCRIPT language=JavaScript>
function reload(form)
{
var val=document.forms["myform"]["zip"].value ;
var Email=document.forms["myform"]["email"].value ;
var AddLine1=document.forms["myform"]["AddLine1"].value ;
var AddLine2=document.forms["myform"]["AddLine2"].value ;
var State=document.forms["myform"]["state"].value ;
var City=document.forms["myform"]["city"].value ;
self.location='register.php?cat=' + val+'&add1='+AddLine1+'&add2='+AddLine2+'&state='+State+'&city='+City+'&email='+Email;
}
</script>

<h2>PHP Form Validation Example</h2><br>
<form name="myform" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"> 
    <table>
        <tr>
            <td>E-mail: </td>
            <td><input type="text" name="email" value="<?php echo $Email; ?>"></td>
            <td><span class="error">* <?php echo $EmailErr; ?></span></td>
        </tr>
        <tr>
            <td>Address Line 1: </td>
            <td><input type="text" name="AddLine1" value="<?php echo $AddLine1; ?>"></td>
            <td><span class="error">* <?php echo $AddLine1Err; ?></span></td>
        </tr>
        <tr>
            <td>Address Line 2: </td>
            <td><input type="text" name="AddLine2" value="<?php echo $AddLine2; ?>"></td>
        </tr>  
        <tr>
            <td>State: </td>
            <td><input type="text" name="state" value="<?php echo $State; ?>"></td>
            <td><span class="error">* <?php echo $StateErr; ?></span></td>
        </tr>
        <tr>
            <td>City: </td>
            <td><input type="text" name="city" value="<?php echo $City; ?>"></td>
            <td><span class="error">* <?php echo $CityErr; ?></span></td>
        </tr>
        <tr>
            <td>Zip</td>
            <td><input type="text" name="zip" onchange="reload(this.form)" value="<?php echo $Zip; ?>"></td>
            <td><span class="error">* <?php echo $ZipErr; ?></span></td>
        </tr>
        <tr>
            <td>Hood</td>
            <td><input type="text" name="hood" value="<?php echo $hood_name; ?>"></td>
        </tr>
        <tr>
            <td>Block</td>
            <?php

            if(!$Block_Name==""){
                echo "<td><select name='block'>";
                echo "<option>" . $Block_Name . "</option>";
                echo "</select></td>";
            }else{
                echo "<td><select name='block' selected='selected' >";
                while ($prodrow = mysql_fetch_assoc($block)){
                    echo "<option>" . $prodrow['block_name'] . "</option>";
                }
            echo "</select></td>";}?>
        </tr>
        <tr>
            <td>Password:</td>
            <td><input type="password" name="pass1" /></td>
            <td><span class="error">* <?php echo $PassErr1; ?></span></td>
        </tr>
        <tr>
            <td>Confirm Password:</td>
            <td><input type="password" name="pass2"></td>
            <td><span class="error">* <?php echo $PassErr2; ?></span></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" name="submit" value="Submit"></td>
        </tr>
    </table>
</form>
<?php
echo '<h2>' . $error . '</h2><br><br><br>';
//require('footer.php');
?>




