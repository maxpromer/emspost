<?Php
include('include/settings.php');
include(__Path__ . '/include/connect.php');
include(__Path__ . '/function/recaptchalib.php');
include(__Path__ . '/function/chk-login.php');
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>ติดต่อเรา</title>
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
      <li><a href="plan.php">อัตราค่าบริการ</a></li>
      <li><a href="payments.php">การชำระเงิน</a></li>
      <li><a href="agreement.php">ข้อตกลง</a></li>
      <li class="active"><a href="contact.php">ติดต่อเรา</a></li>
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
          <li class="active"><a href="#contact">ติดต่อเรา</a></li>
          <li><a href="#etc">ช่องทางการติดต่ออื่นๆ</a></li>
        </ul>
      </nav>
    </div>
    <div class="col-lg-9">
      <!-- Contact -->
      <section id="contact">
        <h1>ติดต่อเรา</h1>
        <form class="form-horizontal" action="" method="post" id="form-contact">
          <fieldset>
            <div class="form-group">
              <label for="name" class="col-lg-2 control-label">ชื่อ - นามสกุล</label>
              <div class="col-lg-4">
                <input type="text" class="form-control" id="name" name="name" placeholder="กรุณากรอกชื่อ - นามสกุลของคุณ" title="กรุณากรอกชื่อ - นามสกุลของคุณ" required>
              </div>
            </div>
            <div class="form-group">
              <label for="email" class="col-lg-2 control-label">อีเมล์</label>
              <div class="col-lg-4">
                <input type="email" class="form-control" id="email" name="email" placeholder="กรุณากรอกอีเมล์ของคุณ" title="กรุณากรอกอีเมล์ของคุณ" required>
              </div>
            </div>
            <div class="form-group">
              <label for="phone" class="col-lg-2 control-label">เบอร์โทร</label>
              <div class="col-lg-3">
                <input type="tel" class="form-control" id="phone" name="phone" placeholder="กรุณากรอกเบอร์โทรศัพท์" title="กรุณากรอกเบอร์โทรศัพท์" required>
              </div>
            </div>
            <div class="form-group">
              <label for="title" class="col-lg-2 control-label">เรื่อง</label>
              <div class="col-lg-6">
                <input type="text" class="form-control" id="title" name="title" placeholder="กรุณากรอกชื่อเรื่อง" title="กรุณากรอกชื่อเรื่อง" required>
              </div>
            </div>
            <div class="form-group">
              <label for="msg" class="col-lg-2 control-label">รายละเอียด</label>
              <div class="col-lg-10">
                <textarea class="form-control" rows="3" id="msg" name="msg" rows="5" placeholder="กรอกรายละเอียดต่างๆเพิ่มเติม" title="กรอกรายละเอียดต่างๆเพิ่มเติม" required></textarea>
              </div>
            </div>
            <div class="form-group">
              <label for="msg" class="col-lg-2 control-label">ป้องกันหุ่นยนต์</label>
              <div class="col-lg-10">
<?Php  echo recaptcha_get_html( __reCaptchaPublicKey__ ); ?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-lg-10 col-lg-offset-2">
                <button type="reset" class="btn btn-default btn-sm">ยกเลิก</button>
                <button type="submit" class="btn btn-primary btn-sm" data-loading-text="<span class='glyphicon glyphicon-refresh rotate-infinite'></span> รอซักครู่...">ส่งข้อความ <span class="glyphicon glyphicon-send"></span></button>
              </div>
            </div>
          </fieldset>
        </form>
      </section>
      
      <section id="etc">
        <h2>ช่องทางการติดต่ออื่นๆ</h2>
        <ul>
          <li>Facebook: <a href="http://www.facebook.com/maxthai" target="_blank">Sonthaya Nongnuch</a></li>
          <li>Thaiseoboard User: <a href="http://www.thaiseoboard.com/index.php?action=profile;u=214769" target="_blank">max30012540</a></li>
          <li>E-mail: <a href="mailto:max30012540@hotmail.com">max30012540@hotmail.com</a></li>
          <li>Tel: 084-1079779</li>
        </ul>
        <div class="alert alert-dismissable alert-info">
          <p>เว็บไซต์นี้เป็นเว็บไซต์ในเครือของ <a href="http://www.host-1gb.com/" target="_blank">Host-1gb.com</a> หากต้องการติดต่อ สามารถใช้ช่องทางการติดต่อเดียวกับ Host-1gb.com ได้</p>
        </div>
      </section>
    </div>
  </div>
</div>

<?Php include('template/modal.php'); ?>

<?Php include('template/footer.php'); ?>
</body>
</html>