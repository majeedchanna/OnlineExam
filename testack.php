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
   
     header('Location: stdwelcome.php');

}
if(isset($_SESSION['starttime']))
{
    unset($_SESSION['starttime']);
    unset($_SESSION['endtime']);
    unset($_SESSION['tqn']);
    unset($_SESSION['qn']);
    unset($_SESSION['duration']);
    executeQuery("update studenttest set status='over' where testid=".$_SESSION['testid']." and stdid=".$_SESSION['stdid'].";");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <title>OES-Test Acknowledgement</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <link rel="stylesheet" type="text/css" href="onlineexamination.css"/>
    <script type="text/javascript" src="validate.js" ></script>
    <style type="text/css">
<!--
.style1 {
	font-size: 36px;
	color: #FFFFFF;
	font-family: Georgia, "Times New Roman", Times, serif;
}
.style2 {color: #FFFFFF}
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
  </head> <body><!----onload="MM_preloadImages('images/logo4.jpg','../../../../../Users/HIFZA/Documents/Unnamed Site 5/logo4.jpg','file:///C|/Users/HIFZA/Documents/Unnamed Site 5/logo4.jpg')"><!---->
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  
    
      <table width="1239" height="248" border="0">
    <tr>
      <th width="268" height="194" scope="row"><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image1','','file:///C|/Users/HIFZA/Documents/Unnamed Site 5/logo4.jpg',1)"></a><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image1','','images/logo4.jpg',1)"><img src="images/cap2.jpg" width="262" height="192" border="0" id="Image1" /></a><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image1','','../../../../../Users/HIFZA/Documents/Unnamed Site 5/logo4.jpg',1)"></a><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image1','','images/logo4.jpg',1)"></a></th>
      <td width="983" bgcolor="#9966FF"><div align="left" class="style7"><em><span class="style8 style2 style1"><strong>Online Examination System </strong></span></em></div></td>
    </tr>
	<tr>
      <th height="48" colspan="2" bgcolor="#999900" scope="row"><div align="right">
    <form id="editprofile" action="editprofile.php" method="post">
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
          <h3 style="color:#0000cc;text-align:center;">Your answers are Successfully Submitted. To view the Results <b><a href="viewresult.php">Click Here</a></b> </h3>
          <?php
                        }
          ?>
      </div>

           </form>
		   </div>
		   </th>
		   </tr>
  </table>
    <table width="1236" height="42" border="1">
        <tr>
          <th bgcolor="#999966" scope="row">&nbsp;</th>
        </tr>
      </table>
  </body>
</html>

