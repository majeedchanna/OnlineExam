<?php 
      error_reporting(0);
      session_start();
      include_once '../onlineexaminationdb.php';

      if(isset($_REQUEST['tcsubmit']))
      {
/***************************** Step 1 : Case 2 ****************************/
 //Perform Authentication
          $result=executeQuery("select *,DECODE(tcpassword,'oespass') as tc from testconductor where tcname='".htmlspecialchars($_REQUEST['name'],ENT_QUOTES)."' and tcpassword=ENCODE('".htmlspecialchars($_REQUEST['password'],ENT_QUOTES)."','oespass')");
          if(mysql_num_rows($result)>0)
          {

              $r=mysql_fetch_array($result);
              if(strcmp(htmlspecialchars_decode($r['tc'],ENT_QUOTES),(htmlspecialchars($_REQUEST['password'],ENT_QUOTES)))==0)
              {
                  $_SESSION['tcname']=htmlspecialchars_decode($r['tcname'],ENT_QUOTES);
                  $_SESSION['tcid']=$r['tcid'];
                  unset($_GLOBALS['message']);
                  header('Location: tcwelcome.php');
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
    <title>Online Examination System</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <link rel="stylesheet" type="text/css" href="../onlineexamination.css"/>
    <style type="text/css">
<!--
.style10 {font-family: Georgia, "Times New Roman", Times, serif; font-size: 18px; }
.style11 {
	font-family: Georgia, "Times New Roman", Times, serif;
	font-size: 36px;
	color: #FFFFFF;
	font-weight: bold;
	font-style: italic;
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
  <body onload="MM_preloadImages('file:///C|/Users/HIFZA/Documents/Unnamed Site 5/logo4.jpg','images/logo4.jpg','../images/logo4.jpg')">
      <p>
        <?php

        if(isset($_GLOBALS['message']))
        {
         echo "<div class=\"message\">".$_GLOBALS['message']."</div>";
        }
      ?>
      </p>
      <p>&nbsp; </p>
      <p>&nbsp;</p>
      <table width="1192" height="207" border="0">
        <tr>
          <th width="272" height="153" scope="row"><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image1','','file:///C|/Users/HIFZA/Documents/Unnamed Site 5/logo4.jpg',1)"></a><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image2','','../images/logo4.jpg',1)"><img src="../images/cap2.jpg" width="262" height="192" border="0" id="Image2" /></a><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image1','','images/logo4.jpg',1)"></a></th>
          <td width="910" bgcolor="#9966FF"><div align="left" class="style11">Online Examination System </div></td>
        </tr>
		<tr>
      <th height="48" colspan="2" bgcolor="#999900" scope="row">&nbsp;</th>
        </tr>
        <form id="tcloginform" action="index.php" method="post">
        
		<table width="1194" height="178" border="0">
    <tr>
      <th width="1184" height="172" scope="row"><table cellpadding="30" cellspacing="10">
      <div class="page">
      
           
              <tr>
                <td bgcolor="#FFFFFFF"><span class="style10">TC Name</span></td>
                <td bgcolor="#FFFFFFF"><input name="name" type="text" tabindex="1" value="" size="16" /></td>
              </tr>
              <tr>
                <td bgcolor="#FFFFFF"><span class="style10">Password</span></td>
                <td bgcolor="#FFFFFF"><input name="password" type="password" tabindex="2" value="" size="16" /></td>
              </tr>
              <tr>
                <td colspan="2" bgcolor="#FFFFFF"><input type="submit" tabindex="3" value="Log In" name="tcsubmit" class="subbtn" />                </td>
                </tr>
				</th>
              </tr>
            </table>
          </div></th>
        </tr>
      </table>
      <table width="1191" height="50" border="1">
        <tr>
          <td width="1181" height="44" bgcolor="#999966">&nbsp;</td>
        </tr>
      </table>
      <p>&nbsp;          </p>
</body>
</html>
