<?php

      error_reporting(0);
      session_start();
      include_once '../onlineexaminationdb.php';


      /***************************** Step 2 ****************************/
      if(isset($_REQUEST['admsubmit']))
      {
          
         $result=executeQuery("select * from adminlogin where admname='".htmlspecialchars($_REQUEST['name'],ENT_QUOTES)."' and admpassword='".htmlspecialchars($_REQUEST['password'],ENT_QUOTES)."'");
        
        
         // $result=mysql_query("select * from adminlogin where admname='".htmlspecialchars($_REQUEST['name'])."' and admpassword='".md5(htmlspecialchars($_REQUEST['password']))."'");
          if(mysql_num_rows($result)>0)
          {
              
              $r=mysql_fetch_array($result);
              if(strcmp($r['admpassword'],(htmlspecialchars($_REQUEST['password'],ENT_QUOTES)))==0)
              {
                  $_SESSION['admname']=htmlspecialchars_decode($r['admname'],ENT_QUOTES);
				  $_SESSION['admid']=$r['admid'];
                  unset($_GLOBALS['message']);
                  header('Location: admwelcome.php');
              }else
          {
             $_GLOBALS['message']="Check Your user name and Password.";
                 
          }

          }
          else
          {
              $_GLOBALS['message']="Check Your user name and Password.";
              
          }
          closedb();
      }
 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <title>Administrator Login</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <link rel="stylesheet" type="text/css" href="../onlineexamination.css"/>
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
    <style type="text/css">
<!--
.style2 {
	font-size: 36px;
	font-weight: bold;
	font-style: italic;
	color: #FFFFFF;
	font-family: Georgia, "Times New Roman", Times, serif;
}
.style3 {font-family: Georgia, "Times New Roman", Times, serif}
-->
    </style>
</head>
  <body onload="MM_preloadImages('file:///C|/Users/HIFZA/Documents/Unnamed Site 5/logo4.jpg','../../../../../Users/MY/Desktop/pro/oes/images/logo4.jpg','../../../../../Users/HIFZA/Documents/Unnamed Site 5/logo4.jpg')">
  </head>
  <body>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  
    
  <table width="1192" height="207" border="0">
    <tr>
      <th width="272" height="153" scope="row"><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image1','','file:///C|/Users/HIFZA/Documents/Unnamed Site 5/logo4.jpg',1)"></a><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image1','','../../../../../Users/MY/Desktop/pro/oes/images/logo4.jpg',1)"></a><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image1','','images/logo4.jpg',1)"></a><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image1','','images/logo4.jpg',1)"><img src="images/cap2.jpg" width="262" height="192" border="0" id="Image1" /></a></th>
      <td width="910" bgcolor="#9966FF"><div align="left" class="style7"><strong><span class="style8 style2">Online Examination System </span></strong></div></td>
    </tr>
    <tr>
      <th height="48" colspan="2" bgcolor="#999900" scope="row">&nbsp;</th>
    </tr>
  </table>
<form id="indexform1" action="index.php" method="post">
  <table width="1194" height="178" border="0">
    <tr>
      <th width="1184" height="172" scope="row"><table cellpadding="30" cellspacing="10">
              <tr>
                  <td bgcolor="#FFFFFF"><div align="center"><span class="style3">Admin Name</span></div></td>
                  <td bgcolor="#FFFFFF"><div align="center">
                    <input type="text" name="name" value="" size="16" />
                </div></td>
              </tr>
              <tr>
                  <td bgcolor="#FFFFFF"><div align="center"><span class="style3"> Password</span></div></td>
                  <td bgcolor="#FFFFFF"><div align="center">
                    <input type="password" name="password" value="" size="16" />
                </div></td>
              </tr>

              <tr bgcolor="#CC99FF">
                  <td colspan="2" bgcolor="#FFFFFF">
                    <div align="center">
                      <input type="submit" value="Log In" name="admsubmit" class="subbtn" />
                    </div></td><td></td>
        </tr>
      </table>
       </th>
    </tr>
  </table>
  <table width="1195" height="44" border="0">
    <tr>
      <th bgcolor="#999966" scope="row">&nbsp;</th>
    </tr>
  </table>
</body>
</html>
