<?Php
$id = $_POST['id'];
if (empty($id))
	exit(json_encode(array('error' => true, 'msg' => 'ข้อมูลไม่ครบ')));
$arr_json = array();
include('../include/settings.php');
include(__Path__ . '/include/connect.php');
include(__Path__ . '/function/chk-login.php');
if (!$login)
	exit(json_encode(array('error' => true, 'msg' => 'กรุณาเข้าสู่ระบบ')));
include(__Path__ . '/function/class.ems.php');
$objEMS = new EMSFunction($dbHandle);
if ($objEMS->ExistEMSByID($login_uid, $id) == false)
	exit(json_encode(array('error' => true, 'msg' => 'ไม่มีอินว้อยนี้')));
if ($objEMS->Remove($id) == true)
	exit(json_encode(array('error' => false)));
else
	exit(json_encode(array('error' => true, 'msg' => $objOrder->e )));