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
$adderror = false;
if (!empty($_POST['plan'])){
	$planid = $_POST['plan'];
	if ($objOrder->AddTmpProducts($login_uid, $planid) == false)
		$adderror = true;
}
if (isset($_POST['refresh'])){
	foreach ($_POST['tmpdel'] as $tmporderid){
		if (!empty($tmporderid))
			$objOrder->RemoveTmpProducts($tmporderid, $login_uid);
	}
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>สั่งซื้อ</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="css/style.css">
<script src="js/jquery-2.0.2.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/app.js"></script>
<script src="js/jquery.print.js"></script>
</head>

<body data-spy="scroll" data-target="#affix-nav">
<div class="navbar navbar-default navbar-fixed-top">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="#">EMSPost</a>
  </div>
  <div class="navbar-collapse collapse navbar-responsive-collapse">
    <ul class="nav navbar-nav">
      <li><a href="./">หน้าแรก</a></li>
      <li><a href="plan.php">อัตราค่าบริการ</a></li>
      <li><a href="payments.php">การชำระเงิน</a></li>
      <li><a href="agreement.php">ข้อตกลง</a></li>
      <li><a href="contact.php">ติดต่อเรา</a></li>
      <li><a href="help.php">วิธีใช้</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
<?Php if ($login): ?>
      <li><a href="dashboard.php"><span class="glyphicon glyphicon-dashboard"></span> Dashboard</a></li>
<?Php endif ?>
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?Php echo ($login ? "{$MemberDetail['name']}" : 'สมาชิก'); ?> <b class="caret"></b></a>
        <ul class="dropdown-menu">
<?Php if (!$login): ?>
          <li><a href="#" data-toggle="modal" data-target="#LoginModal">เข้าสู่ระบบ</a></li>
          <li><a href="#" data-toggle="modal" data-target="#RepassModal">ลืมรหัสผ่าน</a></li>
          <li><a href="#" data-toggle="modal" data-target="#RegisterModal">สมัครสมาชิก</a></li>
<?Php else: ?>
          <li><a href="profile.php#edit-profile">แก้ไขข้อมูลส่วนตัว</a></li>
          <li><a href="profile.php#edit-password">แก้ไขรหัสผ่าน</a></li>
          <li class="divider"></li>
          <li><a href="logout.php">ออกจากระบบ</a></li>
<?Php endif ?>
        </ul>
      </li>
    </ul>
  </div>
</div>
<div class="container">
  <div class="row">
    <div class="col-lg-3">
      <nav id="affix-nav" class="sidebar visible-lg">
        <ul class="nav nav-pills nav-stacked" data-spy="affix" data-offset-top="10">
          <li class="active"><a href="#product">รายการสั่งซื้อ</a></li>
          <li><a href="#payment">ช่องทางการชำระเงิน</a></li>
          <li><a href="#msg">ข้อมูลเพิ่มเติม</a></li>
        </ul>
      </nav>
    </div>
    <div class="col-lg-9">
      <!-- Order Products -->
      <section id="product">
        <h1>รายการสั่งซื้อ</h1>
<?Php if ($adderror): ?>
        <div class="alert alert-danger"><strong>เพิ่มการสั่งซื้อไม่สำเร็จ!</strong> <?Php echo $objOrder->e; ?></div>
<?Php endif ?>
        <form action="" method="post" onSubmit="$(this).find(':submit').button('loading');">
          <table class="table table-striped">
            <thead>
              <tr>
                <th class="text-center" width="5%">ลบ</th>
                <th class="text-center" width="10%">ลำดับที่</th>
                <th width="75%">ชื่อแพ็คเกจ</th>
                <th class="text-center" width="10%">ราคา</th>
              </tr>
            </thead>
            <tbody>
<?Php
$allprice = 0;
$CountTmp = $objOrder->CountTmp($login_uid);
if ($CountTmp > 0){
	$GetAll = $objOrder->TmpAll($login_uid);
	include(__Path__ . '/function/class.plan.php');
	$objPlan = new PlanFunction($dbHandle);
	$i = 0;
	foreach ($GetAll as $TmpOrder){
		$PlanDetail = $objPlan->GetDetailByID($TmpOrder['planid']);
		$allprice += $PlanDetail['price'];
		$i++;
?>
              <tr>
                <td class="text-center"><input type="checkbox" name="tmpdel[]" value="<?Php echo $TmpOrder['id']; ?>"></td>
                <td class="text-center"><?Php echo $i; ?></td>
                <td><?Php echo $PlanDetail['name']; ?></td>
                <td class="text-center"><?Php echo number_format($PlanDetail['price']); ?> บาท</td>
              </tr>
<?Php } }else{ ?>
              <tr>
                <td class="text-center" colspan="4">คุณสามารถสั่งซื้อได้ที่หน้า <a href="plan.php">อัตตราค่าบริการ</a></td>
              </tr>
<?Php } ?>
            </tbody>
<?Php if ($CountTmp > 0): ?>
            <tfoot>
              <tr>
                <td rowspan="2" colspan="2" style="vertical-align:middle;" class="text-center"><button class="btn btn-danger btn-xs" name="refresh" id="refresh" type="submit" data-loading-text="<span class='glyphicon glyphicon-refresh rotate-infinite'></span> รอซักครู่..."><span class="glyphicon glyphicon-refresh"></span> ปรับปรุงรายการ</button></td>
                <td class="text-right">ราคารวม</td>
                <td class="text-center"><?Php echo number_format($allprice); ?> บาท</td>
              </tr>
              <tr>
                <td class="text-right">ภาษี VAT 7%</td>
                <td class="text-center">0 บาท</td>
              </tr>
              <tr>
                <td colspan="3" class="text-right">ชำระรวม</td>
                <td class="text-center"><?Php echo number_format($allprice); ?> บาท</td>
              </tr>
            </tfoot>
<?Php endif ?>
          </table>
        </form>
      </section>
      
      <form class="form-horizontal" action="checkout.php" method="post" onSubmit="$(this).find(':submit').button('loading');">
        <fieldset>
          <section id="payment">
            <h2 style="margin-top:0">ช่องทางการชำระเงิน</h2>
<?Php
include(__Path__ . '/function/class.payment.php');
$objPayment = new PaymentFunction($dbHandle);
$GetAll = $objPayment->GetAllName();
$first = true;
foreach ($GetAll as $Payment){
?>
            <div class="radio">
              <label>
                <input type="radio" name="payment-id" value="<?Php echo $Payment['id']; ?>"<?Php echo ($first == true ? ' checked' : ''); ?>> <?Php echo $Payment['name']; ?>

              </label>
            </div>
<?Php $first = false; } ?>
          </section>
          
          <section id="msg">
            <h2>ข้อมูลเพิ่มเติม</h2>
            <div class="form-group">
              <div class="col-sm-12">
                <textarea class="form-control" id="note" name="note" rows="4" placeholder="ข้อมูลเพิ่มเติมนี้ เจ้าหน้าที่จะได้รับต่อเมื่อมีการแจ้งชำระเงิน"></textarea>
              </div>
            </div>
          </section>
          
          <div class="form-group">
            <div class="col-sm-12 text-center">
              <button type="submit" class="btn btn-primary" name="checkout" id="checkout" data-loading-text="<span class='glyphicon glyphicon-refresh rotate-infinite'></span> รอซักครู่...">Checkout <span class="glyphicon glyphicon-circle-arrow-right"></span></button>
            </div>
          </div>
        </fieldset>
      </form>
    </div>
  </div>
</div>

<?Php include('template/modal.php'); ?>

<?Php include('template/footer.php'); ?>
</body>
</html>