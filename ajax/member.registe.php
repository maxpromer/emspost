<?Php
$email = $_POST['email'];
$password = $_POST['password'];
$name = $_POST['name'];
$tel = $_POST['tel'];
if (empty($email) or empty($password) or empty($name) or empty($tel))
	exit(json_encode(array('error' => true, 'msg' => 'ข้อมูลไม่ครบ')));
$arr_json = array();
include('../include/settings.php');
include(__Path__ . '/include/connect.php');
include(__Path__ . '/function/class.member.php');
$objMember = new MemberFunction($dbHandle);
if ($objMember->Registe($email, $password, $name, $tel) == true)
	$arr_json['error'] = false;
else{
	$arr_json['error'] = true;
	$arr_json['msg'] = 'สมัครสมาชิกไม่สำเร็จ, ' . $objMember->e;
}
exit(json_encode($arr_json));