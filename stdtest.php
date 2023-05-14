<?php

error_reporting(0);
session_start();
include_once 'onlineexaminationdb.php';
if (!isset($_SESSION['stdname'])) {
    $_GLOBALS['message'] = "Session Timeout.Click here to <a href=\"index.php\">Re-LogIn</a>";
} else if (isset($_SESSION['starttime'])) {
    header('Location: testconducter.php');
} else if (isset($_REQUEST['logout'])) {
    //Log out and redirect login page
    unset($_SESSION['stdname']);
    header('Location: index.php');
} else if (isset($_REQUEST['dashboard'])) {
    //redirect to dashboard
    //
    header('Location: stdwelcome.php');
} else if (isset($_REQUEST['starttest'])) {
    //Prepare the parameters needed for Test Conducter and redirect to test conducter
    if (!empty($_REQUEST['tc'])) {
        $result = executeQuery("select DECODE(testcode,'oespass') as tcode from test where testid=" . $_SESSION['testid'] . ";");

        if ($r = mysql_fetch_array($result)) {
            if (strcmp(htmlspecialchars_decode($r['tcode'], ENT_QUOTES), htmlspecialchars($_REQUEST['tc'], ENT_QUOTES)) != 0) {
                $display = true;
                $_GLOBALS['message'] = "You have entered an Invalid Test Code.Try again.";
            } else {
                //now prepare parameters for Test Conducter and redirect to it.
                //first step: Insert the questions into table

                $result = executeQuery("select * from question where testid=" . $_SESSION['testid'] . " order by qnid;");
                if (mysql_num_rows($result) == 0) {
                    $_GLOBALS['message'] = "Tests questions cannot be selected.Please Try after some time!";
                } else {
                  //  executeQuery("COMMIT");
                    $error = false;
                //    executeQuery("delimiter |");
                 /*   if (!executeQuery("create event " . $_SESSION['stdname'] . time() . "
ON SCHEDULE AT (select endtime from studenttest where stdid=" . $_SESSION['stdid'] . " and testid=" . $_SESSION['testid'] . ") + INTERVAL (select duration from test where testid=" . $_SESSION['testid'] . ") MINUTE
DO update studenttest set correctlyanswered=(select count(*) from studentquestion as sq,question as q where sq.qnid=q.qnid and sq.testid=q.testid and sq.answered='answered' and sq.stdanswer=q.correctanswer and sq.stdid=" . $_SESSION['stdid'] . " and sq.testid=" . $_SESSION['testid'] . "),status='over' where stdid=" . $_SESSION['stdid'] . " and testid=" . $_SESSION['testid'] . "|"))
                        $_GLOBALS['message'] = "error" . mysql_error();
                    executeQuery("delimiter ;");*/
                    if (!executeQuery("insert into studenttest values(" . $_SESSION['stdid'] . "," . $_SESSION['testid'] . ",(select CURRENT_TIMESTAMP),date_add((select CURRENT_TIMESTAMP),INTERVAL (select duration from test where testid=" . $_SESSION['testid'] . ") MINUTE),0,'inprogress')"))
                        $_GLOBALS['message'] = "error" . mysql_error();
                    else {
                        while ($r = mysql_fetch_array($result)) {
                            if (!executeQuery("insert into studentquestion values(" . $_SESSION['stdid'] . "," . $_SESSION['testid'] . "," . $r['qnid'] . ",'unanswered',NULL)")) {
                                $_GLOBALS['message'] = "Failure while preparing questions for you.Try again";
                                $error = true;
                            }
                        }
                        if ($error == true) {
                      //      executeQuery("rollback;");
                        } else {
                            $result = executeQuery("select totalquestions,duration from test where testid=" . $_SESSION['testid'] . ";");
                            $r = mysql_fetch_array($result);
                            $_SESSION['tqn'] = htmlspecialchars_decode($r['totalquestions'], ENT_QUOTES);
                            $_SESSION['duration'] = htmlspecialchars_decode($r['duration'], ENT_QUOTES);
                            $result = executeQuery("select DATE_FORMAT(starttime,'%Y-%m-%d %H:%i:%s') as startt,DATE_FORMAT(endtime,'%Y-%m-%d %H:%i:%s') as endt from studenttest where testid=" . $_SESSION['testid'] . " and stdid=" . $_SESSION['stdid'] . ";");
                            $r = mysql_fetch_array($result);
                            $_SESSION['starttime'] = $r['startt'];
                            $_SESSION['endtime'] = $r['endt'];
                            $_SESSION['qn'] = 1;
                            header('Location: testconducter.php');
                        }
                    }
                }
            }
        } else {
            $display = true;
            $_GLOBALS['message'] = "You have entered an Invalid Test Code.Try again.";
        }
    } else {
        $display = true;
        $_GLOBALS['message'] = "Enter the Test Code First!";
    }
} else if (isset($_REQUEST['testcode'])) {
    //test code preparation
    if ($r = mysql_fetch_array($result = executeQuery("select testid from test where testname='" . htmlspecialchars($_REQUEST['testcode'], ENT_QUOTES) . "';"))) {
        $_SESSION['testname'] = $_REQUEST['testcode'];
        $_SESSION['testid'] = $r['testid'];
    }
} else if (isset($_REQUEST['savem'])) {
    //updating the modified values
    if (empty($_REQUEST['cname']) || empty($_REQUEST['password']) || empty($_REQUEST['email'])) {
        $_GLOBALS['message'] = "Some of the required Fields are Empty.Therefore Nothing is Updated";
    } else {
        $query = "update student set stdname='" . htmlspecialchars($_REQUEST['cname'], ENT_QUOTES) . "', stdpassword=ENCODE('" . htmlspecialchars($_REQUEST['password'], ENT_QUOTES) . "','oespass'),emailid='" . htmlspecialchars($_REQUEST['email'], ENT_QUOTES) . "',contactno='" . htmlspecialchars($_REQUEST['contactno'], ENT_QUOTES) . "',address='" . htmlspecialchars($_REQUEST['address'], ENT_QUOTES) . "',city='" . htmlspecialchars($_REQUEST['city'], ENT_QUOTES) . "',pincode='" . htmlspecialchars($_REQUEST['pin'], ENT_QUOTES) . "' where stdid='" . $_REQUEST['student'] . "';";
        if (!@executeQuery($query))
            $_GLOBALS['message'] = mysql_error();
        else
            $_GLOBALS['message'] = "Your Profile is Successfully Updated.";
    }
    closedb();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <title>OES-Offered Tests</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta http-equiv="CACHE-CONTROL" content="NO-CACHE"/>
        <meta http-equiv="PRAGMA" content="NO-CACHE"/>
        <meta name="ROBOTS" content="NONE"/>

        <link rel="stylesheet" type="text/css" href="onlineexamination.css"/>
        <script type="text/javascript" src="validate.js" ></script>
        <style type="text/css">
<!--
.style1 {
	font-size: 36px;
	font-weight: bold;
	font-style: italic;
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
  <body><!----onload="MM_preloadImages('../../../../../Users/HIFZA/Documents/Unnamed Site 5/logo4.jpg','images/logo4.jpg')"><!---->
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  
    
  <table width="1237" height="248" border="0">
    <tr>
      <th width="268" height="194" scope="row"><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image1','','images/logo4.jpg',1)"><img src="images/cap2.jpg" width="262" height="192" border="0" id="Image1" /></a><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image1','','../../../../../Users/HIFZA/Documents/Unnamed Site 5/logo4.jpg',1)"></a><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image1','','file:///C|/Users/HIFZA/Documents/Unnamed Site 5/logo4.jpg',1)"></a></th>
      <td width="999" bgcolor="#9966FF"><div align="left" class="style7 style3"><span class="style1 style8"><strong>Online Examination System </strong></span></div></td>
    </tr>
	<tr>
      <th height="48" colspan="2" bgcolor="#999900" scope="row"><div align="right">
        <form id="stdtest" action="stdtest.php" method="post">
                <div class="menubar">
                    <ul id="menu">
                        <?php
                        if (isset($_SESSION['stdname'])) {
                            // Navigations
                        ?>
                            <li><input type="submit" value="LogOut" name="logout" class="subbtn" title="Log Out"/></li>
                            <li><input type="submit" value="Home" name="dashboard" class="subbtn" title="Home"/></li>


                        </ul>
                    </div>
                    <div class="page">
                    <?php
                            if (isset($_REQUEST['testcode'])) {
                                echo "<div class=\"pmsg\" style=\"text-align:center;\">What is the Code of " . $_SESSION['testname'] . " ? </div>";
                            } else {
                                echo "<div class=\"pmsg\" style=\"text-align:center;\">Offered Tests</div>";
                            }
                    ?>
                    <?php
                            if (isset($_REQUEST['testcode']) || $display == true) {
                    ?>
    
        
    </tr>
  </table>
  <table width="1235" height="185" border="1">
    <tr>
      <th width="1252" height="179" scope="row"><table cellpadding="30" cellspacing="10">
                                    <tr>
                                        <td bgcolor="#CC99FF">Enter Test Code</td>
                                        <td bgcolor="#CC99FF"><input type="text" tabindex="1" name="tc" value="" size="16" /></td>
                                        <td bgcolor="#CC99FF"><div class="help"><b>Note:</b><br/>Once you press start test<br/>button timer will be started</div></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" bgcolor="#CC99FF">
                                            <input type="submit" tabindex="3" value="Start Test" name="starttest" class="subbtn" />
                                      </td>
                                    </tr>
      </table>&nbsp;</th>
	  
    </tr>
  </table>
     <?php
                            } else {
                                $result = executeQuery("select t.*,s.subname from test as t, subject as s where s.subid=t.subid and CURRENT_TIMESTAMP<t.testto and t.totalquestions=(select count(*) from question where testid=t.testid) and NOT EXISTS(select stdid,testid from studenttest where testid=t.testid and stdid=" . $_SESSION['stdid'] . ");");
                                if (mysql_num_rows($result) == 0) {
                                    echo"<h3 style=\"color:#0000cc;text-align:center;\">Sorry...! For this moment, You have not Offered to take any tests.</h3>";
                                } else {
                                    //editing components
                    ?>
  <table width="1237" border="1">
    <tr>
      <th height="22" scope="row"> 
                                    <table cellpadding="30" cellspacing="10" class="datatable">
                                        <tr>
                                            <th>Test Name</th>
                                            <th>Test Description</th>
                                            <th>Subject Name</th>
                                            <th>Duration</th>
                                            <th>Total Questions</th>
                                            <th>Take Test</th>
                                      
    </tr>

                          <?php
                                    while ($r = mysql_fetch_array($result)) {
                                        $i = $i + 1;
                                        if ($i % 2 == 0) {
                                            echo "<tr class=\"alt\">";
                                        } else {
                                            echo "<tr>";
                                        }
                                        echo "<td>" . htmlspecialchars_decode($r['testname'], ENT_QUOTES) . "</td><td>" . htmlspecialchars_decode($r['testdesc'], ENT_QUOTES) . "</td><td>" . htmlspecialchars_decode($r['subname'], ENT_QUOTES)
                                        . "</td><td>" . htmlspecialchars_decode($r['duration'], ENT_QUOTES) . "</td><td>" . htmlspecialchars_decode($r['totalquestions'], ENT_QUOTES) . "</td>"
                                        . "<td class=\"tddata\"><a title=\"Start Test\" href=\"stdtest.php?testcode=" . htmlspecialchars_decode($r['testname'], ENT_QUOTES) . "\"><img src=\"images/starttest.png\" height=\"30\" width=\"40\" alt=\"Start Test\" /></a></td></tr>";
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
			</th>
			</tr>
  <table width="1237" height="42" border="1">
    <tr>
      <th width="1227" bgcolor="#999966" scope="row">&nbsp;</th>
    </tr>
  </table>
</body>
</html>

