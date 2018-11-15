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
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Dashboard</title>
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
          <li class="active"><a href="dashboard.php">Dashboard</a></li>
          <li><a href="track.php">รายการแจ้งเตือนพัสดุ</a></li>
          <li><a href="billings.php">รายการสั่งซื้อ</a></li>
        </ul>
      </nav>
    </div>
    <div class="col-lg-9">
      <!-- Dashboard< -->
      <section>
        <h1>Dashboard</h1>
        <div class="row">
          <div class="col-lg-6">
            <!-- Credit -->
            <div class="panel panel-default">
              <div class="panel-heading">ข้อมูลเครดิท</div>
              <div class="panel-body">
                <table class="table table-hover dashboard-table">
                  <tbody>
                    <tr>
                      <td>คงเหลือการแจ้งเตือนผ่านเมล์</td>
                      <td class="text-center"><span class="label label-success"><?Php echo number_format($MemberDetail['credit_email']); ?></span></td>
                      <td>ครั้ง</td>
                    </tr>
                    <tr>
                      <td>คงเหลือการแจ้งเตือนผ่าน SMS</td>
                      <td class="text-center"><span class="label label-info"><?Php echo number_format($MemberDetail['credit_sms']); ?></span></td>
                      <td>ครั้ง</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

            <!-- รายการสั่งซื้อล่าสุด -->
            <div class="panel panel-default">
              <div class="panel-heading">รายการสั่งซื้อล่าสุด</div>
              <div class="panel-body">
                <table class="table table-hover dashboard-table">
                  <thead>
                    <tr>
                      <th class="text-center">#ID</th>
                      <th class="text-center">สถานะ</th>
                      <th class="text-center">สร้างเมื่อ</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="text-center"><a href="#">#5</a></td>
                      <td class="text-center"><span class="label label-warning">ยังไม่ชำระ</span></td>
                      <td class="text-center">5/5/2014 23:18:32</td>
                    </tr>
                    <tr>
                      <td class="text-center"><a href="#">#4</a></td>
                      <td class="text-center"><span class="label label-success">ชำระเงินแล้ว</span></td>
                      <td class="text-center">4/5/2014 21:16:49</td>
                    </tr>
                    <tr>
                      <td class="text-center"><a href="#">#3</a></td>
                      <td class="text-center"><span class="label label-info">กำลังตรวจสอบ</span></td>
                      <td class="text-center">4/5/2014 23:26:12</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <!-- รายการพัสดุล่าสุด -->
            <div class="panel panel-default">
              <div class="panel-heading">รายการพัสดุล่าสุด</div>
              <div class="panel-body">
                <table class="table table-hover dashboard-table">
                  <thead>
                    <tr>
                      <th>หมายเลข</th>
                      <th class="text-center">สถานะล่าสุด</th>
                      <th class="text-center">อัพเดท</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><a href="#">EE123456789TH</a></td>
                      <td class="text-center">เตรียมนำจ่าย</td>
                      <td class="text-center">26 นาทีที่แล้ว</td>
                    </tr>
                    <tr>
                      <td><a href="#">RR123456789TH</a></td>
                      <td class="text-center">เตรียมนำจ่าย</td>
                      <td class="text-center">26 นาทีที่แล้ว</td>
                    </tr>
                    <tr>
                      <td><a href="#">CC123456789TH</a></td>
                      <td class="text-center">เตรียมนำจ่าย</td>
                      <td class="text-center">26 นาทีที่แล้ว</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            
            <!-- ประวัติการเข้าสู่ระบบล่าสุด -->
            <div class="panel panel-default">
              <div class="panel-heading">ประวัติการเข้าสู่ระบบล่าสุด</div>
              <div class="panel-body">
                <table class="table table-hover dashboard-table">
                  <thead>
                    <tr>
                      <th>วันที่</th>
                      <th class="text-center">เข้าสู่ระบบ (ครั้ง)</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>5/5/2014</td>
                      <td class="text-center">3</td>
                    </tr>
                    <tr>
                      <td>4/5/2014</td>
                      <td class="text-center">12</td>
                    </tr>
                    <tr>
                      <td>3/5/2014</td>
                      <td class="text-center">15</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</div>

<?Php include('template/modal.php'); ?>

<?Php include('template/footer.php'); ?>
</body>
</html>