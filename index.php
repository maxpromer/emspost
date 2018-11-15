<?Php
include('include/settings.php');
include(__Path__ . '/include/connect.php');
include(__Path__ . '/function/chk-login.php');
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>ระบบติดตามพัสดุพร้อมแจ้งเตือนอัตโนมัติ</title>
<meta name="keywords" content="ติดตามพัสดุ, EMS, ติดตาม EMS, สถานะพัสดุ, พัสดุ EMS" />
<meta name="description" content="ระบบติดตามพัสดุ EMS อัตโนมัติ แจ้งเตือนผ่านอีเมล์หรือ SMS ในราคาที่ถูกกว่าใคร">
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
      <li class="active"><a href="./">หน้าแรก</a></li>
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
          <li class="active"><a href="#emspost-what">EMSPost?</a></li>
          <li><a href="#property">คุณสมบัติ</a></li>
          <li><a href="#price">อัตตราค่าบริการ</a></li>
          <li><a href="#payment">การชำระเงิน</a></li>
          <li><a href="#news">ข่าวสาร</a></li>
        </ul>
      </nav>
    </div>
    <div class="col-lg-9">
      <!-- EMS Post? -->
      <section id="emspost-what">
        <h1>EMS Post?</h1>
        <p><strong>EMS Post</strong> คือ ระบบติดตามสถานะสินค้าอัตโนมัติจากไปรณีย์ไทยชนิด EMS ช่วยให้ไม่ต้องเช็คสถานะสินค้าด้วยตัวเอง โดยระบบสามารถแจ้งเตือนโดยส่งอีเมล์หรือ SMS ให้ผู้ใช้งานทราบได้</p>
      </section>
    
      <!-- Property -->
      <section id="property">
        <h2>คุณสมบัติ</h2>
        <ul>
          <li>แจ้งเตือนผ่านอีเมล์ โดยสามารถกำหนดเมล์ที่ให้แจ้งเตือนได้รายหมายเลข</li>
          <li>แจ้งเตือนผ่าน SMS โดยสามารถกำหนดเบอร์โทรที่ให้แจ้งเตือนได้รายหมายเลข</li>
          <li>ปิดการแจ้งเตือน</li>
          <li>อัพเดทสถานะทุกๆ 30 นาที</li>
          <li>เพิ่ม - ลบ หมายเลข EMS ได้ตลอดเวลา</li>
          <li>มีระบบ API เขียนสคริปเชื่อมต่อกับระบบร้านค้าของท่านได้ทันที!</li>
          <li>ราคาถูก</li>
        </ul>
      </section>
    
      <!-- Price -->
      <section id="price">
        <h2>อัตตราค่าบริการ</h2>
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
    
      <!-- -->
      <section id="payment">
        <h2>การชำระเงิน</h2>
        <div class="row">
          <div class="col-lg-6">
            <h3>โอนเงินเข้าธนาคารกรุงเทพ</h3>
            <div class="col-lg-4"><img src="img/bbl.png" alt="ธนาคารกรุงเทพ"></div>
            <div class="col-lg-8">
              <ul class="lish-ul">
                <li><strong>ชื่อบัญชี:</strong> สนธยา นงนุช</li>
                <li><strong>ประเภทบัญชี:</strong> ออมทรัพย์</li>
                <li><strong>สาขา:</strong> พานทอง</li>
                <li><strong>เลขบัญชี:</strong> 509-2-21393-7</li>
              </ul>
            </div>
          </div>
          <div class="col-lg-6">
            <h3>โอนเงินเข้าธนาคารกสิกรไทย</h3>
            <div class="col-lg-4"><img src="img/kbank.jpg" alt="ธนาคารกสิกรไทย"></div>
            <div class="col-lg-8">
              <ul class="lish-ul">
                <li><strong>ชื่อบัญชี:</strong> สนธยา นงนุช</li>
                <li><strong>ประเภทบัญชี:</strong> ออมทรัพย์</li>
                <li><strong>สาขา:</strong> พานทอง</li>
                <li><strong>เลขบัญชี:</strong> 465-0-60044-0</li>
              </ul>
            </div>
          </div>
        </div>
      </section>
      
      <section id="news">
        <h2>ข่าวสาร</h2>
        <div class="well well-sm">
          <ul class="news-lish">
<?Php
include(__Path__ . '/function/class.news.php');
$objNews = new NewsFunction($dbHandle);
$AllNews = $objNews->GetAll();
foreach ($AllNews as $New){
?>
            <li><span class="label label-info"><?Php echo date('d/m/Y H:i:s', strtotime($New['time'])); ?></span> <?Php echo $New['msg']; ?></li>
<?Php } ?>
          </ul>
        </div>
      </section>
    </div>
  </div>
</div>

<?Php include('template/modal.php'); ?>

<?Php include('template/footer.php'); ?>
</body>
</html>