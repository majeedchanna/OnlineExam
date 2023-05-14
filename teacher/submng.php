
<?php
error_reporting(0);
session_start();
include_once '../onlineexaminationdb.php';
/* * ************************ Step 1 ************************ */
if (!isset($_SESSION['tcname'])) {
    $_GLOBALS['message'] = "Session Timeout.Click here to <a href=\"index.php\">Re-LogIn</a>";
} else if (isset($_REQUEST['logout'])) {
    /*     * ************************ Step 2 - Case 1 ************************ */
    //Log out and redirect login page
    unset($_SESSION['tcname']);
    header('Location: index.php');
} else if (isset($_REQUEST['dashboard'])) {
    /*     * ************************ Step 2 - Case 2 ************************ */
    //redirect to dashboard
    header('Location: tcwelcome.php');
} else if (isset($_REQUEST['delete'])) {
    /*     * ************************ Step 2 - Case 3 ************************ */
    //deleting the selected Subjects
    unset($_REQUEST['delete']);
    $hasvar = false;
    foreach ($_REQUEST as $variable) {
        if (is_numeric($variable)) { //it is because, some session values are also passed with request
            $hasvar = true;

            if (!@executeQuery("delete from subject where subid=$variable and tcid=" . $_SESSION['tcid'] . ";")) {
                if (mysql_errno () == 1451) //Children are dependent value
                    $_GLOBALS['message'] = "Too Prevent accidental deletions, system will not allow propagated deletions.<br/><b>Help:</b> If you still want to delete this subject, then first delete the tests that are conducted/dependent on this subject.";
                else
                    $_GLOBALS['message'] = mysql_errno();
            }
        }
    }
    if (!isset($_GLOBALS['message']) && $hasvar == true)
        $_GLOBALS['message'] = "Selected Subject/s are successfully Deleted";
    else if (!$hasvar) {
        $_GLOBALS['message'] = "First Select the subject/s to be Deleted.";
    }
} else if (isset($_REQUEST['savem'])) {
    /*     * ************************ Step 2 - Case 4 ************************ */
    //updating the modified values
    if (empty($_REQUEST['subname']) || empty($_REQUEST['subdesc'])) {
        $_GLOBALS['message'] = "Some of the required Fields are Empty.Therefore Nothing is Updated";
    } else {
        $query = "update subject set subname='" . htmlspecialchars($_REQUEST['subname'], ENT_QUOTES) . "', subdesc='" . htmlspecialchars($_REQUEST['subdesc'], ENT_QUOTES) . "'where subid=" . $_REQUEST['subject'] . " and tcid=" . $_SESSION['tcid'] . ";";
        if (!@executeQuery($query))
            $_GLOBALS['message'] = mysql_error();
        else
            $_GLOBALS['message'] = "Subject Information is Successfully Updated.";
    }
    closedb();
}
else if (isset($_REQUEST['savea'])) {
    /*     * ************************ Step 2 - Case 5 ************************ */
    //Add the new Subject information in the database
    $result = executeQuery("select max(subid) as sub from subject");
    $r = mysql_fetch_array($result);
    if (is_null($r['sub']))
        $newstd = 1;
    else
        $newstd=$r['sub'] + 1;

    $result = executeQuery("select subname as sub from subject where subname='" . htmlspecialchars($_REQUEST['subname'], ENT_QUOTES) . "' and tcid=" . $_SESSION['tcid'] . ";");
    // $_GLOBALS['message']=$newstd;
    if (empty($_REQUEST['subname']) || empty($_REQUEST['subdesc'])) {
        $_GLOBALS['message'] = "Some of the required Fields are Empty";
    } else if (mysql_num_rows($result) > 0) {
        $_GLOBALS['message'] = "Sorry Subject Already Exists.";
    } else {
        $query = "insert into subject values($newstd,'" . htmlspecialchars($_REQUEST['subname'], ENT_QUOTES) . "','" . htmlspecialchars($_REQUEST['subdesc'], ENT_QUOTES) . "'," . $_SESSION['tcid'] . ")";
        if (!@executeQuery($query)) {
            if (mysql_errno () == 1062) //duplicate value
                $_GLOBALS['message'] = "Given Subject Name voilates some constraints, please try with some other name.";
            else
                $_GLOBALS['message'] = mysql_error ();
        }
        else
            $_GLOBALS['message'] = "Successfully New Subject is Created.";
    }
    closedb();
}
?>
<html>
    <head>
        <title>OES-Manage Subjects</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link rel="stylesheet" type="text/css" href="../onlineexamination.css"/>
        <script type="text/javascript" src="../validate.js" ></script>
        <style type="text/css">
<!--
.style11 {	font-family: Georgia, "Times New Roman", Times, serif;
	font-size: 36px;
	color: #FFFFFF;
	font-weight: bold;
	font-style: italic;
}
.style12 {font-family: Georgia, "Times New Roman", Times, serif}
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
    <body><!---- onLoad="MM_preloadImages('../images/logo4.jpg')"><!---->
    <?php
if ($_GLOBALS['message']) {
    echo "<div class=\"message\">" . $_GLOBALS['message'] . "</div>";
}
?>

    
    <table width="1192" height="207" border="0">
      <tr>
        <th width="272" height="153" scope="row"><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image1','','file:///C|/Users/HIFZA/Documents/Unnamed Site 5/logo4.jpg',1)"></a><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image2','','../images/logo4.jpg',1)"><img src="../images/cap2.jpg" width="262" height="192" border="0" id="Image2" /></a><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image1','','images/logo4.jpg',1)"></a></th>
        <td width="910" bgcolor="#9966FF"><div align="left" class="style11">Online Examination System </div></td>
      </tr>
	  <th height="48" colspan="2" bgcolor="#999900" scope="row"><div align="right">
        
	  <form name="submng" action="submng.php" method="post">
                <div class="menubar">


                    <ul id="menu">
<?php
if (isset($_SESSION['tcname'])) {
// Navigations
?>
                        <li><input type="submit" value="LogOut" name="logout" class="subbtn" title="Log Out"/></li>
                        <li><input type="submit" value="Home" name="dashboard" class="subbtn" title="Home"/></li>

<?php
    //navigation for Add option
    if (isset($_REQUEST['add'])) {
?>
                        <li><input type="submit" value="Cancel" name="cancel" class="subbtn" title="Cancel"/></li>
                        <li><input type="submit" value="Save" name="savea" class="subbtn" onClick="validatesubform('submng')" title="Save the Changes"/></li>

<?php
    } else if (isset($_REQUEST['edit'])) { //navigation for Edit option
?>
                        <li><input type="submit" value="Cancel" name="cancel" class="subbtn" title="Cancel"/></li>
                        <li><input type="submit" value="Save" name="savem" class="subbtn" onClick="validatesubform('submng')" title="Save the changes"/></li>

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
if (isset($_SESSION['tcname'])) {

    if (isset($_REQUEST['add'])) {

        /*         * ************************ Step 3 - Case 1 ************************ */
        //Form for the new Subject
?>
      
    </table>
    <table width="1192" height="282" border="0">
      <tr>
        <th width="1182" height="137" colspan="2" scope="row"><table cellpadding="20" cellspacing="20" style="text-align:left;margin-left:15em" >
                        <tr>
                            <td>Subject Name</td>
                            <td><input type="text" name="subname" value="" size="16" onKeyUp="isalphanum(this)" onBlur="if(this.value==''){alert('Subject Name is Empty');this.focus();this.value='';}"/></td>

                        </tr>

                        <tr>
                            <td>Subject Description</td>
                            <td><textarea name="subdesc" cols="20" rows="3" onBlur="if(this.value==''){alert('Subject Description is Empty');this.focus();this.value='';}"></textarea></td>
                        </tr>

                    </table>

<?php
    } else if (isset($_REQUEST['edit'])) {

        /*         * ************************ Step 3 - Case 2 ************************ */
        // To allow Editing Existing Subject.
        $result = executeQuery("select subid,subname,subdesc from subject where subname='" . htmlspecialchars($_REQUEST['edit'], ENT_QUOTES) . "' and tcid=" . $_SESSION['tcid'] . ";");
        if (mysql_num_rows($result) == 0) {
            header('submng.php');
        } else if ($r = mysql_fetch_array($result)) {


            //editing components
?>
  <table cellpadding="20" cellspacing="20" style="text-align:left;margin-left:15em" >
                        <tr>
                            <td>Subject Name</td>
                            <td><input type="text" name="subname" value="<?php echo htmlspecialchars_decode($r['subname'], ENT_QUOTES); ?>" size="16" onKeyUp="isalphanum(this)"/></td>

                        </tr>
                        <tr>
                            <td>Subject Description</td>
                            <td><textarea name="subdesc" cols="20" rows="3"><?php echo htmlspecialchars_decode($r['subdesc'], ENT_QUOTES); ?></textarea><input type="hidden" name="subject" value="<?php echo $r['subid']; ?>"/></td>
                        </tr>
                    </table>
<?php
                    closedb();
                }
            } else {

                /*                 * ************************ Step 3 - Case 3 ************************ */
                // Defualt Mode: Displays the Existing Subject/s, If any.
                $result = executeQuery("select * from subject where tcid=" . $_SESSION['tcid'] . " order by subid;");
                if (mysql_num_rows($result) == 0) {
                    echo "<h3 style=\"color:#0000cc;text-align:center;\">No Subjets Yet..!</h3>";
                } else {
                    $i = 0;
?>
            
				                  <table width="99%" border="0" cellpadding="30" cellspacing="10" class="datatable">
                          <tr>
                                   
                                    <th class="timerclass"><div align="center">Subject Name</div></th>
                                    <th class="timerclass"><div align="center">Subject Description</div></th>
                                   <th class="timerclass"><div align="center"><span class="style1">Edit</span></div></th>
						 </tr>
    <?php
                    while ($r = mysql_fetch_array($result)) {
                        $i = $i + 1;
                        if ($i % 2 == 0) {
                            echo "<tr class=\"alt\">";
                        } else {
                            echo "<tr>";
                        }
                        echo "<td style=\"text-align:center;\"><input type=\"checkbox\" name=\"d$i\" value=\"" . $r['subid'] . "\" /></td><td>" . htmlspecialchars_decode($r['subname'], ENT_QUOTES)
                        . "</td><td>" . htmlspecialchars_decode($r['subdesc'], ENT_QUOTES) . "</td>"
                        . "<td class=\"tddata\"><a title=\"Edit " . htmlspecialchars_decode($r['stdname'], ENT_QUOTES) . "\"href=\"submng.php?edit=" . htmlspecialchars_decode($r['subname'], ENT_QUOTES) . "\"><img src=\"../images/edit.png\" height=\"30\" width=\"40\" alt=\"Edit\" /></a></td></tr>";
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
            </table>
                    <div align="left">
                      <table width="1193" border="0">
                        <tr>
                          <th height="35" bgcolor="#999966" scope="row">&nbsp;</th>
                        </tr>
                                          </table>
                    </div>
                    <table width="1192" height="42" border="1">
                
              </table>
              <tr>
</body>
</html>

