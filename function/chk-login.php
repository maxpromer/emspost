<?Php
$login_key = $_COOKIE['_login_key'];
$login_toket = $_COOKIE['_login_toket'];
include(__Path__ . '/function/class.member.php');
$objMember = new MemberFunction($dbHandle);
global $login_uid;
$login_uid = $objMember->CheckLogin($login_key, $login_toket);
global $login;
$login = ($login_uid ? true : false);
if (!$login){
	setcookie('_login_key');
	setcookie('_login_toket');
}
global $MemberDetail;
$MemberDetail = $objMember->GetDetailByID($login_uid);