<?Php
/*
-------------------- By Host-1gb.com ----------------------
ระบบนี้ถูกจัดทำโดย โปรแกรมเมอร์ สมัครเล่น ซึ่งเป็นผู้จัดทำ และขายที่ถูกต้องเพียงผู้เดียว

.:: ติดต่อ ::.
ชื่อ: นายสนธยา นงนุช
E-mail: max30012540@hotmail.com
Tel: 084-1079779
Facebook: http://www.facebook.com/maxthai (โปรแกรมเมอร์ สมัครเล่น)
------------------------- ;-) -----------------------------
*/

error_reporting(E_ALL & ~E_NOTICE); // Set error show
date_default_timezone_set('Asia/Bangkok'); // Set TimeZone

define('__Path__', '.');
define('__reCaptchaPublicKey__', '');
define('__reCaptchaPrivateKey__', '');
// Config
global $config;
$config = array(
	'sql' => array(
		'host' => 'localhost',
		'user' => 'root',
		'pass' => '1234',
		'db' => 'emspost',
	),
	'mail' => array(
		//'form' => 'no-reply@emspost.in.th',
		'form' => '',
		'formName' => 'EMSPost',
		'reply' => '',
		'replyName' => 'Sonthaya Nongnuch',
		'CC' => ''
	),
	'smtp' => array(
		'host' => '',
		'port' => 25,
		'username' => '',
		'password' => '',
	),
);
?>