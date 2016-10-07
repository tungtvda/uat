<?
require($_SERVER['DOCUMENT_ROOT']."/lib/securecookie/class.securecookie.php");
$output .= 'Creating Object $C<br />';
$C = new SecureCookie('mysecretword','SomeCookie',time()+3600,'/','.mydomain.com');
$output .= 'settign test to hello<br />';
$C->Set('test','hello');
$output .= 'value of test is: ' . $C->Get('test') . '<br />';
$output .= 'setting test to bello<br />';
$C->Set('test','bello');
$output .= 'value of test is: ' . $C->Get('test') . '<br />';
$output .= 'setting test to dello<br />';
$C->Set('test','dello');
$output .= 'value of test is: ' . $C->Get('test') . '<br />';
$output .= 'deleting test<br />';
$C->Del('test');
$output .= 'value of test is: ' . $C->Get('test') . '<br />';
$output .= 'setting test2 to xello<br />';
$C->Set('test2','xello');
$output .= 'value of test2 is: ' . $C->Get('test2') . '<br />';
$output .= 'setting test3 to cello<br />';
$C->Set('test3','cello');
$output .= 'value of test is: ' . $C->Get('test3') . '<br />';
$output .= 'Creating a new object $C2 with a different password but same ID and accessing the cookie.<br />';
$C2 = new SecureCookie('mysecretwordx','SomeCookie',time()+3600,'/','.mydomain.com');
$output .= 'value of test2 using $C2 is: ' . $C2->Get('test2') . '<br />';
echo '<html><title>class.SecureCookie.php by Aikar</title><br />';
echo $output .'<br>';
echo '<b>CookieObject:</b><br /><pre>'.print_r($C->GetObject(),true) .
'</pre><br /><br /><b>Actual Cookie:</b><br><pre>'.$_COOKIE['SomeCookie'].'</pre><br /><br />';