<?Php
include('include/settings.php');
include(__Path__ . '/include/connect.php');
include(__Path__ . '/function/chk-login.php');
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>ข้อตกลง</title>
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
      <li class="active"><a href="agreement.php">ข้อตกลง</a></li>
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
          <li class="active"><a href="#agreement">ข้อตกลง</a></li>
        </ul>
      </nav>
    </div>
    <div class="col-lg-9">
      <!-- Agreement -->
      <section id="agreement">
        <h1>ข้อตกลง</h1>
        <ol>
          <li>ผู้ให้บริการไม่ยินยอมให้ผู้ใช้บริการซื้อขายชื่อผู้ใช้งานโดยเด็ดขาด</li>
          <li>ผู้ใช้บริการห้ามใช้ประโยชน์จากระบบนี้ไปทำการหาผลกำไร ไม่ว่าจะเป็นวิธีไหนก็ตาม</li>
          <li>กรณีเครดิทหมดในขณะที่การดำเนินการของไปรณีย์ยังไม่สิ้นสุดลง ผู้ให้บริการขอยกเลิกการแจ้งเตือนโดยทันที</li>
          <li>การดำเนินการที่ผ่านมาแล้ว จะไม่ถูกแจ้งเตือนอีกครั้ง</li>
          <li>การแจ้งชำระเงินจะถูกดำเนินการตรวจสอบทันที่ที่มีเจ้าหน้าที่ออนไลน์ หากไม่ได้รับการยืนยันการชำระเงินภายใน 24 ชั่วโมง กรุณาติดต่อเราโดยด่วนที่สุด</li>
          <li>ผู้ให้บริการจะไม่คืนเงินที่ชำระเข้ามาแล้ว แม้ว่าจะกรณีใดๆก็ตาม</li>
          <li>ผู้ให้บริการไม่รับผิดชอบกรณีส่งการแจ้งเตือนไม่สำเร็จ</li>
          <li>ผู้ให้บริการไม่สามารถแจ้งเตือนได้ หากระบบไปรณีย์ไทยเกิดความขัดข้องขึ้น</li>
          <li>ผู้ให้บริการขอไม่ตอบคำถามโดยละเอียด หากคำถามนั้นมีคำตอบในส่วนวิธีใช้อยู่แล้ว โดยผู้ให้บริการอาจจะส่งลิ้งเพื่อให้ผู้ใช้บริการทำความเข้าใจเอง</li>
          <li>หากผู้ใช้บริการติดปัญหาการใช้งานใด ที่ไม่มีในส่วนวิธีใช้ สามารถติดต่อสอบถามได้ทันที</li>
          <li>บริการแจ้งเตือนนี้ ไม่เกี่ยวข้องกับบริษัทไปรณีย์ไทย เป็นเพียงผู้ให้บริการแจ้งเตือนโดยอาศัยช่องทางระบบ Track And Trace ของไปรณีย์ไทยเท่านั้น</li>
          <li>ผู้ใช้บริการไม่มีสิทธิ์อ้างว่าไม่รับทราบข้อตกลงในการใช้บริการ</li>
          <li>ผู้ให้บริการมีสิทธิ์ดำเนินการใดๆก็ได้ตามความเหมาะสม หากผู้ใช้บริการไม่ปฏิบัติตามข้อตกลงนี้</li>
        </ol>
      </section>
      <div class="text-center" id="box-print-agreement"><button id="print-agreement" class="btn btn-success btn-sm">สั่งพิมพ์</button></div>
    </div>
  </div>
</div>

<?Php include('template/modal.php'); ?>

<?Php include('template/footer.php'); ?>
</body>
</html>