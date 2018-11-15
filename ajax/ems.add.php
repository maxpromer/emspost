<?Php
$barcode = $_POST['barcode'];
$arr_alert = array();
$arr_alert['email'] = ($_POST['alert-email'] == 1 ? true : false);
if ($arr_alert['email'] == true){
	$ex = explode(',', $_POST['alert-email-address']);
	foreach ($ex as $val){
		if (filter_var($val, FILTER_VALIDATE_EMAIL))
			$arr_alert['email-address'][] = $val;
	}
}
$arr_alert['phone'] = ($_POST['alert-phone'] == 1 ? true : false);
if ($arr_alert['phone'] == true){
	$ex = explode(',', $_POST['alert-phone-sms']);
	foreach ($ex as $val){
		$arr_alert['phone-sms'][] = $val;
	}
}
$json_alert = json_encode($arr_alert);
if (empty($barcode))
	exit(json_encode(array('error' => true, 'msg' => 'ข้อมูลไม่ครบ')));
include('../include/settings.php');
include(__Path__ . '/include/connect.php');
include(__Path__ . '/function/chk-login.php');
if (!$login)
	exit(json_encode(array('error' => true, 'msg' => 'กรุณาเข้าสู่ระบบ')));
include(__Path__ . '/function/class.ems.php');
$objEMS = new EMSFunction($dbHandle);
if ($objEMS->ExistEMSByBarcode($login_uid, $barcode) == true)
	exit(json_encode(array('error' => true, 'msg' => 'คุณเพิ่มหมายเลขพัสดุนี้แล้ว')));
if ($objEMS->Add($login_uid, $barcode, $json_alert) == true)
	exit(json_encode(array('error' => false)));
else
	exit(json_encode(array('error' => true, 'msg' => $objEMS->e )));