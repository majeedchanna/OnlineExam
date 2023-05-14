<?php
error_reporting(0);
session_start();
        if(!isset($_SESSION['stdname']))
		{
            $_GLOBALS['message']="Session Timeout.Click here to <a href=\'index.php\'>Re-LogIn</a>";
		}	
		else if(isset($_REQUEST['logout']))
		 {
    //Log out and redirect login page
        unset($_SESSION['stdname']);
        header('Location: index.php');
        }    
    else if(isset($_REQUEST['viewresult'])) {
        //redirect to viewresult
            header('Location: viewresult.php');

        }	
        else if(isset($_REQUEST['stdtest'])) {
        //redirect to viewresult
            header('Location: stdtest.php');

        }	
        
		else if(isset($_REQUEST['editpro'])) {
        //redirect to viewresult
            header('Location: editprofile.php');

        }	
        
		
		else if(isset($_REQUEST['resumetest'])) {
        //redirect to viewresult
            header('Location: resumetest.php');

        }	
       
?>
<html>
    <head>
        <title>Student(s) HomePage</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link rel="stylesheet" type="text/css" href="onlineexamination.css"/>
        <style type="text/css">
<!--
.style1 {
	font-size: 36px;
	font-style: italic;
	font-weight: bold;
	color: #FFFFFF;
	font-family: Georgia, "Times New Roman", Times, serif;
}
a:link {
	color: #6600CC;
}
a:visited {
	color: #000000;
}
a:hover {
	color: #336600;
}
a:active {
	color: #CCCCCC;
}
.style7 {color: #6600CC}
.style8 {
	font-weight: bold;
	font-family: Georgia, "Times New Roman", Times, serif;
}
-->
        </style>
        <script type="text/JavaScript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() 
{ //v3.0
  var d=document; 
  if(d.images)
  { 
  if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; 
	for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0)
	{ 
	d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];
	}
}
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
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  
    
  <table width="1153" height="310" border="0">
    <tr>
      <th width="261" height="197" scope="row"><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image1','','file:///C|/Users/HIFZA/Documents/Unnamed Site 5/logo4.jpg',1)"></a><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image2','','images/logo4.jpg',1)"><img src="images/cap2.jpg" name="Image2" width="262" height="192" border="0"></a><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image1','','images/logo4.jpg',1)"></a></th>
      <td width="882" bgcolor="#9966FF"><div align="left" class="style1">Online Examination System </div></td>
    </tr>
    <tr>
     
			
                      <td height="103" colspan="2" bgcolor="#999900"></ul>
                        <div align="right">
                <form name="stdwelcome" action="stdwelcome.php" method="post">
                    <ul id="menu">
                        <?php if(isset($_SESSION['stdname'])) ?>
                        <input type="submit" value="LogOut" name="logout" class="subbtn" title="Log Out" /></li>
						<input type="submit" value="ViewResult" name="viewresult" class="subbtn" title="ViewResult" />
						<input type="submit" value="StudentTtest" name="stdtest" class="subbtn" title="StudentTtest" />
						<input type="submit" value="EditProfile" name="editpro" class="subbtn" title="EditProfile" />
						
						<input type="submit" value="ResumeTest" name="resumetest" class="subbtn" title="ResumeTest" />						
					
                          <!----<p><span class="style8"><a href="viewResult.php">View result</a>,<a href="stdtest.php">Student Test</a>,<a href="editprofile.php">Edit Profile</a><a href="practicetest.php">,<span class="style7">Practice Test</span></a>,<a href="resumetest.php">Resume Test</a></span>
                            <input type="submit" value="LogOut" name="logout" class="subbtn" title="Log Out" />
                          </p>
                        </div>
					</tr><!---->
					<table>
					</table>
					
                     
      </form>
	  </div>
	  </th>
    </tr>
  </table>
    <table width="1156" height="44" border="1">
      <tr>
        <th width="1146" bgcolor="#999966" scope="row"><p>&nbsp;</p>
        <p>&nbsp;</p></th>
      </tr>
    </table>
  </body>
</html>
