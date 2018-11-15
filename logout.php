<?Php
include('include/settings.php');
include(__Path__ . '/include/connect.php');
include(__Path__ . '/function/class.member.php');
$login_key = $_COOKIE['_login_key'];
$login_toket = $_COOKIE['_login_toket'];
$objMember = new MemberFunction($dbHandle);
$objMember->Logout($login_key, $login_toket);
setcookie('_login_key');
setcookie('_login_toket');
if (empty($_SERVER['HTTP_REFERER']) or strpos($_SERVER['HTTP_REFERER'], $_SERVER['REQUEST_URI']) === true)
	$location = './';
else
	$location = $_SERVER['HTTP_REFERER'];
header("location: {$location}");