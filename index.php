<?php
error_reporting(0);
      session_start();
      include_once 'onlineexaminationdb.php';
/***************************** Step 1 : Case 1 ****************************/

      if(isset($_REQUEST['registeration']))
      {
	     //redirect to registration page
            header('Location: registeration.php');
      }
	  
      else if($_REQUEST['stdsubmit'])
      {
/***************************** Step 1 : Case 2 ****************************/
 //Perform Authentication
          $result=executeQuery("select *,DECODE(stdpassword,'oespass') as std from student where stdname='".htmlspecialchars($_REQUEST['name'],ENT_QUOTES)."' and stdpassword=ENCODE('".htmlspecialchars($_REQUEST['password'],ENT_QUOTES)."','oespass')");
          if(mysql_num_rows($result)>0)
          {

              $r=mysql_fetch_array($result);
              if(strcmp(htmlspecialchars_decode($r['std'],ENT_QUOTES),(htmlspecialchars($_REQUEST['password'],ENT_QUOTES)))==0)
              {
                  $_SESSION['stdname']=htmlspecialchars_decode($r['stdname'],ENT_QUOTES);
                  $_SESSION['stdid']=$r['stdid'];
                  unset($_GLOBALS['message']);
                  header('Location: stdwelcome.php');
              }
			  
			  
			  else
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
    <link rel="stylesheet" type="text/css" href="onlineexamination.css"/>
    <style type="text/css">
<!--
.style2 {
	font-size: 36px;
	color: #FFFFFF;
	font-style: italic;
	font-weight: bold;
}
.style3 {font-family: Georgia, "Times New Roman", Times, serif}
.style4 {
	font-size: xx-large;
	font-style: italic;
	font-weight: bold;
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
  <body onload="MM_preloadImages('images/logo4.jpg','file:///C|/Users/HIFZA/Documents/Unnamed Site 5/logo4.jpg','../../../../../Users/HIFZA/Documents/Unnamed Site 5/logo4.jpg')">
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  
    
  <table width="1192" height="207" border="0">
    <tr>
      <th width="272" height="153" scope="row"><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image1','','file:///C|/Users/HIFZA/Documents/Unnamed Site 5/logo4.jpg',1)"></a><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image1','','../../../../../Users/MY/Desktop/pro/oes/images/logo4.jpg',1)"></a><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image1','','images/logo4.jpg',1)"></a><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image1','','images/logo4.jpg',1)"><img src="images/cap2.jpg" width="262" height="192" border="0" id="Image1" /></a></th>
      <td width="910" bgcolor="#9966FF"><div align="left" class="style7"><strong><span class="style8 style2">Online Examination System </span></strong></div></td>
    </tr>
    <tr>
      <th height="50" colspan="2" bgcolor="#999900" scope="row">
	  <div align="right"><td colspan="1" bgcolor="#FFFFFF">
        <div class="aclass"><a href="registeration.php" title="Click here to Register">Registeration</a></div>
      </div>
      </div>
	  </th>
    </tr>
  </table>
  <form id="stdloginform" action="index.php" method="post">
       <table width="1194" height="178" border="0">
    <tr>
      <th width="1184" height="172" bgcolor="#F0F0F0" scope="row"><table cellpadding="30" cellspacing="10">
              <tr>
                 <td bgcolor="#FFFFFF">User Name</td>
                 <td bgcolor="#FFFFFF"><input type="text" tabindex="1" name="name" value="" size="16" /></td>
          </tr>
               <tr>
                 <td height="30" bgcolor="#FFFFFF">Password</td>
                 <td bgcolor="#FFFFFF"><input type="password" tabindex="2" name="password" value="" size="16" /></td>
               </tr>
               <tr>
                 <td colspan="2" bgcolor="#FFFFFF"><input type="submit" tabindex="3" value="Log In" name="stdsubmit" class="subbtn" /></td>
               </tr>
             </table>
      </th>
    </table>
</div>
	   </div>
  </form>
<table width="1195" height="44" border="0">
    <tr>
      <th bgcolor="#999966" scope="row">&nbsp;</th>
    </tr>
  </table>
  
        
      
     
	  
</body>
</html>

