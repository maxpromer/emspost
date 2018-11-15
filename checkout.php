<?Php
session_start();
include('include/settings.php');
include(__Path__ . '/include/connect.php');
include(__Path__ . '/function/chk-login.php');
if (!$login){
	header('location: ./');
	exit();
}
include(__Path__ . '/function/class.order.php');
$objOrder = new OrderFunction($dbHandle);
if (isset($_POST['checkout'])){
	$invoice = $objOrder->TmpToOrderAndInvoice($login_uid, $_POST['note']);
	if ($invoice == false){
		exit($objOrder->e);
	}else{
		header("location: invoice.php?id={$invoice}&payment={$_POST['payment-id']}");
		exit();
	}
}
else
	ErrorPage();


function ErrorPage(){
	header('location: ./');
	exit();
}