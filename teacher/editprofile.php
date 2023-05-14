
<?php

error_reporting(0);
session_start();
include_once '../onlineexaminationdb.php';
/************************** Step 1 *************************/
if(!isset($_SESSION['tcname'])) {
    $_GLOBALS['message']="Session Timeout.Click here to <a href=\"index.php\">Re-LogIn</a>";
}
else if(isset($_REQUEST['logout']))
{
    /************************** Step 2 - Case 1 *************************/
    //Log out and redirect login page
    unset($_SESSION['tcname']);
    header('Location: index.php');

}
else if(isset($_REQUEST['dashboard'])){
     /************************** Step 2 - Case 2 *************************/
        //redirect to dashboard
     header('Location: tcwelcome.php');

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
     $query="update testconductor set tcname='".htmlspecialchars($_REQUEST['cname'],ENT_QUOTES)."', tcpassword=ENCODE('".htmlspecialchars($_REQUEST['password'],ENT_QUOTES)."','oespass'),emailid='".htmlspecialchars($_REQUEST['email'],ENT_QUOTES)."',contactno='".htmlspecialchars($_REQUEST['contactno'],ENT_QUOTES)."',address='".htmlspecialchars($_REQUEST['address'],ENT_QUOTES)."',city='".htmlspecialchars($_REQUEST['city'],ENT_QUOTES)."',pincode='".htmlspecialchars($_REQUEST['pin'],ENT_QUOTES)."' where tcid='".$_REQUEST['tc']."';";
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
    <link rel="stylesheet" type="text/css" href="../onlineexamination.css"/>
    <script type="text/javascript" src="../validate.js" ></script>
    <style type="text/css">
<!--
.style12 {font-family: Georgia, "Times New Roman", Times, serif; font-size: 18px; }
.style14 {
	font-size: 36px;
	font-family: Georgia, "Times New Roman", Times, serif;
	font-weight: bold;
	font-style: italic;
	color: #FFFFFF;
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
  <body> <!----onload="MM_preloadImages('../images/logo4.jpg')" ><!---->
         <?php

        if($_GLOBALS['message']) {
            echo "<div class=\"message\">".$_GLOBALS['message']."</div>";
        }
        ?>
       <table width="1192" height="207" border="0">
         <tr>
           <th width="272" height="153" scope="row"><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image1','','file:///C|/Users/HIFZA/Documents/Unnamed Site 5/logo4.jpg',1)"></a><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image2','','../images/logo4.jpg',1)"><img src="../images/cap2.jpg" width="262" height="192" border="0" id="Image2" /></a><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image1','','images/logo4.jpg',1)"></a></th>
           <td width="910" bgcolor="#9966FF"><div align="left"><span class="style14">Online Examination Syatem </span></div></td>
         </tr>
		 <form id="editprofile" action="editprofile.php" method="post">
          <div class="menubar">
               <ul id="menu">
                        <?php if(isset($_SESSION['tcname'])) {
                         // Navigations
                         ?>
                        <li><input type="submit" value="LogOut" name="logout" class="subbtn" title="Log Out"/></li>
                        <li><input type="submit" value="Home" name="dashboard" class="subbtn" title="Home"/></li>
                        <li><input type="submit" value="Save" name="savem" class="subbtn" onclick="validateform('editprofile')" title="Save the changes"/></li>
                     
               </ul>
          </div>
      <div class="page">
          <?php
                       
 /************************** Step 3 - Case 1 *************************/
        // Default Mode - Displays the saved information.
                        $result=executeQuery("select tcid,tcname,DECODE(tcpassword,'oespass') as tcpass ,emailid,contactno,address,city,pincode from testconductor where tcname='".$_SESSION['tcname']."';");
                        if(mysql_num_rows($result)==0) {
                           header('Location: tcwelcome.php');
                        }
                        else if($r=mysql_fetch_array($result))
                        {
                           //editing components
                 ?>
         <!----<tr>
           <th height="48" colspan="2" bgcolor="#999900" scope="row"><div align="right">
             <form id="form1" method="post" action="">
               <p>
                 <label>
                 <input type="submit" name="Submit22" value="Save" />
                   <input type="submit" name="Submit2" value="DashBoard" />
                   <input type="submit" name="Submit" value="LogOut" />
                 </label>
               </p>
             </form>
             </div></th>
         </tr><!---->
       </table>
       <table width="1192" height="368" border="0">
         <tr>
           <th width="1184" height="362" scope="row"><div align="center">
             <table cellpadding="20" cellspacing="20" style="text-align:left;margin-left:15em" >
               <tr>
                 <td bgcolor="#CC99FF"><span class="style12">User Name</span></td>
                 <td bgcolor="#CC99FF"><input name="cname" type="text" onkeyup="isalphanum(this)" value="<?php echo htmlspecialchars_decode($r['tcname'],ENT_QUOTES); ?>" size="16"/></td>
               </tr>
               <tr>
                 <td bgcolor="#CC99FF"><span class="style12">Password</span></td>
                 <td bgcolor="#CC99FF"><input name="password" type="password" onkeyup="isalphanum(this)" value="<?php echo htmlspecialchars_decode($r['tcpass'],ENT_QUOTES); ?>" size="16" /></td>
               </tr>
               <tr>
                 <td bgcolor="#CC99FF"><span class="style12">E-mail ID</span></td>
                 <td bgcolor="#CC99FF"><input name="email" type="text" value="<?php echo htmlspecialchars_decode($r['emailid'],ENT_QUOTES); ?>" size="16" /></td>
               </tr>
               <tr>
                 <td bgcolor="#CC99FF"><span class="style12">Contact No</span></td>
                 <td bgcolor="#CC99FF"><input name="contactno" type="text" onkeyup="isnum(this)" value="<?php echo htmlspecialchars_decode($r['contactno'],ENT_QUOTES); ?>" size="16"/></td>
               </tr>
               <tr>
                 <td bgcolor="#CC99FF"><span class="style12">Address</span></td>
                 <td bgcolor="#CC99FF"><span class="style12">
                   <textarea name="address" cols="20" rows="3"><?php echo htmlspecialchars_decode($r['address'],ENT_QUOTES); ?></textarea>
                 </span></td>
               </tr>
               <tr>
                 <td bgcolor="#CC99FF"><span class="style12">City</span></td>
                 <td bgcolor="#CC99FF"><input name="city" type="text" onkeyup="isalpha(this)" value="<?php echo htmlspecialchars_decode($r['city'],ENT_QUOTES); ?>" size="16"/></td>
               </tr>
               <tr>
                 <td bgcolor="#CC99FF"><span class="style12">PIN Code</span></td>
                 <td bgcolor="#CC99FF"><span class="style12">
                 <input type="hidden" name="tc" value="<?php echo $r['tcid']; ?>"/>
                 <input type="text" name="pin" value="<?php echo htmlspecialchars_decode($r['pincode'],ENT_QUOTES); ?>" size="16" onkeyup="isnum(this)" />
                 </span></td>
               </tr>
                        </table>
           </div></th>
         </tr>
       </table>
	    <?php
                        closedb();
                        }
                        
                        }
  ?>
      </div>

           </form>
       <table width="1191" height="47" border="0">
         <tr>
           <th height="41" bgcolor="#999966" scope="row">&nbsp;</th>
         </tr>
       </table>
       <p>&nbsp;             </p>
</body>
</html>

