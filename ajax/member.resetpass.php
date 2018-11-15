<?Php
$email = $_POST['email'];
if (empty($email))
	exit(json_encode(array('error' => true, 'msg' => 'ข้อมูลไม่ครบ')));
$arr_json = array();
include('../include/settings.php');
include(__Path__ . '/include/connect.php');
include(__Path__ . '/function/class.member.php');
$objMember = new MemberFunction($dbHandle);
if (!$objMember->ValiEmail($email)){
	$arr_json['error'] = true;
	$arr_json['msg'] = 'ส่งรหัสผ่านใหม่ไม่สำเร็จ, ' . $objMail->e;
}
if ($objMember->ResetPassword($email))
	$arr_json['error'] = false;
else{
	$arr_json['error'] = true;
	$arr_json['msg'] = 'ส่งรหัสผ่านใหม่ไม่สำเร็จ, ' . $objMember->e;
}
exit(json_encode($arr_json));