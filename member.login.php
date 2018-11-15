<?Php
$email = $_POST['email'];
$password = $_POST['password'];
$rememberme = ($_POST['rememberme'] == 1 ? true : false);
if (empty($email) or empty($password))
	exit(json_encode(array('error' => true, 'msg' => 'ข้อมูลไม่ครบ')));
$arr_json = array();
include('include/settings.php');
include(__Path__ . '/include/connect.php');
include(__Path__ . '/function/class.member.php');
$objMember = new MemberFunction($dbHandle);
if ($objMember->ValiEmail($email) == false){
	$arr_json['error'] = true;
	$arr_json['msg'] = 'เข้าสู่ระบบไม่สำเร็จ, ' . $objMail->e;
}
$Session = $objMember->Login($email, $password, $rememberme);
if ($Session != false){
	setcookie('_login_key', $Session['key'], $Session['timeout']);
	setcookie('_login_toket', $Session['toket'], $Session['timeout']);
	$arr_json['error'] = false;
}else{
	$arr_json['error'] = true;
	$arr_json['msg'] = 'เข้าสู่ระบบไม่สำเร็จ, ' . $objMember->e;
}
exit(json_encode($arr_json));