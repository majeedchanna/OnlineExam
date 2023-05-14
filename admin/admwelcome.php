<?php

   error_reporting(0);
      /********************* Step 1 *****************************/
   session_start();
        if(!isset($_SESSION['admname'])){
            $_GLOBALS['message']="Session Timeout.Click here to <a href=\"index.php\">Re-LogIn</a>";
        }
        else if(isset($_REQUEST['logout'])){
           unset($_SESSION['admname']);
            $_GLOBALS['message']="You are Loggged Out Successfully.";
		//Log out and redirect login page
            header('Location: index.php');
        }
		else if(isset($_REQUEST['manageusers'])) {
        //redirect to manageusers
            header('Location: usermng.php');

        }	
        else if(isset($_REQUEST['managesubjects'])) {
        //redirect to managesubjects
            header('Location: submng.php');

        }	
        
		else if(isset($_REQUEST['mngtestresult'])) {
        //redirect to manageresult
            header('Location: rsltmng.php');

        }	
        
		else if(isset($_REQUEST['managetests'])) {
        //redirect to managetest
            header('Location: testmng.php');

        }	
        
		else if(isset($_REQUEST['prepquestions'])) {
        //redirect to prepquestion
            header('Location: prepqn.php?forpq=true');

        }	
       
?>

<html>
    <head>
        <title>Admin HomePage</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link rel="stylesheet" type="text/css" href="../onlineexamination.css"/>
        <style type="text/css">
<!--
.style2 {
	font-size: 36px;
	font-style: italic;
	color: #FFFFFF;
	font-family: Georgia, "Times New Roman", Times, serif;
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
    <body onLoad="MM_preloadImages('../../../../../Users/MY/Desktop/pro/oes/images/logo4.jpg','../../../../../Users/HIFZA/Documents/Unnamed Site 5/logo4.jpg','file:///C|/Users/HIFZA/Documents/Unnamed Site 5/logo4.jpg','file:///C|/wamp/www/project/onlineexam/images/logo4.jpg')">
       
          <?php
       /********************* Step 2 *****************************/
        if(isset($_GLOBALS['message'])) {
            echo "<div class=\"message\">".$_GLOBALS['message']."</div>";
        }
        ?> 
   
        <p>&nbsp;</p>
        <p><table width="1192" height="207" border="0"></p>
		
		
		<tr>
      <th width="272" height="153" bgcolor="#9966FF" scope="row"><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image1','','file:///C|/Users/HIFZA/Documents/Unnamed Site 5/logo4.jpg',1)"></a><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image1','','../../../../../Users/MY/Desktop/pro/oes/images/logo4.jpg',1)"></a><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image1','','images/logo4.jpg',1)"></a><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image1','','images/logo4.jpg',1)"><img src="images/cap2.jpg" width="262" height="192" border="0" id="Image1" /></a></th>
      <td width="910" bgcolor="#9966FF"><div align="left" class="style7"><strong><span class="style8 style2">Online Examination System </span></strong></div></td>
    </tr>
	<p>&nbsp;</p>
      <tr>
         	
                      <td height="103" colspan="2" bgcolor="#999900"></ul>
                        <div align="right">
                   
                <form name="admwelcome" action="admwelcome.php" method="post">
                    <ul id="menu">
                        <?php if(isset($_SESSION['admname'])) ?>
                        <li><input type="submit" value="LogOut" name="logout" class="subbtn" title="Log Out" /></li>
						<li><input type="submit" value="ManageUsers" name="manageusers" class="subbtn" title="ManageUsers" /></li>
						<li><input type="submit" value="ManageSubjects" name="managesubjects" class="subbtn" title="ManageSubjects" /></li>
						<li><input type="submit" value="ManageTestResult" name="mngtestresult" class="subbtn" title="ManageTestResult" /></li>
						<li><input type="submit" value="ManageTest" name="managetests" class="subbtn" title="ManageTest" /></li>
						<li><input type="submit" value="PrepareQuestions" name="prepquestions" class="subbtn" title="PrepareQuestions" /></li>
					
                          <!----<p><span class="style8"><a href="viewResult.php">View result</a>,<a href="stdtest.php">Student Test</a>,<a href="editprofile.php">Edit Profile</a><a href="practicetest.php">,<span class="style7">Practice Test</span></a>,<a href="resumetest.php">Resume Test</a></span>
                            <input type="submit" value="LogOut" name="logout" class="subbtn" title="Log Out" />
                          </p>
                        </div>
					</tr><!---->
					
					</ul>
				</form>
	                  </div>
					 </td> 
		  </div>
	  </th>
    </tr>
  </table>
  <table width="1192" height="44" border="1">
      <tr>
        <th width="1146" bgcolor="#999966" scope="row"><p>&nbsp;</p>
        <p>&nbsp;</p></th>
      </tr>
    </table>
		<!----<th height="48" colspan="2" bgcolor="#999900" scope="row"><div align="right">
           <div class="menubar">
                   
                <form name="admwelcome1" action="admwelcome1.php" method="post">
                    <ul id="menu">
                        ?php if(isset($_SESSION['admname'])){ ?>
						 <input type="submit" value="LogOut" name="logout" class="subbtn" title="Log Out"/>
                        
                        php } ?>
                    </ul>
				
	   
	      <tr>
	   <td height="103" colspan="2" bgcolor="#999900"></ul>
          <div align="right"><p><span class="style8"><a href="usermng1.php">Manage Users</a>,<a href="submng1.php">Manage Subjects</a>,<a href= "rsltmng1.php">Manage Test Results</a>,<a href="prepqn1.php?forpq=true">Prepare Questions</a>,<a href="testmng1.php">Manage Tests</a></span>
            
          </p>
		  </div>
		  
		  </tr>
	   
	
                
				</form>
				</div>
				</th><!---->
    </div>
</body>
</html>
