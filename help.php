<?Php
include('include/settings.php');
include(__Path__ . '/include/connect.php');
include(__Path__ . '/function/chk-login.php');
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>วิธีใช้</title>
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
      <li class="active"><a href="help.php">วิธีใช้</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
<?Php if ($login): ?>
      <li><a href="dashboard.php"><span class="glyphicon glyphicon-dashboard"></span>  Dashboard</a></li>
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
<?Php if (empty($_GET['id'])){ ?>
  <div class="row">
    <div class="col-lg-3">
      <nav id="affix-nav" class="sidebar visible-lg">
        <ul class="nav nav-pills nav-stacked" data-spy="affix" data-offset-top="10">
          <li class="active"><a href="#help">วิธีใช้</a></li>
        </ul>
      </nav>
    </div>
    <div class="col-lg-9">
      <!-- Help -->
      <section id="help">
        <h1>วิธีใช้</h1>
<?Php
$limit = 20;
if(empty($_GET["page"])) $start = 0;
else $start = ($_GET["page"] - 1) * $limit;
$arr = $dbHandle->query('SELECT COUNT(`id`) AS `Count` FROM `help`')->fetch();
$total = $arr['Count'];
if ($total > 0){
	$page = ceil($total/$limit);
	if (($_GET["page"] < 1 and $_GET["page"] != "") or (!is_numeric($_GET["page"]) and $_GET["page"] != "")) echo "<script>window.location = '?page=1'</script>";
	else if ($_GET["page"] > $page) echo "<script>window.location = '?page={$page}'</script>";
	$stmt = $dbHandle->prepare('SELECT * FROM `help` ORDER BY `date` DESC LIMIT ?, ?');
	$stmt->execute(array($start, $limit));
	$i = $start;
	$ar = $stmt->fetchAll();
	foreach ($ar as $arr){
?>
        <div class="panel panel-primary">
          <div class="panel-heading">
            <h3 class="panel-title"><a href="?id=<?Php echo $arr['id']; ?>"><?Php echo $arr['title']; ?></a> <small><?Php echo date('d/m/y H:i:s', strtotime($arr['date'])); ?></small></h3>
          </div>
          <div class="panel-body">
<?Php echo substr(strip_tags($arr['msg']), 0, 120); ?>
         </div>
       </div>
<?Php } ?>
       <ul class="pagination">
         <li<?Php echo ($_GET["page"] <= 1 ? ' class="disabled"' : ''); ?>><a href="<?Php echo ($_GET["page"] <= 1 ? 'javascript:void(0)' : '?page=' . $_GET["page"] - 1); ?>">«</a></li>
<?Php
	for($i=1;$i<=$page;$i++){
?>
         <li<?Php echo ((($start == 0 and $i == 1) or ($_GET["page"] == $i)) ? ' class="active"' : ''); ?>><a href="<?Php echo ((($start == 0 and $i == 1) or ($_GET["page"] == $i)) ? 'javascript:void(0)' : "?page={$i}"); ?>"><?Php echo $i; ?></a></li>
<?Php } ?>
         <li<?Php echo (($start == 0 or $_GET["page"] == $page) ? ' class="disabled"' : ''); ?>><a href="<?Php echo (($start == 0 or $_GET["page"] == $page) ? 'javascript:void(0)' : '?page=' . ($_GET["page"] + 1)); ?>">»</a></li>
       </ul>
<?Php }else{ ?>
        <div class="alert alert-dismissable alert-warning">
          <h4>Warning!</h4>
          <p>ยังไม่มีข้อมูลส่วนวิธีใช้</p>
        </div>
<?Php } ?>
      </section>
    </div>
  </div>
<?Php }else{ ?>
<?Php } ?>
</div>

<?Php include('template/modal.php'); ?>

<?Php include('template/footer.php'); ?>
</body>
</html>