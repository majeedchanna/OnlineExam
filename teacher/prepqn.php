
<?php
error_reporting(0);
session_start();
include_once '../onlineexaminationdb.php';
/* * ************************ Step 1 ************************ */
if (!isset($_SESSION['tcname']))//|| !isset($_SESSION['testqn'])) {
{
    $_GLOBALS['message'] = "Session Timeout.Click here to <a href=\"index.php\">Re-LogIn</a>";
} else if (isset($_REQUEST['logout'])) {
    /*     * ************************ Step 2 - Case 1 ************************ */
    //Log out and redirect login page
    unset($_SESSION['tcname']);
    header('Location: index.php');
} else if (isset($_REQUEST['managetests'])) {
    /*     * ************************ Step 2 - Case 2 ************************ */
    //redirect to Manage Tests Section

    header('Location: testmng.php');
} else if (isset($_REQUEST['delete'])) {
    /*     * ************************ Step 2 - Case 3 ************************ */
    //deleting the selected Questions
    unset($_REQUEST['delete']);
    $hasvar = false;
    $count = 1;
    foreach ($_REQUEST as $variable) {
        if (is_numeric($variable)) { //it is because, some session values are also passed with request
            $hasvar = true;

            if (!@executeQuery("delete from question where testid=" . $_SESSION['testqn'] . " and qnid=$variable"))
                $_GLOBALS['message'] = mysql_error();
        }
    }
    //reordering questions

    $result = executeQuery("select qnid from question where testid=" . $_SESSION['testqn'] . " order by qnid;");
    while ($r = mysql_fetch_array($result))
        if (!@executeQuery("update question set qnid=" . ($count++) . " where testid=" . $_SESSION['testqn'] . " and qnid=" . $r['qnid'] . ";"))
            $_GLOBALS['message'] = mysql_error();

    //
    if (!isset($_GLOBALS['message']) && $hasvar == true)
        $_GLOBALS['message'] = "Selected Questions are successfully Deleted";
    else if (!$hasvar) {
        $_GLOBALS['message'] = "First Select the Questions to be Deleted.";
    }
} else if (isset($_REQUEST['savem'])) {
    /*     * ************************ Step 2 - Case 4 ************************ */
    //updating the modified values
    // $_GLOBALS['message']=$newstd;
    if (strcmp($_REQUEST['correctans'], "<Choose the Correct Answer>") == 0 || empty($_REQUEST['question']) || empty($_REQUEST['optiona']) || empty($_REQUEST['optionb']) || empty($_REQUEST['optionc']) || empty($_REQUEST['optiond']) || empty($_REQUEST['marks'])) {
        $_GLOBALS['message'] = "Some of the required Fields are Empty";
    } else if (strcasecmp($_REQUEST['optiona'], $_REQUEST['optionb']) == 0 || strcasecmp($_REQUEST['optiona'], $_REQUEST['optionc']) == 0 || strcasecmp($_REQUEST['optiona'], $_REQUEST['optiond']) == 0 || strcasecmp($_REQUEST['optionb'], $_REQUEST['optionc']) == 0 || strcasecmp($_REQUEST['optionb'], $_REQUEST['optiond']) == 0 || strcasecmp($_REQUEST['optionc'], $_REQUEST['optiond']) == 0) {
        $_GLOBALS['message'] = "Two or more options are representing same answers.Verify Once again";
    } else {
        $query = "update question set question='" . htmlspecialchars($_REQUEST['question'], ENT_QUOTES) . "',optiona='" . htmlspecialchars($_REQUEST['optiona'], ENT_QUOTES) . "',optionb='" . htmlspecialchars($_REQUEST['optionb'], ENT_QUOTES) . "',optionc='" . htmlspecialchars($_REQUEST['optionc'], ENT_QUOTES) . "',optiond='" . htmlspecialchars($_REQUEST['optiond'], ENT_QUOTES) . "',correctanswer='" . htmlspecialchars($_REQUEST['correctans'], ENT_QUOTES) . "',marks=" . htmlspecialchars($_REQUEST['marks'], ENT_QUOTES) . " where testid=" . $_SESSION['testqn'] . " and qnid=" . $_REQUEST['qnid'] . " ;";
        if (!@executeQuery($query))
            $_GLOBALS['message'] = mysql_error();
        else
            $_GLOBALS['message'] = "Question is updated Successfully.";
    }
    closedb();
}
else if (isset($_REQUEST['savea'])) {
    /*     * ************************ Step 2 - Case 5 ************************ */
    //Add the new Question
    $cancel = false;
    $result = executeQuery("select max(qnid) as qn from question where testid=" . $_SESSION['testqn'] . ";");
    $r = mysql_fetch_array($result);
    if (is_null($r['qn']))
        $newstd = 1;
    else
        $newstd=$r['qn'] + 1;

    $result = executeQuery("select count(*) as q from question where testid=" . $_SESSION['testqn'] . ";");
    $r2 = mysql_fetch_array($result);

    $result = executeQuery("select totalquestions from test where testid=" . $_SESSION['testqn'] . ";");
    $r1 = mysql_fetch_array($result);

    if (!is_null($r2['q']) && (int) htmlspecialchars_decode($r1['totalquestions'], ENT_QUOTES) == (int) $r2['q']) {
        $cancel = true;
        $_GLOBALS['message'] = "Already you have created all the Questions for this Test.<br /><b>Help:</b> If you still want to add some more questions then edit the test settings(option:Total Questions).";
    }
    else
        $cancel=false;

    $result = executeQuery("select * from question where testid=" . $_SESSION['testqn'] . " and question='" . htmlspecialchars($_REQUEST['question'], ENT_QUOTES) . "';");
    if (!$cancel && $r1 = mysql_fetch_array($result)) {
        $cancel = true;
        $_GLOBALS['message'] = "Sorry, You trying to enter same question for Same test";
    } else if (!$cancel)
        $cancel = false;
    // $_GLOBALS['message']=$newstd;
    if (strcmp($_REQUEST['correctans'], "<Choose the Correct Answer>") == 0 || empty($_REQUEST['question']) || empty($_REQUEST['optiona']) || empty($_REQUEST['optionb']) || empty($_REQUEST['optionc']) || empty($_REQUEST['optiond']) || empty($_REQUEST['marks'])) {
        $_GLOBALS['message'] = "Some of the required Fields are Empty";
    } else if (strcasecmp($_REQUEST['optiona'], $_REQUEST['optionb']) == 0 || strcasecmp($_REQUEST['optiona'], $_REQUEST['optionc']) == 0 || strcasecmp($_REQUEST['optiona'], $_REQUEST['optiond']) == 0 || strcasecmp($_REQUEST['optionb'], $_REQUEST['optionc']) == 0 || strcasecmp($_REQUEST['optionb'], $_REQUEST['optiond']) == 0 || strcasecmp($_REQUEST['optionc'], $_REQUEST['optiond']) == 0) {
        $_GLOBALS['message'] = "Two or more options are representing same answers.Verify Once again";
    } else if (!$cancel) {
        $query = "insert into question values(" . $_SESSION['testqn'] . ",$newstd,'" . htmlspecialchars($_REQUEST['question'], ENT_QUOTES) . "','" . htmlspecialchars($_REQUEST['optiona'], ENT_QUOTES) . "','" . htmlspecialchars($_REQUEST['optionb'], ENT_QUOTES) . "','" . htmlspecialchars($_REQUEST['optionc'], ENT_QUOTES) . "','" . htmlspecialchars($_REQUEST['optiond'], ENT_QUOTES) . "','" . htmlspecialchars($_REQUEST['correctans'], ENT_QUOTES) . "'," . htmlspecialchars($_REQUEST['marks'], ENT_QUOTES) . ")";
        if (!@executeQuery($query)) 
                $_GLOBALS['message'] = mysql_error();
        else
            $_GLOBALS['message'] = "Successfully New Question is Created.";
    }
    closedb();
}
?>
<html>
    <head>
        <title>OES-Manage Questions</title>
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
    <body><!----onLoad="MM_preloadImages('../images/logo4.jpg')"><!---->
    
      <?php
if ($_GLOBALS['message']) {
    echo "<div class=\"message\">" . $_GLOBALS['message'] . "</div>";
}
?>
    
    <p>&nbsp;</p>
    <table width="1192" height="207" border="0">
      <tr>
        <th width="272" height="153" scope="row"><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image1','','file:///C|/Users/HIFZA/Documents/Unnamed Site 5/logo4.jpg',1)"></a><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image2','','../images/logo4.jpg',1)"><img src="../images/cap2.jpg" width="262" height="192" border="0" id="Image2" /></a><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image1','','images/logo4.jpg',1)"></a></th>
        <td width="910" bgcolor="#9966FF"><div align="left" class="style11">Online Examination System </div></td>
      </tr>
     <!---- <tr>
        <th height="48" colspan="2" bgcolor="#999900" scope="row"><div align="right">
         <!---- <form name="form1" method="post" action="">
            <label>
              <input type="submit" name="Submit2" value="Add">
              <input type="submit" name="Submit3" value="Detete">
              <input type="submit" name="Submit4" value="Save">
              <input type="submit" name="Submit5" value="Cancel">
              <input type="submit" name="Submit6" value="Save">
              <input type="submit" name="Submit7" value="Cancel">
              <input type="submit" name="Submit8" value="Manage Tests">
              <input type="submit" name="Submit" value="LogOut">
            </label>
          </form>
          </div></th>
      </tr><!---->
	  
	  <th height="48" colspan="2" bgcolor="#999900" scope="row"><div align="right">
	 <form name="prepqn" action="prepqn.php" method="post">
                <div class="menubar">


                    <ul id="menu">
<?php
if (isset($_SESSION['tcname']) && isset($_SESSION['testqn'])) {
    // Navigations
?>
                        <li><input type="submit" value="LogOut" name="logout" class="subbtn" title="Log Out"/></li>
                        <li><input type="submit" value="Manage Tests" name="managetests" class="subbtn" title="Manage Tests"/></li>

<?php
    //navigation for Add option
    if (isset($_REQUEST['add'])) {
?>
                        <li><input type="submit" value="Cancel" name="cancel" class="subbtn" title="Cancel"/></li>
                        <li><input type="submit" value="Save" name="savea" class="subbtn" onClick="validateqnform('prepqn')" title="Save the Changes"/></li>

<?php
    } else if (isset($_REQUEST['edit'])) { //navigation for Edit option
?>
                        <li><input type="submit" value="Cancel" name="cancel" class="subbtn" title="Cancel"/></li>
                        <li><input type="submit" value="Save" name="savem" class="subbtn" onClick="validateqnform('prepqn')" title="Save the changes"/></li>

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
$result = executeQuery("select count(*) as q from question where testid=" . $_SESSION['testqn'] . ";");
$r1 = mysql_fetch_array($result);

$result = executeQuery("select totalquestions from test where testid=" . $_SESSION['testqn'] . ";");
$r2 = mysql_fetch_array($result);
if ((int) $r1['q'] == (int) htmlspecialchars_decode($r2['totalquestions'], ENT_QUOTES))
    echo "<div class=\"pmsg\"><center> Test Name: " . $_SESSION['testname'] . "<br/>Status: All the Questions are Created for this test</center></div>";
else
    echo "<div class=\"pmsg\"> Test Name: " . $_SESSION['testname'] . "<br/>Status: Still you need to create " . (htmlspecialchars_decode($r2['totalquestions'], ENT_QUOTES) - $r1['q']) . " Question/s. After that only, test will be available for candidates.</div>";
?>
                    <?php
                    if (isset($_SESSION['tcname']) && isset($_SESSION['testqn'])) {

                        if (isset($_REQUEST['add'])) {
                            /*                             * ************************ Step 3 - Case 1 ************************ */
                            //Form for the new Question
                    ?>
 
      <table width="1191" height="578" border="0">
        <tr>
          <th colspan="2" scope="row"><table cellpadding="20" cellspacing="20" style="text-align:left;" >
            <tr bgcolor="#CC99FF">
              <td><span class="style12">Question</span></td>
              <td><span class="style12">
                <textarea name="question" cols="40" rows="3"  ></textarea>
              </span></td>
            </tr>
            <tr bgcolor="#CC99FF">
              <td><span class="style12">Option A</span></td>
              <td><input name="optiona" type="text" value="" size="30"  /></td>
            </tr>
            <tr bgcolor="#CC99FF">
              <td><span class="style12">Option B</span></td>
              <td><input name="optionb" type="text" value="" size="30"  /></td>
            </tr>
            <tr bgcolor="#CC99FF">
              <td><span class="style12">Option C</span></td>
              <td><input name="optionc" type="text" value="" size="30"  /></td>
            </tr>
            <tr bgcolor="#CC99FF">
              <td><span class="style12">Option D</span></td>
              <td><input name="optiond" type="text" value="" size="30"  /></td>
            </tr>
            <tr bgcolor="#CC99FF">
              <td><span class="style12">Correct Answer</span></td>
              <td><span class="style12">
                <select name="correctans">
                  <option value="<Choose the Correct Answer>" selected>&lt;Choose the Correct Answer&gt;</option>
                  <option value="optiona">Option A</option>
                  <option value="optionb">Option B</option>
                  <option value="optionc">Option C</option>
                  <option value="optiond">Option D</option>
                  </select>
              </span> </td>
            </tr>
            <tr bgcolor="#CC99FF">
              <td><span class="style12">Marks</span></td>
              <td><input name="marks" type="text" onKeyUp="isnum(this)" value="1" size="30" /></td>
            </tr>
          </table></th>
        </tr>
       <?php
                        } else if (isset($_REQUEST['edit'])) {
                            /*                             * ************************ Step 3 - Case 2 ************************ */
                            // To allow Editing Existing Question.
                            $result = executeQuery("select * from question where testid=" . $_SESSION['testqn'] . " and qnid=" . $_REQUEST['edit'] . ";");
                            if (mysql_num_rows($result) == 0) {
                                header('Location: prepqn.php');
                            } else if ($r = mysql_fetch_array($result)) {


                                //editing components
        ?>
        <tr>
          <th height="221" colspan="2" scope="row"><div align="center">
            <table cellpadding="20" cellspacing="20" style="text-align:left;margin-left:15em;" >
              <tr bgcolor="#CC99FF">
                <td>Question<input type="hidden" name="qnid" value="<?php echo $r['qnid']; ?>" /></td>
                                        <td><textarea name="question" cols="40" rows="3"  ><?php echo htmlspecialchars_decode($r['question'], ENT_QUOTES); ?></textarea></td>
                                    </tr>
                                    <tr>
                                        <td>Option A</td>
                                        <td><input type="text" name="optiona" value="<?php echo htmlspecialchars_decode($r['optiona'], ENT_QUOTES); ?>" size="30"  /></td>
                                    </tr>
                                    <tr>
                                        <td>Option B</td>
                                        <td><input type="text" name="optionb" value="<?php echo htmlspecialchars_decode($r['optionb'], ENT_QUOTES); ?>" size="30"  /></td>
                                    </tr>

                                    <tr>
                                        <td>Option C</td>
                                        <td><input type="text" name="optionc" value="<?php echo htmlspecialchars_decode($r['optionc'], ENT_QUOTES); ?>" size="30"  /></td>
                                    </tr>
                                    <tr>
                                        <td>Option D</td>
                                        <td><input type="text" name="optiond" value="<?php echo htmlspecialchars_decode($r['optiond'], ENT_QUOTES); ?>" size="30"  /></td>
                                    </tr>
                                    <tr>
                                        <td>Correct Answer</td>
                                        <td>
                                            <select name="correctans">
                                                <option value="optiona" <?php if (strcmp(htmlspecialchars_decode($r['correctanswer'], ENT_QUOTES), "optiona") == 0)
                                    echo "selected"; ?>>Option A</option>
                                                <option value="optionb" <?php if (strcmp(htmlspecialchars_decode($r['correctanswer'], ENT_QUOTES), "optionb") == 0)
                                    echo "selected"; ?>>Option B</option>
                                    <option value="optionc" <?php if (strcmp(htmlspecialchars_decode($r['correctanswer'], ENT_QUOTES), "optionc") == 0)
                                    echo "selected"; ?>>Option C</option>
                                    <option value="optiond" <?php if (strcmp(htmlspecialchars_decode($r['correctanswer'], ENT_QUOTES), "optiond") == 0)
                                    echo "selected"; ?>>Option D</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Marks</td>
                            <td><input type="text" name="marks" value="<?php echo htmlspecialchars_decode($r['marks'], ENT_QUOTES); ?>" size="30" onKeyUp="isnum(this)" /></td>

                        </tr>

                    </table>
<?php
                                closedb();
                            }
                        }

                        else {

                            /*                             * ************************ Step 3 - Case 3 ************************ */
                            // Defualt Mode: Displays the Existing Question/s, If any.
                            $result = executeQuery("select * from question where testid=" . $_SESSION['testqn'] . " order by qnid;");
                            if (mysql_num_rows($result) == 0) {
                                echo "<h3 style=\"color:#0000cc;text-align:center;\">No Questions Yet..!</h3>";
                            } else {
                                $i = 0;
?>
          </div></th>
        </tr>
      </table>
                 <table width="1192" border="1">
                                    <th class="timerclass"><div align="center">Qn.No</div></th>
                                    <th class="timerclass"><div align="center">Question</div></th>
                                    <th class="timerclass"><div align="center">Correct Answer</div></th>
                                    <th class="timerclass"><div align="center">Marks</div></th>
									<th class="timerclass"><div align="center">Edit</div></th>
                
				 <?php
                                while ($r = mysql_fetch_array($result)) {
                                    $i = $i + 1;
                                    if ($i % 2 == 0)
                                        echo "<tr class=\"alt\">";
                                    else
                                        echo "<tr>";
                                    echo "<td style=\"text-align:center;\"><input type=\"checkbox\" name=\"d$i\" value=\"" . $r['qnid'] . "\" /></td><td> " . $i
                                    . "</td><td>" . htmlspecialchars_decode($r['question'], ENT_QUOTES) . "</td><td>" . htmlspecialchars_decode($r[htmlspecialchars_decode($r['correctanswer'], ENT_QUOTES)], ENT_QUOTES) . "</td><td>" . htmlspecialchars_decode($r['marks'], ENT_QUOTES) . "</td>"
                                    . "<td class=\"tddata\"><a title=\"Edit " . $r['qnid'] . "\"href=\"prepqn.php?edit=" . $r['qnid'] . "\"><img src=\"../images/edit.png\" height=\"30\" width=\"40\" alt=\"Edit\" /></a>"
                                    . "</td></tr>";
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
      <table width="1189" height="42" border="0">
        <tr>
          <th height="36" bgcolor="#999966" scope="row">&nbsp;</th>
        </tr>
      </table>
     </th>
        </tr>
      </table>
    </body>
</html>
