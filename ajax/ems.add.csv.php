<?Php
if(empty($_FILES['csv-file']['name']))
	exit(json_encode(array('error' => true, 'msg' => 'ข้อมูลไม่ครบ')));
$ext = pathinfo($_FILES['csv-file']['name'] , PATHINFO_EXTENSION);
$ext = strtolower($ext);
if ($ext != 'csv')
	exit(json_encode(array('error' => true, 'msg' => 'รองรับไฟล์ csv เท่านั้น')));
include('../include/settings.php');
include(__Path__ . '/include/connect.php');
include(__Path__ . '/function/chk-login.php');
if (!$login)
	exit(json_encode(array('error' => true, 'msg' => 'กรุณาเข้าสู่ระบบ')));
$csv = fopen($_FILES['csv-file']['tmp_name'], 'r');
$error = false;
$msg = '';
include(__Path__ . '/function/class.ems.php');
$objEMS = new EMSFunction($dbHandle);
while ($arr_csv = fgetcsv($csv)){
	if (!empty($arr_csv[0])){
		$arr_alert = array();
		$arr_alert['email'] = (!empty($arr_csv[1]) ? true : false);
		if (!empty($arr_csv[1])){
			$ex = explode(',', $arr_csv[1]);
			foreach ($ex as $val){
				if (filter_var($val, FILTER_VALIDATE_EMAIL))
					$arr_alert['email-address'][] = $val;
			}
		}
		$arr_alert['phone'] = (!empty($arr_csv[2]) ? true : false);
		if (!empty($arr_csv[2])){
			$ex = explode(',', $arr_csv[2]);
			foreach ($ex as $val){
				$arr_alert['phone-sms'][] = $val;
			}
		}
		$barcode = $arr_csv[0];
		$json_alert = json_encode($arr_alert);
		if ($objEMS->ExistEMSByBarcode($login_uid, $barcode) == true){
			$error = true;
			$msg .= ' คุณเพิ่มหมายเลขพัสดุ ' . $barcode . ' แล้ว';
		}else{
			if ($objEMS->Add($login_uid, $barcode, $json_alert) == false){
				$error = true;
				$msg .= ' ' . $barcode . ':' . $objEMS->e;
			}
		}
	}
}
exit(json_encode(array('error' => $error, 'msg' => $msg)));