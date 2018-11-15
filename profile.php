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
<title>แก้ไขข้อมูลส่วนตัว</title>
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
          <li class="active"><a href="#edit-profile">แก้ไขข้อมูลส่วนตัว</a></li>
          <li><a href="#edit-password">แก้ไขรหัสผ่าน</a></li>
        </ul>
      </nav>
    </div>
    <div class="col-lg-9">
      <!-- Edit Profile -->
      <section id="edit-profile">
        <h1>แก้ไขข้อมูลส่วนตัว</h1>
<?Php
if (isset($_GET['edit-profile'])){
	$error = false;
	$name = $_POST['name'];
	$tel = $_POST['tel'];
	if ((!empty($name)) and (!empty($tel))){
		if ($objMember->ModifyProfile($login_uid, $name, $tel) == false){
			$error = true;
			$msg = $objMember->e;
		}
	}else{
		$error = true;
		$msg = 'ข้อมูลไม่ครบ';
	}
	if ($error == false){
		$MemberDetail = $objMember->GetDetailByID($login_uid);
?>
        <div class="alert alert-success"><strong>สำเร็จ!</strong> ข้อมูลส่วนตัวของคุณถูกแก้ไขแล้ว</div>
<?Php
	}else{
?>
        <div class="alert alert-warning"><strong>ไม่สำเร็จ!</strong> <?Php echo $msg; ?></div>
<?Php
	}
}
?>
        <form class="form-horizontal" action="?edit-profile" method="post" onSubmit="$(this).find(':submit').button('loading');">
          <fieldset>
            <div class="form-group">
              <label for="name" class="col-lg-2 control-label">อีเมล์</label>
              <div class="col-lg-5">
                <div class="input-group">
                  <input type="text" class="form-control" value="<?Php echo $MemberDetail['email']; ?>" readonly>
                  <span class="input-group-btn">
                    <button class="btn btn-info" type="button" id="email-edit"><span class="glyphicon glyphicon-wrench"></span> แก้ไขอีเมล์</button>
                  </span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="name" class="col-lg-2 control-label">ชื่อ - นามสกุล</label>
              <div class="col-lg-4">
                <input type="text" class="form-control" id="name" name="name" placeholder="กรุณากรอกชื่อ - นามสกุลของคุณ" title="กรุณากรอกชื่อ - นามสกุลของคุณ" value="<?Php echo $MemberDetail['name']; ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label for="phone" class="col-lg-2 control-label">เบอร์โทร</label>
              <div class="col-lg-3">
                <input type="tel" class="form-control" id="tel" name="tel" placeholder="กรุณากรอกเบอร์โทรศัพท์" title="กรุณากรอกเบอร์โทรศัพท์" value="<?Php echo $MemberDetail['tel']; ?>" required>
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
      </section>
      
      <!-- Edit Password -->
      <section id="edit-password">
        <h2>แก้ไขรหัสผ่าน</h2>
<?Php
if (isset($_GET['edit-password'])){
	$error = false;
	$password = $_POST['password'];
	$newpassword = $_POST['newpassword'];
	$re_newpassword = $_POST['re-newpassword'];
	if ((!empty($password)) and (!empty($newpassword)) and (!empty($re_newpassword))){
		if ($newpassword == $re_newpassword){
			if ($MemberDetail['password'] == $objMember->EncodePassword($password)){
				if ($objMember->ModifyPassword($login_uid, $newpassword) == false){
					$error = true;
					$msg = $objMember->e;
				}
			}else{
				$error = true;
				$msg = 'รหัสผ่านไม่ถูกต้อง';
			}
		}else{
			$error = true;
			$msg = 'การยืนยันรหัสผ่านใหม่ไม่สำเร็จ (รหัสผ่านใหม่ และยืนยันรหัสผ่านไม่ตรงกัน)';
		}
	}else{
		$error = true;
		$msg = 'ข้อมูลไม่ครบ';
	}
	if ($error == false){
?>
        <div class="alert alert-success"><strong>สำเร็จ!</strong> รหัสผ่านถูกแก้ไขแล้ว คุณสามารถใช้งานรหัสผ่านนี้ในการเข้าสู่ระบบครั้งหน้าได้ทันที</div>
<?Php
	}else{
?>
        <div class="alert alert-warning"><strong>ไม่สำเร็จ!</strong> <?Php echo $msg; ?></div>
<?Php
	}
}
?>
        <form class="form-horizontal" action="?edit-password" method="post" onSubmit="$(this).find(':submit').button('loading');">
          <fieldset>
            <div class="form-group">
              <label for="name" class="col-lg-2 control-label">รหัสผ่าน</label>
              <div class="col-lg-4">
                <input type="password" class="form-control" id="password" name="password" placeholder="กรุณากรอกรหัสผ่านปัจจุบันของคุณ" title="กรุณากรอกรหัสผ่านปัจจุบันของคุณ" required>
              </div>
            </div>
            <div class="form-group">
              <label for="newpassword" class="col-lg-2 control-label">รหัสผ่านใหม่</label>
              <div class="col-lg-4">
                <input type="password" class="form-control" id="newpassword" name="newpassword" placeholder="กรุณากรอกรหัสผ่านใหม่ที่ต้องการ" title="กรุณากรอกรหัสผ่านใหม่ที่ต้องการ" required>
              </div>
            </div>
            <div class="form-group">
              <label for="re-newpassword" class="col-lg-2 control-label">ยืนยันรหัสผ่านใหม่</label>
              <div class="col-lg-4">
                <input type="password" class="form-control" id="re-newpassword" name="re-newpassword" placeholder="กรุณากรอกรหัสผ่านใหม่อีกครั้ง" title="กรุณากรอกรหัสผ่านใหม่อีกครั้ง" required>
              </div>
            </div>
            <div class="form-group">
              <div class="col-lg-10 col-lg-offset-2">
                <button type="reset" class="btn btn-default btn-sm">ยกเลิก</button>
                <button type="submit" class="btn btn-primary btn-sm" data-loading-text="<span class='glyphicon glyphicon-refresh rotate-infinite'></span> รอซักครู่..."><span class="glyphicon glyphicon-floppy-disk"></span> เปลี่ยนรหัสผ่าน</button>
              </div>
            </div>
          </fieldset>
        </form>
      </section>
    </div>
  </div>
</div>

<?Php include('template/modal.php'); ?>

<?Php include('template/footer.php'); ?>
</body>
</html>