<?php
error_reporting(0);
session_start();
include_once 'onlineexaminationdb.php';

if(isset($_REQUEST['stdsubmit']))
{
 /***************************** Step 1 : Case 1 ****************************/
 //Add the new user information in the database
     $result=executeQuery("select max(stdid) as std from student");
     $r=mysql_fetch_array($result);
     if(is_null($r['std']))
     $newstd=1;
     else
     $newstd=$r['std']+1;

     $result=executeQuery("select stdname as std from student where stdname='".htmlspecialchars($_REQUEST['cname'],ENT_QUOTES)."';");

    // $_GLOBALS['message']=$newstd;
    if(empty($_REQUEST['cname'])||empty ($_REQUEST['password'])||empty ($_REQUEST['email']))
    {
         $_GLOBALS['message']="Some of the required Fields are Empty";
    }else if(mysql_num_rows($result)>0)
    {
        $_GLOBALS['message']="Sorry the User Name is Not Available Try with Some Other name.";
    }
    else
    {
     $query="insert into student values($newstd,'".htmlspecialchars($_REQUEST['cname'],ENT_QUOTES)."',ENCODE('".htmlspecialchars($_REQUEST['password'],ENT_QUOTES)."','oespass'),'".htmlspecialchars($_REQUEST['email'],ENT_QUOTES)."','".htmlspecialchars($_REQUEST['contactno'],ENT_QUOTES)."','".htmlspecialchars($_REQUEST['address'],ENT_QUOTES)."','".htmlspecialchars($_REQUEST['city'],ENT_QUOTES)."','".htmlspecialchars($_REQUEST['pin'],ENT_QUOTES)."')";
     if(!@executeQuery($query))
                $_GLOBALS['message']=mysql_error();
     else
     {
        $success=true;
        $_GLOBALS['message']="Successfully Your Account is Created.Click <a href=\"index.php\">Here</a> to LogIn";
       // header('Location: index.php');
     }
    }
    closedb();
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <title>OES-Registration</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <link rel="stylesheet" type="text/css" href="onlineexamination.css"/>
    <script type="text/javascript" src="validate.js" ></script>
    <style type="text/css">
<!--
.style5 {
	font-size: 24px;
	color: #FFFFFF;
	font-weight: bold;
	font-family: Georgia, "Times New Roman", Times, serif;
}
.style7 {font-family: Georgia, "Times New Roman", Times, serif}
.style8 {font-size: 36px; font-weight: bold; font-style: italic; color: #FFFFFF;}
.style10 {color: #000000}
.style11 {color: #000000; font-family: verdana, arial, geneva; }
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
  <body>
  <?php

        if($_GLOBALS['message']) {
            echo "<div class=\"message\">".$_GLOBALS['message']."</div>";
        }
        ?>
  <p>&nbsp;</p>
   
  <table width="1192" height="207" border="0">
    <tr>
      <th width="272" height="153" scope="row"><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image1','','images/logo4.jpg',1)"><img src="images/cap2.jpg" width="262" height="192" border="0" id="Image1" /></a></th>
      <td width="910" bgcolor="#9966FF"><div align="left" class="style7"><span class="style8">Online Examination System </span></div></td>
    </tr>
	</div>
          
              <?php if(!$success): ?>

    <tr>
      <th height="48" colspan="2" bgcolor="#999900" scope="row"><span class="style5">New User Registeration </span></th>
    </tr>
	<?php endif; ?>
	          </div>
      <div class="page">
          <?php
          if($success)
          {
                echo "<h2 style=\"text-align:center;color:#0000ff;\">Thank You For Registering with Online Examination System.<br/><a href=\"index.php\">Login Now</a></h2>";
          }
          else
          {
           /***************************** Step 2 ****************************/
          ?>
          <form id="admloginform"  action="registeration.php" method="post" onsubmit="return validateform('admloginform');">
             
          </div>
  </table>
  
  
  <div align="left">
    <table width="1192" height="403" border="0">
      <tr>
        <th width="2" scope="row"><div align="left"></div></th>
        <td width="1174"><table width="498" cellpadding="20" cellspacing="20" style="text-align:left;margin-left:15em" >
          <tr>
            <td width="132" bgcolor="#FFFFFF"><span class="style10">User Name</span></td>
            <td width="224" bgcolor="#FFFFFF"><input type="text" name="cname" value="" size="16" onkeyup="isalphanum(this)"/></td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF"><div align="left" class="style10">Password</div></td>
            <td bgcolor="#FFFFFF"><input type="password" name="password" value="" size="16" onkeyup="isalphanum(this)" /></td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF"><span class="style10">Re-type Password</span></td>
            <td bgcolor="#FFFFFF"><input type="password" name="repass" value="" size="16" onkeyup="isalphanum(this)" /></td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF"><span class="style10">E-mail ID</span></td>
            <td bgcolor="#FFFFFF"><input type="text" name="email" value="" size="16" /></td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF"><span class="style10">Contact No</span></td>
            <td bgcolor="#FFFFFF"><input type="text" name="contactno" value="" size="16" onkeyup="isnum(this)"/></td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF"><span class="style10">Address</span></td>
            <td bgcolor="#FFFFFF"><textarea name="address" cols="20" rows="3"></textarea></td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF"><span class="style10">City</span></td>
            <td bgcolor="#FFFFFF"><input type="text" name="city" value="" size="16" onkeyup="isalpha(this)"/></td>
          </tr>
          <tr bgcolor="#CC99FF">
                  <td bgcolor="#FFFFFF">PIN Code</td>
            <td bgcolor="#FFFFFF"><input type="text" name="pin" value="" size="16" onkeyup="isnum(this)" /></td>
          </tr>
                       <tr>
                         <td bgcolor="#FFFFFF" style="text-align:right;"><input type="submit" name="stdsubmit" value="Register" class="subbtn" /></td>
                  <td bgcolor="#FFFFFF"><input type="reset" name="reset" value="Reset" class="subbtn"/></td>
              </tr>
		  </table>
      </tr>
    </table>
	</form>
	<?php } ?>
	
  </div>
    <table width="1197" height="55" border="1" bgcolor="#66CC66">
      <tr>
        <th width="1187" bordercolor="#000000" bgcolor="#999966" scope="row">&nbsp; </th>
      </tr>
    </table>  
    <p>&nbsp;</p>
</body>
</html>

