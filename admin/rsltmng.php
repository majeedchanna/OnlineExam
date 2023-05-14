
<?php
error_reporting(0);
session_start();
include_once '../onlineexaminationdb.php';
/************************** Step 1 *************************/
if(!isset($_SESSION['admname'])) {
    $_GLOBALS['message']="Session Timeout.Click here to <a href=\"index.php\">Re-LogIn</a>";
}
else if(isset($_REQUEST['logout'])) {
    /************************** Step 2 - Case 1 *************************/
    //Log out and redirect login page
        unset($_SESSION['admname']);
        header('Location: index.php');

    }
    else if(isset($_REQUEST['dashboard'])) {
    /************************** Step 2 - Case 2 *************************/
        //redirect to dashboard
            header('Location: admwelcome.php');

        }
        else if(isset($_REQUEST['back'])) {
    /************************** Step 2 - Case 3s *************************/
            //redirect to Result Management
                header('Location: rsltmng.php');

            }

?>
<html>
    <head>
        <title>OES-Manage Results</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link rel="stylesheet" type="text/css" href="../onlineexamination.css"/>

        <style type="text/css">
<!--
.style1 {
	color: #FFFFFF;
	font-size: 36px;
	font-family: Georgia, "Times New Roman", Times, serif;
	font-weight: bold;
	font-style: italic;
}
.style2 {color: #990033}
.style3 {font-family: Georgia, "Times New Roman", Times, serif}
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
         <body>
        <?php

        if($_GLOBALS['message']) {
            echo "<div class=\"message\">".$_GLOBALS['message']."</div>";
        }
        ?>
        <p><table width="1192" height="207" border="0">
        <tr>
          <th width="272" height="153" scope="row"><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image1','','file:///C|/Users/HIFZA/Documents/Unnamed Site 5/logo4.jpg',1)"></a><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image1','','../images/logo4.jpg',1)"><img src="../images/cap2.jpg" name="Image1" width="262" height="192" border="0"></a><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image2','','../images/logo4.jpg',1)"></a><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image1','','images/logo4.jpg',1)"></a></th>
          <td width="910" bgcolor="#9966FF"><div align="left" class="style11 style1">Online Examination System </div></td>
        </tr>
		<th height="48" colspan="2" bgcolor="#999900" scope="row"><div align="right">
		<form name="rsltmng" action="rsltmng.php" method="post">
                <div class="menubar">


                    <ul id="menu">
                        <?php if(isset($_SESSION['admname'])) {
                        // Navigations

                            ?>
                        <li><input type="submit" value="LogOut" name="logout" class="subbtn" title="Log Out"/></li>
                            <?php  if(isset($_REQUEST['testid'])) { ?>
                        <li><input type="submit" value="Back" name="back" class="subbtn" title="Manage Results"/></li>
                            <?php }else { ?>
                        <li><input type="submit" value="Home" name="dashboard" class="subbtn" title="Home"/></li>
                            <?php } ?>
                  </ul>
                </div>
                <div class="page">
                        <?php
                        if(isset($_REQUEST['testid'])) {
 /************************** Step 3 - Case 1 *************************/
 // Defualt Mode: Displays the Detailed Test Results.
                            $result=executeQuery("select t.testname,DATE_FORMAT(t.testfrom,'%d %M %Y') as fromdate,DATE_FORMAT(t.testto,'%d %M %Y %H:%i:%S') as todate,sub.subname,IFNULL((select sum(marks) from question where testid=".$_REQUEST['testid']."),0) as maxmarks from test as t, subject as sub where sub.subid=t.subid and t.testid=".$_REQUEST['testid'].";") ;
                            if(mysql_num_rows($result)!=0) {

                                $r=mysql_fetch_array($result);
                                ?>
        <!----<tr>
          <th height="48" colspan="2" bgcolor="#999900" scope="row"><div align="right">
            <input type="submit" name="Submit2" value="DashBoard" />
            <input type="submit" name="Submit22" value="Back" />
            <input type="submit" name="Submit" value="LogOut" />
          </div></th>
        </tr><!---->
      </table>
        <table width="1192" height="564" border="0">
          <tr>
            <th height="558" scope="row"><table width="565" border="0" cellpadding="20" cellspacing="30" style="background:#ffffff url(../images/page.gif);text-align:left;line-height:20px;">
              <tr bgcolor="#CC99FF">
                <td colspan="2"><h3 class="style3" style="color:#0000cc;text-align:center;">Test Summary</h3></td>
              </tr>
              <tr bgcolor="#CC99FF">
                <td colspan="2" ><hr class="style3" style="color:#ff0000;border-width:4px;"/></td>
              </tr>
              <tr bgcolor="#CC99FF">
                <td width="148"><span class="style3">Test Name</span></td>
                <td width="340"><span class="style3"><?php echo htmlspecialchars_decode($r['testname'],ENT_QUOTES); ?></span></td>
              </tr>
              <tr bgcolor="#CC99FF">
                <td><span class="style3">Subject Name</span></td>
                <td><span class="style3"><?php echo htmlspecialchars_decode($r['subname'],ENT_QUOTES); ?></span></td>
              </tr>
              <tr bgcolor="#CC99FF">
                <td><span class="style3">Validity</span></td>
                <td><span class="style3"><?php echo $r['fromdate']." To ".$r['todate']; ?></span></td>
              </tr>
              <tr bgcolor="#CC99FF">
                <td><span class="style3">Max. Marks</span></td>
                <td><span class="style3"><?php echo $r['maxmarks']; ?></span></td>
              </tr>
              <tr bgcolor="#CC99FF">
                <td colspan="2"><hr class="style3" style="color:#ff0000;border-width:2px;"/></td>
              </tr>
              <tr bgcolor="#CC99FF">
                <td colspan="2"><h3 class="style3" style="color:#0000cc;text-align:center;">Attempted Students</h3></td>
              </tr>
              <tr bgcolor="#CC99FF">
                <td height="40" colspan="2" ><hr class="style3" style="color:#ff0000;border-width:4px;"/></td>
              </tr>
            </table></th>
          </tr>
        </table>
		 <?php

                                $result1=executeQuery("select s.stdname,s.emailid,IFNULL((select sum(q.marks) from studentquestion as sq,question as q where q.qnid=sq.qnid and sq.testid=".$_REQUEST['testid']." and sq.stdid=st.stdid and sq.stdanswer=q.correctanswer),0) as om from studenttest as st, student as s where s.stdid=st.stdid and st.testid=".$_REQUEST['testid'].";" );

                                if(mysql_num_rows($result1)==0) {
                                    echo"<h3 style=\"color:#0000cc;text-align:center;\">No Students Yet Attempted this Test!</h3>";
                                }
                                else {
                                    ?>
       
                                    <table border="0" cellpadding="30" cellspacing="10" class="datatable">
                                        <tr>
                                            <th class="timerclass"><div align="center" class="style2">Student Name</div></th>
                                            <th class="timerclass"><div align="center" class="style2">Email-ID</div></th>
                                            <th class="timerclass"><div align="center" class="style2">Obtained Marks</div></th>
                                            <th class="timerclass"><div align="center" class="style2">Result(%)</div></th>
										</tr>
										
                                         <?php
                                        while($r1=mysql_fetch_array($result1)) {

                                            ?>
                        <tr>
                            <td><?php echo htmlspecialchars_decode($r1['stdname'],ENT_QUOTES); ?></td>
                            <td><?php echo htmlspecialchars_decode($r1['emailid'],ENT_QUOTES); ?></td>
                            <td><?php echo $r1['om']; ?></td>
                            <td><?php echo ($r1['om']/$r['maxmarks']*100)." %"; ?></td>


                        </tr>
                                        <?php
                                        
                                        }

                                    }
                                }
                                else {
                                    echo"<h3 style=\"color:#0000cc;text-align:center;\">Something went wrong. Please logout and Try again.</h3>";
                                }
                                ?>
                    </table>


                        <?php

                        }
                        else {
						// Defualt Mode: Displays the Test Results.
                            $result=executeQuery("select t.testid,t.testname,DATE_FORMAT(t.testfrom,'%d %M %Y') as fromdate,DATE_FORMAT(t.testto,'%d %M %Y %H:%i:%S') as todate,sub.subname,(select count(stdid) from studenttest where testid=t.testid) as attemptedstudents from test as t, subject as sub where sub.subid=t.subid;");
                            if(mysql_num_rows($result)==0) {
                                echo "<h3 style=\"color:#0000cc;text-align:center;\">No Tests Yet...!</h3>";
                            }
                            else {
                                $i=0;

                                ?>
                                    <table border="0" cellpadding="30" cellspacing="10" class="datatable">
                                        <tr>
                                            <th class="timerclass"><div align="center" class="style2">Test Name</div></th>
                                            <th class="timerclass"><div align="center" class="style2">Validity</div></th>
                                            <th class="timerclass"><div align="center" class="style2">Subject Name</div></th>
                                            <th class="timerclass"><div align="center" class="style2">Attempted Students</div></th>
                                            <th class="timerclass"><div align="center" class="style2">Details</div></th>
                                            
      </tr>
	  
    
	    <?php
                                    while($r=mysql_fetch_array($result)) {
                                        $i=$i+1;
                                        if($i%2==0) {
                                            echo "<tr class=\"alt\">";
                                        }
                                        else { echo "<tr>";}
                                        echo "<td>".htmlspecialchars_decode($r['testname'],ENT_QUOTES)."</td><td>".$r['fromdate']." To ".$r['todate']." PM </td>"
                                            ."<td>".htmlspecialchars_decode($r['subname'],ENT_QUOTES)."</td><td>".$r['attemptedstudents']."</td>"
                                            ."<td class=\"tddata\"><a title=\"Details\" href=\"rsltmng.php?testid=".$r['testid']."\"><img src=\"../images/detail.png\" height=\"30\" width=\"40\" alt=\"Details\" /></a></td></tr>";
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
              
                <table width="1189" border="0">
                  <tr>
                    <th width="1179" height="31" bgcolor="#999966" scope="row">&nbsp;</th>
                  </tr>
          </table>
               
              
</body>
</html>
