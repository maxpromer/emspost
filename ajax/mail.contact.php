<?Php
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$title = $_POST['title'];
$msg = $_POST['msg'];
if (empty($name) or empty($email) or empty($phone) or empty($title) or empty($msg))
	exit(json_encode(array('error' => true, 'msg' => 'ข้อมูลไม่ครบ')));
if (!filter_var($email, FILTER_VALIDATE_EMAIL))
	exit(json_encode(array('error' => true, 'msg' => 'อีเมล์ไม่ถูกต้องตามรูปแบบ')));
include('../include/settings.php');
include(__Path__ . '/function/function.php');
include(__Path__ . '/function/recaptchalib.php');
$resp = recaptcha_check_answer( __reCaptchaPrivateKey__ , ClientIP(), $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
if (!$resp->is_valid)
	exit(json_encode(array('error' => true, 'msg' => 'รหัสป้องกันหุ่นยนต์ไม่ถูกต้อง, ' . $resp->error)));
$arr_json = array();
include(__Path__ . '/include/connect.php');
include(__Path__ . '/function/class.mail.php');
$objMail = new MailFunction($dbHandle);
if ($objMail->MailContact($name, $email, $phone, $title, $msg))
	$arr_json['error'] = false;
else{
	$arr_json['error'] = true;
	$arr_json['msg'] = 'การส่งเมล์ถึงเจ้าหน้าที่ไม่สำเร็จ, ' . $objMail->e;
}
exit(json_encode($arr_json));