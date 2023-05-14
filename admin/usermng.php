<?php
error_reporting(0);
session_start();
include_once '../onlineexaminationdb.php';
/* * ************************ Step 1 ************************ */
if (!isset($_SESSION['admname'])) {
    $_GLOBALS['message'] = "Session Timeout.Click here to <a href=\"index.php\">Re-LogIn</a>";
} else if (isset($_REQUEST['logout'])) {
    /*     * ************************ Step 2 - Case 1 ************************ */
    //Log out and redirect login page
    unset($_SESSION['admname']);
    header('Location: index.php');
} else if (isset($_REQUEST['dashboard'])) {
    /*     * ************************ Step 2 - Case 2 ************************ */
    //redirect to dashboard

    header('Location: admwelcome.php');
} else if (isset($_REQUEST['tcmng'])) {
    /*     * ************************ Step 2 - Case 2 ************************ */
    //redirect to dashboard

    header('Location: tcmng.php');
} else if (isset($_REQUEST['delete'])) {
    /*     * ************************ Step 2 - Case 3 ************************ */
    //deleting the selected users
     unset($_REQUEST['delete']);
    $hasvar = false;
    foreach ($_REQUEST as $variable) {
        if (is_numeric($variable)) { //it is because, some sessin values are also passed with request
            $hasvar = true;

            if (!@executeQuery("delete from student where stdid=$variable")) {
                if (mysql_errno () == 1451) //Children are dependent value
                    $_GLOBALS['message'] = "Too Prevent accidental deletions, system will not allow propagated deletions.<br/><b>Help:</b> If you still want to delete this user, then first manually delete all the records that are associated with this user.";
                else
                    $_GLOBALS['message'] = mysql_errno();
            }
        }
    }
    if (!isset($_GLOBALS['message']) && $hasvar == true)
        $_GLOBALS['message'] = "Selected User/s are successfully Deleted";
    else if (!$hasvar) {
        $_GLOBALS['message'] = "First Select the users to be Deleted.";
    }
} else if (isset($_REQUEST['savem'])) {
    /*     * ************************ Step 2 - Case 4 ************************ */
    //updating the modified values
    if (empty($_REQUEST['cname']) || empty($_REQUEST['password']) || empty($_REQUEST['email'])) {
        $_GLOBALS['message'] = "Some of the required Fields are Empty.Therefore Nothing is Updated";
    } else {
        $query = "update student set stdname='" . htmlspecialchars($_REQUEST['cname'], ENT_QUOTES) . "', stdpassword=ENCODE('" . htmlspecialchars($_REQUEST['password']) . "','oespass'),emailid='" . htmlspecialchars($_REQUEST['email'], ENT_QUOTES) . "',contactno='" . htmlspecialchars($_REQUEST['contactno'], ENT_QUOTES) . "',address='" . htmlspecialchars($_REQUEST['address'], ENT_QUOTES) . "',city='" . htmlspecialchars($_REQUEST['city'], ENT_QUOTES) . "',pincode='" . htmlspecialchars($_REQUEST['pin'], ENT_QUOTES) . "' where stdid='" . htmlspecialchars($_REQUEST['student'], ENT_QUOTES) . "';";
        if (!@executeQuery($query))
            $_GLOBALS['message'] = mysql_error();
        else
            $_GLOBALS['message'] = "User Information is Successfully Updated.";
    }
    closedb();
}
else if (isset($_REQUEST['savea'])) {
    /*     * ************************ Step 2 - Case 5 ************************ */
    //Add the new user information in the database
   $result = executeQuery("select max(stdid) as std from student");
    $r = mysql_fetch_array($result);
    if (is_null($r['std']))
        $newstd = 1;
    else
        $newstd=$r['std'] + 1;

    $result = executeQuery("select stdname as std from student where stdname='" . htmlspecialchars($_REQUEST['cname'], ENT_QUOTES) . "';");


    if (empty($_REQUEST['cname']) || empty($_REQUEST['password']) || empty($_REQUEST['email'])) {
        $_GLOBALS['message'] = "Some of the required Fields are Empty";
    } else if (mysql_num_rows($result) > 0) {
        $_GLOBALS['message'] = "Sorry User Already Exists.";
    } else {
        $query = "insert into student values($newstd,'" . htmlspecialchars($_REQUEST['cname'], ENT_QUOTES) . "',ENCODE('" . htmlspecialchars($_REQUEST['password'], ENT_QUOTES) . "','oespass'),'" . htmlspecialchars($_REQUEST['email'], ENT_QUOTES) . "','" . htmlspecialchars($_REQUEST['contactno'], ENT_QUOTES) . "','" . htmlspecialchars($_REQUEST['address'], ENT_QUOTES) . "','" . htmlspecialchars($_REQUEST['city'], ENT_QUOTES) . "','" . htmlspecialchars($_REQUEST['pin'], ENT_QUOTES) . "')";
        if (!@executeQuery($query)) {
            if (mysql_errno () == 1062) //duplicate value
                $_GLOBALS['message'] = "Given User Name voilates some constraints, please try with some other name.";
            else
                $_GLOBALS['message'] = mysql_error();
        }
        else
            $_GLOBALS['message'] = "Successfully New User is Created.";
    }
    closedb();
}
?>
<html>
    <head>
        <title>OES-Manage Users</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link rel="stylesheet" type="text/css" href="../onlineexamination.css"/>
        <script type="text/javascript" src="../validate.js" ></script>
        <style type="text/css">
<!--
.style2 {
	font-size: 36px;
	color: #FFFFFF;
	font-family: Georgia, "Times New Roman", Times, serif;
}
-->
        </style>
        <script type="text/JavaScript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
    </head>
    <body><!----onLoad="MM_preloadImages('images/logo4.jpg')"><!---->
    
      <?php
if (isset($_GLOBALS['message'])) {
    echo "<div class=\"message\">" . $_GLOBALS['message'] . "</div>";
}
?>
    
     <table width="1192" height="207" border="0">
    <tr>
      <th width="272" height="153" scope="row"><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image1','','images/logo4.jpg',1)"></a><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image1','','images/logo4.jpg',1)"><img src="images/cap2.jpg" name="Image1" width="262" height="192" border="0"></a></th>
      <td width="910" bgcolor="#9966FF"><div align="left" class="style7"><strong><span class="style8 style2"><em>Online Examination System </em></span></strong></div></td>
    </tr>
	  <th height="48" colspan="2" bgcolor="#999900" scope="row"><div align="right">
	 <form name="usermng" action="usermng.php" method="post">
                <div class="menubar">


                    <ul id="menu">
<?php
if (isset($_SESSION['admname'])) {
// Navigations
?>
                        <li><input type="submit" value="LogOut" name="logout" class="subbtn" title="Log Out"/></li>
                        <li>
                          <input type="submit" value="Home" name="dashboard" class="subbtn" title="Home"/>
                        </li>
                        <li><input type="submit" value="Test Conductors" name="tcmng" class="subbtn" title="Test Conductors Management"/></li>

<?php
    //navigation for Add option
    if (isset($_REQUEST['add'])) {
?>
                        <li><input type="submit" value="Cancel" name="cancel" class="subbtn" title="Cancel"/></li>
                        <li><input type="submit" value="Save" name="savea" class="subbtn" onClick="validateform('usermng')" title="Save the Changes"/></li>

<?php
    } else if (isset($_REQUEST['edit'])) { //navigation for Edit option
?>
                        <li><input type="submit" value="Cancel" name="cancel" class="subbtn" title="Cancel"/></li>
                        <li><input type="submit" value="Save" name="savem" class="subbtn" onClick="validateform('usermng')" title="Save the changes"/></li>

<?php
    } else {  //navigation for Default
?>
                        <li><input type="submit" value="Delete" name="delete" class="subbtn" title="Delete"/></li>
                        <li><input type="submit" value="Add" name="add" class="subbtn" title="Add"/></li>
<?php }
} ?>
                    </ul>
        </div>
                <div class="page">
<?php
if (isset($_SESSION['admname'])) {
    echo "<div class=\"pmsg\" style=\"text-align:center;\">Students Management </div>";
    if (isset($_REQUEST['add'])) {
        /*         * ************************ Step 3 - Case 1 ************************ */
        //Form for the new user
?>
    <!----<tr>
      <th height="48" colspan="2" bgcolor="#999900" scope="row"><div align="right">
        <form name="form1" method="post" action="">
          <label>
          <input type="submit" name="Submit42" value="Add">
            <input type="submit" name="Submit32" value="Delete">
            <input type="submit" name="Submit22" value="Save">
            <input type="submit" name="Submit6" value="Cancel">
<input type="submit" name="Submit5" value="Save">
            <input type="submit" name="Submit4" value="Test Conductors">
            <input type="submit" name="Submit3" value="DashBoard">
            <input type="submit" name="Submit2" value="LogOut">
          </label>
        </form>
        </div></th>
    </tr><!---->
  </table>
     <table width="1191" height="528" border="1">
       <tr>
         <td height="175" colspan="2"><table cellpadding="20" cellspacing="20" style="text-align:left;margin-left:15em" >
           <tr>
             <td bgcolor="#CC99FF">User Name</td>
             <td bgcolor="#CC99FF"><input type="text" name="cname" value="" size="16" onKeyUp="isalphanum(this)"/></td>
           </tr>
           <tr>
             <td bgcolor="#CC99FF">Password</td>
             <td bgcolor="#CC99FF"><input type="password" name="password" value="" size="16" onKeyUp="isalphanum(this)" /></td>
           </tr>
           <tr>
             <td bgcolor="#CC99FF">Re-type Password</td>
             <td bgcolor="#CC99FF"><input type="password" name="repass" value="" size="16" onKeyUp="isalphanum(this)" /></td>
           </tr>
           <tr>
             <td bgcolor="#CC99FF">E-mail ID</td>
             <td bgcolor="#CC99FF"><input type="text" name="email" value="" size="16" /></td>
           </tr>
           <tr>
             <td bgcolor="#CC99FF">Contact No</td>
             <td bgcolor="#CC99FF"><input type="text" name="contactno" value="" size="16" onKeyUp="isnum(this)"/></td>
           </tr>
           <tr>
             <td bgcolor="#CC99FF">Address</td>
             <td bgcolor="#CC99FF"><textarea name="address" cols="20" rows="3"></textarea></td>
           </tr>
           <tr bgcolor="#CC99FF">
             <td>City</td>
             <td><input type="text" name="city" value="" size="16" onKeyUp="isalpha(this)"/></td>
           </tr>
           <tr bgcolor="#CC99FF">
             <td>PIN Code</td>
             <td><input type="text" name="pin" value="" size="16" onKeyUp="isnum(this)" /></td>
           </tr>
		   </table></td>
 <?php
    } else if (isset($_REQUEST['edit'])) {
        /*         * ************************ Step 3 - Case 2 ************************ */
        // To allow Editing Existing User Information
        $result = executeQuery("select stdid,stdname,DECODE(stdpassword,'oespass') as stdpass ,emailid,contactno,address,city,pincode from student where stdname='" . htmlspecialchars($_REQUEST['edit'], ENT_QUOTES) . "';");
        if (mysql_num_rows($result) == 0) {
            header('Location: usermng.php');
        } else if ($r = mysql_fetch_array($result)) {

            //editing components
?>

       <tr>
         <td height="131" colspan="2"><table cellpadding="20" cellspacing="20" style="text-align:left;margin-left:15em" >
           <tr bgcolor="#CC99FF">
             <td>User Name</td>
                            <td><input type="text" name="cname" value="<?php echo htmlspecialchars_decode($r['stdname'], ENT_QUOTES); ?>" size="16" onKeyUp="isalphanum(this)"/></td>

           </tr>

                        <tr>
                            <td>Password</td>
                            <td><input type="text" name="password" value="<?php echo htmlspecialchars_decode($r['stdpass'], ENT_QUOTES); ?>" size="16" onKeyUp="isalphanum(this)" /></td>

                        </tr>

                        <tr>
                            <td>E-mail ID</td>
                            <td><input type="text" name="email" value="<?php echo htmlspecialchars_decode($r['emailid'], ENT_QUOTES); ?>" size="16" /></td>
                        </tr>
                        <tr>
                            <td>Contact No</td>
                            <td><input type="text" name="contactno" value="<?php echo htmlspecialchars_decode($r['contactno'], ENT_QUOTES); ?>" size="16" onKeyUp="isnum(this)"/></td>
                        </tr>

                        <tr>
                            <td>Address</td>
                            <td><textarea name="address" cols="20" rows="3"><?php echo htmlspecialchars_decode($r['address'], ENT_QUOTES); ?></textarea></td>
                        </tr>
                        <tr>
                            <td>City</td>
                            <td><input type="text" name="city" value="<?php echo htmlspecialchars_decode($r['city'], ENT_QUOTES); ?>" size="16" onKeyUp="isalpha(this)"/></td>
                        </tr>
                        <tr>
                            <td>PIN Code</td>
                            <td><input type="hidden" name="student" value="<?php echo htmlspecialchars_decode($r['stdid'], ENT_QUOTES); ?>"/><input type="text" name="pin" value="<?php echo $r['pincode']; ?>" size="16" onKeyUp="isnum(this)" /></td>
                        </tr>

                    </table>
<?php
                    closedb();
                }
            } else {
                /*                 * ************************ Step 3 - Case 3 ************************ */
                // Defualt Mode: Displays the Existing Users, If any.
                $result = executeQuery("select * from student order by stdid;");
                if (mysql_num_rows($result) == 0) {
                    echo "<h3 style=\"color:#0000cc;text-align:center;\">No Users Yet..!</h3>";
                } else {
                    $i = 0;
?>
       
     <table width="1193" border="1">
       <tr>
         <td width="1183"><table cellpadding="30" cellspacing="10" class="datatable">
           <tr>
             
             <th>User Name</th>
             <th>Email-ID</th>
             <th>Contact Number</th>
             <th>Edit</th>
           </tr>
          
		 <?php
                    while ($r = mysql_fetch_array($result)) {
                        $i = $i + 1;
                        if ($i % 2 == 0)
                            echo "<tr class=\"alt\">";
                        else
                            echo "<tr>";
                        echo "<td style=\"text-align:center;\"><input type=\"checkbox\" name=\"d$i\" value=\"" . $r['stdid'] . "\" /></td><td>" . htmlspecialchars_decode($r['stdname'], ENT_QUOTES)
                        . "</td><td>" . htmlspecialchars_decode($r['emailid'], ENT_QUOTES) . "</td><td>" . htmlspecialchars_decode($r['contactno'], ENT_QUOTES) . "</td>"
                        . "<td class=\"tddata\"><a title=\"Edit " . htmlspecialchars_decode($r['stdname'], ENT_QUOTES) . "\"href=\"usermng.php?edit=" . htmlspecialchars_decode($r['stdname'], ENT_QUOTES) . "\"><img src=\"../images/edit.png\" height=\"30\" width=\"40\" alt=\"Edit\" /></a></td></tr>";
                    }
?>
                    </table>
<?php
                }
                closedb();
            }
        }
?>

                </div>
            </form>
                </div>
     <table width="1188" border="0">
       <tr>
         <td height="37" bgcolor="#999966">&nbsp;</td>
       </tr>
    </table>
</body>
</html>

