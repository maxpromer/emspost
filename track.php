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
<title>รายการแจ้งเตือนพัสดุ</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="css/style.css">
<script src="js/jquery-2.0.2.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/app.js"></script>
<script src="js/ems.barcode.js"></script>
<script src="js/jquery.form.min.js"></script>
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
          <li class="active"><a href="track.php">รายการแจ้งเตือนพัสดุ</a></li>
          <li><a href="billings.php">รายการสั่งซื้อ</a></li>
        </ul>
      </nav>
    </div>
    <div class="col-lg-9">
      <section>
        <h1>รายการแจ้งเตือนพัสดุ</h1>
<?Php
$a = $_GET['a'];
if ($a == 'add'):
?>
        <form class="form-horizontal" method="post" action="" id="ems-add">
          <fieldset>
            <legend>เพิ่มใหม่</legend>
            <div id="alert-return"></div>
            <div class="form-group">
              <label for="barcode" class="col-lg-2 control-label">หมายเลขพัสดุ</label>
              <div class="col-lg-3">
                <input type="text" class="form-control" id="barcode" name="barcode" pattern="^([A-Z]{2})([0-9]{9})([A-Z]{2})$" maxlength="13" placeholder="พัสดุลงทะเบียนหรือ EMS" title="กรุณากรอกหมายเลขพัสดุลงทะเบียนหรือ EMS เท่านั้น" required>
              </div>
            </div>
            <div class="form-group">
              <label for="alert" class="col-lg-2 control-label">การแจ้งสถานะ</label>
              <div class="col-lg-6">
                <div class="checkbox">
                  <label><input type="checkbox" id="alert-email" name="alert-email" value="1"> การแจ้งเตือนผ่านเมล์</label>
                </div>
                <div>
                  <input type="email" class="form-control" id="alert-email-address" name="alert-email-address" placeholder="ใช้เครื่องหมายลูกน้ำคั่นแต่ละอีเมล์" title="ใช้เครื่องหมายลูกน้ำคั่นแต่ละอีเมล์" disabled multiple required>
                </div>
                <div class="checkbox">
                  <label><input type="checkbox" id="alert-phone" name="alert-phone" value="1"> การแจ้งเตือนผ่าน SMS</label>
                </div>
                <div>
                  <input type="tel" class="form-control" id="alert-phone-sms" name="alert-phone-sms" placeholder="ใช้เครื่องหมายลูกน้ำคั่นแต่ละเบอร์โทรศัพท์" title="ใช้เครื่องหมายลูกน้ำคั่นแต่เบอร์โทรศัพท์" disabled multiple required>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-lg-10 col-lg-offset-2">
                 <button type="reset" class="btn btn-default btn-sm">ยกเลิก</button>
                 <button type="submit" class="btn btn-primary btn-sm" data-loading-text="<span class='glyphicon glyphicon-refresh rotate-infinite'></span> รอซักครู่..."><span class="glyphicon glyphicon-floppy-disk"></span> บันทึก</button>
              </div>
            </div>
          </fieldset>
        </form>
        <div id="box-return"></div>
        <form class="form-horizontal" id="add-ems-csv" action="ajax/ems.add.csv.php" method="post">
          <fieldset>
            <legend>เพิ่มใหม่ด้วยไฟล์ CSV</legend>
            <div id="alert-return"></div>
            <div class="alert alert-info">วิธีนี้ใช้ในกรณีมีจำนวนหมายเลขที่ต้องการให้แจ้งเตือนจำนวนมาก ไม่เหมาะที่จะเพิ่มทีละหมายเลข สามารถสร้างไฟล์ CSV แล้วนำมาอัพโหลดลงระบบได้ทันที สามารถอ่านวิธีสร้างไฟล์ CSV ได้ที่ <a href="#" target="_blank">ขั้นตอนการสร้างไฟล์ CSV</a></div>
            <div class="form-group">
              <label for="csv-file" class="col-lg-2 control-label">เลือกไฟล์ CSV</label>
              <div class="col-lg-3">
                <input type="file" id="csv-file" name="csv-file" required>
              </div>
            </div>
            <div class="form-group">
              <div class="col-lg-10 col-lg-offset-2">
                 <button type="reset" class="btn btn-default btn-sm">ยกเลิก</button>
                 <button type="submit" class="btn btn-primary btn-sm" data-loading-text="<span class='glyphicon glyphicon-refresh rotate-infinite'></span> รอซักครู่..."><span class="glyphicon glyphicon-floppy-disk"></span> บันทึก</button>
              </div>
            </div>
          </fieldset>
        </form>
<?Php else: ?>
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th class="text-center">#ID</th>
                <th class="text-center">รหัสพัสดุ</th>
                <th class="text-center">สถานะล่าสุด</th>
                <th class="text-center">สร้างเมื่อ</th>
                <th class="text-center">อัพเดท</th>
                <th class="text-center">ดำเนินการ</th>
              </tr>
            </thead>
            <tbody id="table-data">
<?Php
	include(__Path__ . '/function/function.php');
	include(__Path__ . '/function/class.ems.php');
	$objEMS = new EMSFunction($dbHandle);
	$CountEMS = $objEMS->CountEMSForUid($login_uid);
	$AllEMS = $objEMS->AllEMSForUid($login_uid, 0, 10);
	foreach ($AllEMS as $EMS){
		$lateststatus = $objEMS->LatestStatus($EMS['id']);
?>
              <tr>
                <td class="text-center" style="vertical-align:middle;">#<?Php echo $EMS['id']; ?></td>
                <td class="text-center" style="vertical-align:middle;"><?Php echo $EMS['barcode']; ?></td>
                <td class="text-center" style="vertical-align:middle;"><span class="label label-info"><?Php echo $lateststatus; ?></span></td>
                <td class="text-center" style="vertical-align:middle;"><?Php echo fb_date(strtotime($EMS['time'])); ?></td>
                <td class="text-center" style="vertical-align:middle;"><?Php echo fb_date(strtotime($EMS['updata'])); ?></td>
                <td class="text-center" style="vertical-align:middle;">
                  <a href="?a=detail&id=<?Php echo $EMS['id']; ?>" class="btn btn-info btn-xs">รายละเอียด</a>
                  <button class="btn btn-danger btn-xs" onClick="ems_del(<?Php echo $EMS['id']; ?>, $(this));" data-loading-text="<span class='glyphicon glyphicon-refresh rotate-infinite'></span> รอซักครู่..."><span class="glyphicon glyphicon-remove"></span> ยกเลิก</button>
                </td>
              </tr>
<?Php } ?>
            </tbody>
            <tfoot>
<?Php if ($CountEMS > 30): ?>
              <tr>
                <td colspan="6"><button id="page-load" class="btn btn-info btn-xs btn-block" data-loading-text="<span class='glyphicon glyphicon-refresh rotate-infinite'></span> รอซักครู่...">โหลดเพิ่ม</button></td>
              </tr>
<?Php endif ?>
              <tr>
                <td colspan="6" class="text-right"><a href="?a=add" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-plus"></span> เพิ่มใหม่</a></td>
              </tr>
          </table>
        </div>
<?Php endif ?>
      </section>
    </div>
  </div>
</div>

<?Php include('template/modal.php'); ?>

<?Php include('template/footer.php'); ?>
</body>
</html>