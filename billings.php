<?Php
include('include/settings.php');
include(__Path__ . '/include/connect.php');
include(__Path__ . '/function/chk-login.php');
if (!$login){
	header('location: ./');
	exit();
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>รายการสั่งซื้อ</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="css/style.css">
<script src="js/jquery-2.0.2.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/app.js"></script>
</head>

<body>
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
      <li class="active"><a href="dashboard.php"><span class="glyphicon glyphicon-dashboard"></span> Dashboard</a></li>
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
      <nav class="sidebar visible-lg">
        <ul class="nav nav-pills nav-stacked">
          <li><a href="dashboard.php">Dashboard</a></li>
          <li><a href="track.php">รายการแจ้งเตือนพัสดุ</a></li>
          <li class="active"><a href="billings.php">รายการสั่งซื้อ</a></li>
        </ul>
      </nav>
    </div>
    <div class="col-lg-9">
      <!-- Billing -->
      <section>
        <h1>รายการสั่งซื้อ</h1>
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th class="text-center">#ID</th>
                <th class="text-center">สถานะ</th>
                <th class="text-center">ชำระรวม</th>
                <th class="text-center">สร้างเมื่อ</th>
                <th class="text-center">กำหนดชำระ</th>
                <th class="text-center">ดำเนินการ</th>
              </tr>
            </thead>
            <tbody>
<?Php
include(__Path__ . '/function/function.php');
include(__Path__ . '/function/class.order.php');
$objOrder = new OrderFunction($dbHandle);
$AllInvoice = $objOrder->AllInvoiceForUid($login_uid);
foreach ($AllInvoice as $Invoice){
?>
              <tr>
                <td class="text-center" style="vertical-align:middle;">#<?Php echo $Invoice['id']; ?></td>
                <td class="text-center" style="vertical-align:middle;">...</td>
                <td class="text-center" style="vertical-align:middle;"><?Php echo $Invoice['price']; ?></td>
                <td class="text-center" style="vertical-align:middle;"><?Php echo fb_date(strtotime($Invoice['date'])); ?></td>
                <td class="text-center" style="vertical-align:middle;"><?Php echo date('d/m/Y', strtotime($Invoice['paydate'])); ?></td>
                <td class="text-center" style="vertical-align:middle;">
                  <a href="invoice.php?id=<?Php echo $Invoice['id']; ?>" class="btn btn-info btn-xs">รายละเอียด</a>
                  <button class="btn btn-danger btn-xs invoice-del" data-id="<?Php echo $Invoice['id']; ?>" data-loading-text="<span class='glyphicon glyphicon-refresh rotate-infinite'></span> รอซักครู่..."><span class="glyphicon glyphicon-remove"></span> ยกเลิก</button>
                </td>
              </tr>
<?Php } ?>
            </tbody>
            <tfoot>
              <tr>
                <td colspan="6" class="text-right"><a href="plan.php" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-plus"></span> สั่งซื้อใหม่</a></td>
              </tr>
          </table>
        </div>
      </section>
    </div>
  </div>
</div>

<?Php include('template/modal.php'); ?>

<?Php include('template/footer.php'); ?>
</body>
</html>