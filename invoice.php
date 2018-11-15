<?Php
include('include/settings.php');
include(__Path__ . '/include/connect.php');
include(__Path__ . '/function/chk-login.php');
if (!$login){
	header('location: ./');
	exit();
}
include(__Path__ . '/function/class.order.php');
$objOrder = new OrderFunction($dbHandle);
$invoiceid = $_GET['id'];
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Invoice #<?Php echo $invoiceid; ?></title>
<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="css/style.css">
<script src="js/jquery-2.0.2.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/app.js"></script>
<script src="js/jquery.print.js"></script>
<style>
nav{
	width:100%;
}

nav > ul{
	display:table;
	margin:auto;
}

nav > ul > li{
	text-align:center;
	padding:5px 15px;
	float:left;
	list-style:none;
	font-size:12px;
}
</style>
</head>

<body style="background:#F1F1F1;color:#474747;margin:50px 0 20px 0;">
<?Php
if ($objOrder->ExistInvoiceByID($login_uid, $invoiceid) == true){
	$DetailInvoice = $objOrder->GetInvoiceDetailByID($invoiceid);
?>
<div class="box-invoice-1">
  <div class="box-invoice-2">
    <div class="box-invoice-3">
      <link rel="stylesheet" href="css/bootstrap.css">
      <link rel="stylesheet" href="css/style.css">
      <div class="page-header">
        <h1 class="text-center">ใบแจ้งค้างชำระค่าบริการ</h1>
      </div>
      <p><strong>ใบสั่งซื้อเลขที่:</strong> #<?Php echo $DetailInvoice['id']; ?></p>
      <p><strong>ออกเมื่อ:</strong> <?Php echo date('d/m/Y H:i:s', strtotime($DetailInvoice['date'])); ?></p>
      <p><strong>กำหนดชำระ:</strong> <?Php echo date('d/m/Y', strtotime($DetailInvoice['paydate'])); ?></p>
      <table width="100%">
        <tbody>
          <td width="50%" style="vertical-align:top; padding-right:10px;">
            <div class="panel panel-default">
              <div class="panel-heading"><h4 style="margin:0">ออกโดย</h4></div>
              <div class="panel-body">
                <p>นายสนธยา นงนุช</p>
                <p>64/2 หมู่ 1 ตำบล บางนาง อำเภอ พานทอง จังหวัด ชลบุรี 20160</p>
                <p>โทร. 084-1079779</p>
              </div>
            </div>
          </td>
          <td width="50%" style="vertical-align:top; padding-left:10px;">
            <div class="panel panel-default">
              <div class="panel-heading"><h4 style="margin:0">ออกให้</h4></div>
              <div class="panel-body">
                <p><?Php echo $MemberDetail['name']; ?></p>
                <p>โทร. <?Php echo $MemberDetail['tel']; ?></p>
              </div>
            </div>
          </td>
        </tbody>
      </table>
      <p><strong>รายการสั่งซื้อ</strong></p>
      <table class="table table-striped">
        <thead>
          <tr>
            <th class="text-center" width="10%">ลำดับที่</th>
            <th width="80%">ชื่อแพ็คเกจ</th>
            <th class="text-center" width="10%">ราคา</th>
          </tr>
        </thead>
        <tbody>
<?Php
	$GetOrder = $objOrder->AllOrderForInvoice($invoiceid);
	include(__Path__ . '/function/class.plan.php');
	$objPlan = new PlanFunction($dbHandle);
	$allprice = 0;
	$i = 0;
	foreach ($GetOrder as $Order){
		$PlanDetail = $objPlan->GetDetailByID($Order['planid']);
		$allprice += $PlanDetail['price'];
		$i++;
?>
              <tr>
                <td class="text-center"><?Php echo $i; ?></td>
                <td><?Php echo $PlanDetail['name']; ?></td>
                <td class="text-center"><?Php echo number_format($PlanDetail['price']); ?> บาท</td>
              </tr>
<?Php } ?>
        </tbody>
      </table>
      <div class="row">
        <div class="col-xs-offset-8 col-lg-4">
        <table class="table table-striped invoice-box-price">
          <tbody>
            <tr>
              <td class="text-right">ราคารวม</td>
              <td><?Php echo number_format($allprice); ?> บาท</td>
            </tr>
            <tr>
              <td class="text-right">ภาษี VAT 7%</td>
              <td>0 บาท</td>
            </tr>
            <tr>
              <td class="text-right">ชำระรวม</td>
              <td><?Php echo number_format($DetailInvoice['price']); ?> บาท</td>
            </tr>
          </tbody>
        </table>
        </div>
      </div>
      <footer>EMS Post By Host-1gb.com</footer>
    </div>
  </div>
</div>
<?Php }else{ ?>
<div class="alert alert-danger">ไม่มี Invoice นี้</div>
<?Php } ?>
<nav>
  <ul>
    <li><a href="billings.php"><span class="glyphicon glyphicon-circle-arrow-left"></span> รายการสั่งซื้อ</a></li>
    <li><a href="javascript:;" id="invoice-print"><span class="glyphicon glyphicon-print"></span> สั่งพิมพ์</a></li>
  </ul>
</nav>
</body>
</html>
