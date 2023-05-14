<?php

error_reporting(0);
session_start();
include_once 'onlineexaminationdb.php';
/************************** Step 1 *************************/
if(!isset($_SESSION['stdname'])) {
    $_GLOBALS['message']="Session Timeout.Click here to <a href=\"index.php\">Re-LogIn</a>";
}
else if(isset($_REQUEST['logout']))
{
    /************************** Step 2 - Case 1 *************************/
    //Log out and redirect login page
    unset($_SESSION['stdname']);
    header('Location: index.php');

}
else if(isset($_REQUEST['dashboard'])){
     /************************** Step 2 - Case 2 *************************/
        //redirect to dashboard    
		header('Location: stdwelcome.php');


    }else if(isset($_REQUEST['savem']))
{
      /************************** Step 2 - Case 3 *************************/
                //updating the modified values
    if(empty($_REQUEST['cname'])||empty ($_REQUEST['password'])||empty ($_REQUEST['email']))
    {
         $_GLOBALS['message']="Some of the required Fields are Empty.Therefore Nothing is Updated";
    }
    else
    {
     $query="update student set stdname='".htmlspecialchars($_REQUEST['cname'],ENT_QUOTES)."', stdpassword=ENCODE('".htmlspecialchars($_REQUEST['password'],ENT_QUOTES)."','oespass'),emailid='".htmlspecialchars($_REQUEST['email'],ENT_QUOTES)."',contactno='".htmlspecialchars($_REQUEST['contactno'],ENT_QUOTES)."',address='".htmlspecialchars($_REQUEST['address'],ENT_QUOTES)."',city='".htmlspecialchars($_REQUEST['city'],ENT_QUOTES)."',pincode='".htmlspecialchars($_REQUEST['pin'],ENT_QUOTES)."' where stdid='".$_REQUEST['student']."';";
     if(!@executeQuery($query))
        $_GLOBALS['message']=mysql_error();
     else
        $_GLOBALS['message']="Your Profile is Successfully Updated.";
    }
    closedb();

}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <title>OES-Edit Profile</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <link rel="stylesheet" type="text/css" href="onlineexamination.css"/>
    <script type="text/javascript" src="validate.js" ></script>
    <style type="text/css">
<!--
.style1 {
	font-size: 36px;
	color: #FFFFFF;
	font-weight: bold;
	font-style: italic;
	font-family: Georgia, "Times New Roman", Times, serif;
}
.style2 {color: #FFFFFF}
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
  <body> <!----onload="MM_preloadImages('images/logo4.jpg')"><!---->
   <?php

        if($_GLOBALS['message']) {
            echo "<div class=\"message\">".$_GLOBALS['message']."</div>";
        }
        ?>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  
    
  <table width="1192" height="207" border="0">
    <tr>
      <th width="272" height="153" scope="row"><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image1','','images/logo4.jpg',1)"><img src="images/cap2.jpg" width="262" height="192" border="0" id="Image1" /></a><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image1','','file:///C|/Users/HIFZA/Documents/Unnamed Site 5/logo4.jpg',1)"></a></th>
      <td width="910" bgcolor="#9966FF"><div align="left" class="style7"><strong><span class="style8 style2 style1">Online Examination System </span></strong></div></td>
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
                        <li><input type="submit" value="Save" name="savem" class="subbtn" onclick="validateform('editprofile1')" title="Save the changes"/></li>
                     
               </ul>
          </div>
      <div class="page">
           <?php
                       
 /************************** Step 3 - Case 1 *************************/
        // Default Mode - Displays the saved information.
                        $result=executeQuery("select stdid,stdname,DECODE(stdpassword,'oespass') as stdpass ,emailid,contactno,address,city,pincode from student where stdname='".$_SESSION['stdname']."';");
                        if(mysql_num_rows($result)==0) {
                           header('Location: stdwelcome.php');
                        }
                        else if($r=mysql_fetch_array($result))
                        {
                           //editing components
                 ?>
                       
        <!----<p>
            <label>
            <input type="submit" name="Submit3" value="Save" />
            <input type="submit" name="Submit2" value="DashBoard" />
              <input type="submit" name="Submit" value="LogOut" />
            </label>
          </p><!---->
       
        </div></th>
    </tr>
  </table>
  <table width="1198" height="390" border="1">
    <tr>
      <th scope="row"><table cellpadding="20" cellspacing="20" style="text-align:left;margin-left:15em" >
        <tr>
          <td bgcolor="#FFFFFF">User Name</td>
          <td bgcolor="#FFFFFF"><input type="text" name="cname" value="<?php echo htmlspecialchars_decode($r['stdname'],ENT_QUOTES); ?>" size="16" onkeyup="isalphanum(this)"/></td>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF">Password</td>
          <td bgcolor="#FFFFFF"><input type="password" name="password" value="<?php echo htmlspecialchars_decode($r['stdpass'],ENT_QUOTES); ?>" size="16" onkeyup="isalphanum(this)" /></td>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF">E-mail ID</td>
          <td bgcolor="#FFFFFF"><input type="text" name="email" value="<?php echo htmlspecialchars_decode($r['emailid'],ENT_QUOTES); ?>" size="16" /></td>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF">Contact No</td>
          <td bgcolor="#FFFFFF"><input type="text" name="contactno" value="<?php echo htmlspecialchars_decode($r['contactno'],ENT_QUOTES); ?>" size="16" onkeyup="isnum(this)"/></td>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF">Address</td>
          <td bgcolor="#FFFFFF"><textarea name="address" cols="20" rows="3"><?php echo htmlspecialchars_decode($r['address'],ENT_QUOTES); ?></textarea></td>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF">City</td>
          <td bgcolor="#FFFFFF"><input type="text" name="city" value="<?php echo htmlspecialchars_decode($r['city'],ENT_QUOTES); ?>" size="16" onkeyup="isalpha(this)"/></td>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF">PIN Code</td>
          <td bgcolor="#FFFFFF"><input type="hidden" name="student" value="<?php echo $r['stdid']; ?>"/>
          <input type="text" name="pin" value="<?php echo htmlspecialchars_decode($r['pincode'],ENT_QUOTES); ?>" size="16" onkeyup="isnum(this)" /></td>
        </tr>
      </table></th>
    </tr>
  </table>
  <?php
                        closedb();
                        }
                        
                        }
  ?>
      </div>

           </form>
		   </th>
		   </tr>
  <table width="1198" height="42" border="1">
    <tr>
      <th width="1188" bgcolor="#999966" scope="row">&nbsp;</th>
    </tr>
  </table>
</html>
