<?Php
include('include/settings.php');
include(__Path__ . '/include/connect.php');
include(__Path__ . '/function/chk-login.php');
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>อัตตราค่าบริการ</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="css/style.css">
<script src="js/jquery-2.0.2.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/app.js"></script>
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
      <li class="active"><a href="plan.php">อัตราค่าบริการ</a></li>
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
          <li class="active"><a href="#price">อัตตราค่าบริการ</a></li>
          <li><a href="#etc">รายละเอียดเพิ่มเติม</a></li>
        </ul>
      </nav>
    </div>
    <div class="col-lg-9">
      <!-- Price -->
      <section id="price">
        <h1>อัตตราค่าบริการ</h1>
        <div class="box-price">
          <div class="box-plan">
            <div class="header">100 บาท</div>
            <div class="content">
              <ul>
                <li>แจ้งเตือนผ่านอีเมล์ 300 ครั้ง</li>
                <li>แจ้งเตือนผ่าน SMS 100 ครั้ง</li>
                <li>ไม่มีวันหมดอายุ</li>
                <li>รองรับ API</li>
              </ul>
            </div>
            <div class="footer">
              <form action="order.php" method="post">
                <button class="btn btn-success btn-sm"><span class="glyphicon glyphicon-shopping-cart"></span> สั่งซื้อ</button>
                <input type="hidden" name="plan" id="plan" value="1">
              </form>
            </div>
          </div>
          <div class="box-plan">
            <div class="header">200 บาท</div>
            <div class="content">
              <ul>
                <li>แจ้งเตือนผ่านอีเมล์ 700 ครั้ง</li>
                <li>แจ้งเตือนผ่าน SMS 250 ครั้ง</li>
                <li>ไม่มีวันหมดอายุ</li>
                <li>รองรับ API</li>
              </ul>
            </div>
            <div class="footer">
              <form action="order.php" method="post">
                <button class="btn btn-success btn-sm"><span class="glyphicon glyphicon-shopping-cart"></span> สั่งซื้อ</button>
                <input type="hidden" name="plan" id="plan" value="2">
              </form>
            </div>
          </div>
          <div class="box-plan">
            <div class="header">500 บาท</div>
            <div class="content">
              <ul>
                <li>แจ้งเตือนผ่านอีเมล์ 1,800 ครั้ง</li>
                <li>แจ้งเตือนผ่าน SMS 600 ครั้ง</li>
                <li>ไม่มีวันหมดอายุ</li>
                <li>รองรับ API</li>
              </ul>
            </div>
            <div class="footer">
              <form action="order.php" method="post">
                <button class="btn btn-success btn-sm"><span class="glyphicon glyphicon-shopping-cart"></span> สั่งซื้อ</button>
                <input type="hidden" name="plan" id="plan" value="3">
              </form>
            </div>
          </div>
        </div>
      </section>
      
      <section id="etc">
        <h2>รายละเอียดเพิ่มเติม</h2>
        <ul>
          <li>แอ๊กเค้าที่เปิดใช้งานแล้ว จะใช้งานได้ตลอดไป</li>
          <li>ไม่หมดอายุ หมายความว่าหลังจากชำระเงินแล้ว ได้เครดิตเป็นจำนวนเมล์และ SMS แล้ว สามารถใช้งานได้ตลอดไปจนกว่าเครดิตจะหมด</li>
        </ul>
    </div>
  </div>
</div>

<?Php include('template/modal.php'); ?>

<?Php include('template/footer.php'); ?>
</body>
</html>