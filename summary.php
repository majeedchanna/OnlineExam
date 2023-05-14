<?php
error_reporting(0);
session_start();
include_once 'onlineexaminationdb.php';
if(!isset($_SESSION['stdname'])) {
    $_GLOBALS['message']="Session Timeout.Click here to <a href=\"index.php\">Re-LogIn</a>";
}
else if(isset($_REQUEST['logout']))
{
    //Log out and redirect login page
       unset($_SESSION['stdname']);
       header('Location: index.php');

}
else if(isset($_REQUEST['dashboard'])){
    //redirect to dashboard
    //
     header('Location: stdwelcome.php');

    }
    else if(isset($_REQUEST['change']))
    {
        //redirect to testconducter
       
       $_SESSION['qn']=substr($_REQUEST['change'],7);
       header('Location: testconducter.php');

    }
    else if(isset($_REQUEST['finalsubmit'])){
    //redirect to dashboard
    //
     header('Location: testack.php');

    }
     else if(isset($_REQUEST['fs'])){
    //redirect to dashboard
    //
     header('Location: testack.php');

    }

   
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>
  <head>
    <title>OES-Summary</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta http-equiv="CACHE-CONTROL" content="NO-CACHE"/>
    <meta http-equiv="PRAGMA" content="NO-CACHE"/>
    <meta name="ROBOTS" content="NONE"/>

    <link rel="stylesheet" type="text/css" href="onlineexamination.css"/>
    <script type="text/javascript" src="validate.js" ></script>
    <script type="text/javascript" src="cdtimer.js" ></script>
    <script type="text/javascript" >
<!--
<!--
        <?php
                $elapsed=time()-strtotime($_SESSION['starttime']);
                if(((int)$elapsed/60)<(int)$_SESSION['duration'])
                {
                    $result=executeQuery("select TIME_FORMAT(TIMEDIFF(endtime,CURRENT_TIMESTAMP),'%H') as hour,TIME_FORMAT(TIMEDIFF(endtime,CURRENT_TIMESTAMP),'%i') as min,TIME_FORMAT(TIMEDIFF(endtime,CURRENT_TIMESTAMP),'%s') as sec from studenttest where stdid=".$_SESSION['stdid']." and testid=".$_SESSION['testid'].";");
                    if($rslt=mysql_fetch_array($result))
                    {
                     echo "var hour=".$rslt['hour'].";";
                     echo "var min=".$rslt['min'].";";
                     echo "var sec=".$rslt['sec'].";";
                    }
                    else
                    {
                        $_GLOBALS['message']="Try Again";
                    }
                    closedb();
                }
                else
                {
                    echo "var sec=01;var min=00;var hour=00;";
                }
        ?>

    -->

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
    <style type="text/css">
<!--
.style1 {
	font-size: 36px;
	font-family: Georgia, "Times New Roman", Times, serif;
	color: #FFFFFF;
}
.style2 {font-family: Georgia, "Times New Roman", Times, serif}
.style4 {color: #000000}
-->
    </style>
</head>
  <body><!----onload="MM_preloadImages('images/logo4.jpg')"><!---->
  <p>&nbsp;</p>
  <p>&nbsp;</p>
   <?php

        if($_GLOBALS['message']) {
            echo "<div class=\"message\">".$_GLOBALS['message']."</div>";
        }
        ?>
    
      <table width="1239" height="248" border="0">
    <tr>
      <th width="268" height="194" scope="row"><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image1','','file:///C|/Users/HIFZA/Documents/Unnamed Site 5/logo4.jpg',1)"></a><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image1','','images/logo4.jpg',1)"><img src="images/cap2.jpg" width="262" height="192" border="0" id="Image1" /></a></th>
      <td width="983" bgcolor="#9966FF"><div align="left" class="style7"><em><span class="style8 style2 style1"><strong>Online Examination System </strong></span></em></div></td>
    </tr>
    <tr>
      <th height="48" colspan="2" bgcolor="#999900" scope="row"><div align="right">
        <form id="summary" action="summary.php" method="post">
          <div class="menubar">
              
                        <?php if(isset($_SESSION['stdname'])) {
                         // Navigations
                         ?>
              
          </div>
      <div class="page">
	  <table border="0" width="100%" class="ntab">
                  <tr>
                      <th style="width:40%;"><h3><span id="timer" class="timerclass"></span></h3></th>
                      
                  </tr>
              </table>
          <?php

                        $result=executeQuery("select * from studentquestion where testid=".$_SESSION['testid']." and stdid=".$_SESSION['stdid']." order by qnid ;");
                        if(mysql_num_rows($result)==0) {
                          echo"<h3 style=\"color:#0000cc;text-align:center;\">Please Try Again.</h3>";
                        }
                        else
                        {
                           //editing components
                 ?>
      
  
   
      <table width="1241" height="28" border="1">
        <tr>
          <th width="1231" height="22" scope="row">&nbsp;</th>
        </tr>
  </table> 
	   <table width="1242" border="1">
         <tr>
           <th scope="row">  <table width="110%" height="41" cellpadding="30" cellspacing="10" class="datatable">
                        <tr>
                            <th width="30%" bordercolor="#CC99FF" bgcolor="#CC99FF"><span class="style4">Question No</span></th>
                            <th width="19%" bordercolor="#CC99FF" bgcolor="#CC99FF"><span class="style4">Status</span></th>
                            <th width="51%" bordercolor="#CC99FF" bgcolor="#CC99FF"><span class="style4">Change Your Answer</span></th>
         </tr>
		   <?php
                        while($r=mysql_fetch_array($result)) {
                                    $i=$i+1;
                                    if($i%2==0)
                                    {
                                    echo "<tr class=\"alt\">";
                                    }
                                    else{ echo "<tr>";}
                                    echo "<td>".$r['qnid']."</td>";
                                    if(strcmp(htmlspecialchars_decode($r['answered'],ENT_QUOTES),"unanswered")==0 ||strcmp(htmlspecialchars_decode($r['answered'],ENT_QUOTES),"review")==0)
                                    {
                                        echo "<td style=\"color:#ff0000\">".htmlspecialchars_decode($r['answered'],ENT_QUOTES)."</td>";
                                    }
                                    else
                                    {
                                        echo "<td>".htmlspecialchars_decode($r['answered'],ENT_QUOTES)."</td>";
                                    }
                                    echo"<td><input type=\"submit\" value=\"Change ".$r['qnid']."\" name=\"change\" class=\"ssubbtn\" /></td></tr>";
                                }

                                ?>
              <tr>
                  <td colspan="3" style="text-align:center;"><input type="submit" name="finalsubmit" value="Final Submit" class="subbtn"/></td>
              </tr>
                    </table>
                            <?php
                            }
                            closedb();

         
                    }
                    ?>

      </div>

           </form>
		   </th>
		   </tr>
       <table width="1242" height="38" border="1">
         <tr>
           <th width="1232" bgcolor="#999966" scope="row">&nbsp;</th>
         </tr>
       </table>
</body>
</html>

