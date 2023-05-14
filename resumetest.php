
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<?php
error_reporting(0);
session_start();
include_once 'onlineexaminationdb.php';
if(!isset($_SESSION['stdname'])) {
    $_GLOBALS['message']="Session Timeout.Click here to <a href=\"index.php\">Re-LogIn</a>";
}
else if(isset($_REQUEST['logout'])) {
    //Log out and redirect login page
        unset($_SESSION['stdname']);
        header('Location: index.php');

    }
    else if(isset($_REQUEST['dashboard'])) {
        //redirect to dashboard
            header('Location: stdwelcome.php');

        }
        else if(isset($_REQUEST['resume'])) {
            //test code preparation
                if($r=mysql_fetch_array($result=executeQuery("select testname from test where testid=".$_REQUEST['resume'].";"))) {
                    $_SESSION['testname']=htmlspecialchars_decode($r['testname'],ENT_QUOTES);
                    $_SESSION['testid']=$_REQUEST['resume'];
                }
            }
            else if(isset($_REQUEST['resumetest'])) {
                //Prepare the parameters needed for Test Conducter and redirect to test conducter
                    if(!empty($_REQUEST['tc'])) {
                        $result=executeQuery("select DECODE(testcode,'oespass') as tcode from test where testid=".$_SESSION['testid'].";");

                        if($r=mysql_fetch_array($result)) {
                            if(strcmp(htmlspecialchars_decode($r['tcode'],ENT_QUOTES),htmlspecialchars($_REQUEST['tc'],ENT_QUOTES))!=0) {
                                $display=true;
                                $_GLOBALS['message']="You have entered an Invalid Test Code.Try again.";
                            }
                            else {
                            //now prepare parameters for Test Conducter and redirect to it.

                                $result=executeQuery("select totalquestions,duration from test where testid=".$_SESSION['testid'].";");
                                $r=mysql_fetch_array($result);
                                $_SESSION['tqn']=htmlspecialchars_decode($r['totalquestions'],ENT_QUOTES);
                                $_SESSION['duration']=htmlspecialchars_decode($r['duration'],ENT_QUOTES);
                                $result=executeQuery("select DATE_FORMAT(starttime,'%Y-%m-%d %H:%i:%s') as startt,DATE_FORMAT(endtime,'%Y-%m-%d %H:%i:%s') as endt from studenttest where testid=".$_SESSION['testid']." and stdid=".$_SESSION['stdid'].";");
                                $r=mysql_fetch_array($result);
                                $_SESSION['starttime']=$r['startt'];
                                $_SESSION['endtime']=$r['endt'];
                                $_SESSION['qn']=1;
                                header('Location: testconducter.php');
                            }

                        }
                        else {
                            $display=true;
                            $_GLOBALS['message']="You have entered an Invalid Test Code.Try again.";
                        }
                    }
                    else {
                        $display=true;
                        $_GLOBALS['message']="Enter the Test Code First!";
                    }
                }
			?>

<html>
    <head>
        <title>OES-Resume Test</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta http-equiv="CACHE-CONTROL" content="NO-CACHE"/>
        <meta http-equiv="PRAGMA" content="NO-CACHE"/>
        <meta name="ROBOTS" content="NONE"/>

        <link rel="stylesheet" type="text/css" href="onlineexamination.css"/>
        <script type="text/javascript" src="validate.js" ></script>
        <style type="text/css">
<!--
.style2 {
	font-size: 36px;
	font-style: italic;
	color: #FFFFFF;
	font-family: Georgia, "Times New Roman", Times, serif;
}
-->
        </style>
        <script type="text/JavaScript">
<!--
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
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
  
    
      <table width="1239" height="248" border="0">
    <tr>
      <th width="268" height="194" scope="row"><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image1','','images/logo4.jpg',1)"><img src="images/cap2.jpg" width="262" height="192" border="0" id="Image1" /></a></th>
      <td width="983" bgcolor="#9966FF"><div align="left" class="style7"><em><span class="style8 style2"><strong>Online Examination System </strong></span></em></div></td>
    </tr>
    <tr>
      <th height="48" colspan="2" bgcolor="#999900" scope="row"><div align="right">
        <form id="summary" action="resumetest.php" method="post">
                <div class="menubar">
                    <ul id="menu">
        <?php if(isset($_SESSION['stdname'])) {
// Navigations
    ?>
                        <li><input type="submit" value="LogOut" name="logout" class="subbtn" title="Log Out"/></li>
                        <li><input type="submit" value="Home" name="dashboard" class="subbtn" title="Home"/></li>

                    </ul>


                </div>
                <div class="page">

    <?php
    if(isset($_REQUEST['resume'])) {
        echo "<div class=\"pmsg\" style=\"text-align:center;\">What is the Code of ".$_SESSION['testname']." ? </div>";
    }
    else {
        echo "<div class=\"pmsg\" style=\"text-align:center;\">Tests to be Resumed</div>";
    }
    ?>
                        <?php

                        if(isset($_REQUEST['resume'])|| $display==true) {
                            ?>
      </div></th>
    </tr>
  </table>
  <table width="1240" height="185" border="1">
    <tr>
      <th width="1255" height="179" scope="row"><table cellpadding="30" cellspacing="10">
        <tr>
          <td bgcolor="#CC99FF">Enter Test Code</td>
          <td bgcolor="#CC99FF"><input type="text" tabindex="1" name="tc" value="" size="16" /></td>
          <td bgcolor="#CC99FF"><div class="help"><b>Note:</b><br/>
            Quickly enter Test Code and<br/>
            press Resume button to utilize<br/>
          Remaining time.</div></td>
        </tr>
        <tr>
          <td colspan="3" bgcolor="#CC99FF"><input type="submit" tabindex="3" value="Resume Test" name="resumetest" class="subbtn" />          </td>
        </tr>
      </table></th>
    </tr>
  </table>
   <?php
    }
    else {

        $result=executeQuery("select t.testid,t.testname,DATE_FORMAT(st.starttime,'%d %M %Y %H:%i:%s') as startt,sub.subname as sname,TIMEDIFF(st.endtime,CURRENT_TIMESTAMP) as remainingtime from subject as sub,studenttest as st,test as t where sub.subid=t.subid and t.testid=st.testid and st.stdid=".$_SESSION['stdid']." and st.status='inprogress' order by st.starttime desc;");
        if(mysql_num_rows($result)==0) {
            echo"<h3 style=\"color:#0000cc;text-align:center;\">There are no incomplete exams, that needs to be resumed! Please Try Again..!</h3>";
        }
        else {
        //editing components
            ?>
   <table width="1240" border="1">
     <tr>
       <th height="36" scope="row">
                    <table width="95%" cellpadding="30" cellspacing="10" class="datatable">
                        <tr>
                            <th width="22%">Date and Time</th>
                            <th width="15%">Test</th>
                            <th width="16%">Subject</th>
                            <th width="30%">Remaining Time</th>
                            <th width="17%">Resume</th>
                        </tr>
						<?php
                                while($r=mysql_fetch_array($result)) {
                                    $i=$i+1;
                                    if($r['remainingtime']<0) {
                //IF Suppose MySQL Event fails for some reasons to change status this condtion becomes true.

                //   executeQuery("update studenttest set status='over' where stdid=".$_SESSION['stdid']." and testid=".$r['testid'].";");
                //      continue ;
                }

                if($i%2==0) {
                    echo "<tr class=\"alt\">";
                                        }
                                        else { echo "<tr>";}
                                        echo "<td>".$r['startt']."</td><td>".htmlspecialchars_decode($r['testname'],ENT_QUOTES)."</td><td>".htmlspecialchars_decode($r['sname'],ENT_QUOTES)."</td><td>".$r['remainingtime']."</td>";
                                        echo"<td class=\"tddata\"><a title=\"Resume\" href=\"resumetest.php?resume=".$r['testid']."\"><img src=\"images/resume.png\" height=\"30\" width=\"60\" alt=\"Resume\" /></a></td></tr>";
                                    }

                                    ?>

					</table>
					 <?php
                                }

                            }

                            closedb();
                        }
                        ?>
                        
                </div>

            </form>
		</th>
	 </tr>
	</table>
  <table width="1241" height="48" border="1">
    <tr>
      <th width="1231" height="42" bgcolor="#999966" scope="row"></th>
    </tr>
  </table>
</body>
</html>
    
