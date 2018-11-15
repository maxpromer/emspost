<?Php
$limit = 10;
$page = $_GET['page'];
if ((empty($page)) or (!number_format($page)))
	exit(json_encode(array('error' => true, 'msg' => 'ข้อมูลไม่ครบ')));
include('../include/settings.php');
include(__Path__ . '/include/connect.php');
include(__Path__ . '/function/chk-login.php');
if (!$login)
	exit(json_encode(array('error' => true, 'msg' => 'กรุณาเข้าสู่ระบบ')));
include(__Path__ . '/function/class.ems.php');
$objEMS = new EMSFunction($dbHandle);
$CountEMS = $objEMS->CountEMSForUid($login_uid);
if ($CountEMS == false)
	exit(json_encode(array('error' => true, 'msg' => "CountEMS Error: {$objOrder->e}" )));
$start = (($page - 1) * $limit);
$allpage = ceil($CountEMS/$limit);
if (($page < 1) or ($page > $allpage))
	exit(json_encode(array('error' => true, 'msg' => 'ตัวแปร Page ไม่ถูกต้อง')));
$AllEMS = $objEMS->AllEMSForUid($login_uid, $start, $limit);
if ($AllEMS == false)
	exit(json_encode(array('error' => true, 'msg' => $objOrder->e )));
$next = ((($page + 1) > $allpage) ? -1 : ($page + 1)); 
$return = array('error' => false, 'next' => $next);
include(__Path__ . '/function/function.php');
foreach ($AllEMS as $EMS){
	$lateststatus = $objEMS->LatestStatus($EMS['id']);
	$return['ems'][] = array(
		'id' => $EMS['id'],
		'barcode' => $EMS['barcode'],
		'lateststatus' => $lateststatus,
		'time' => fb_date(strtotime($EMS['time'])),
		'updata' => fb_date(strtotime($EMS['updata'])),
	);
}
exit(json_encode($return));