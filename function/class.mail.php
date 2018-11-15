<?Php
class MailFunction{
	private $dbHandle;
	public $e;
	
	public function __construct($dbHandle){
		$this->dbHandle = $dbHandle;
	}
	
	public function SendMail($to, $subject, $message){
		require(__Path__ . '/function/phpmailer/class.phpmailer.php');
		
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->IsHTML(true);
		$mail->CharSet = 'utf-8';

		$mail->SMTPAuth = 'true';
		$mail->Host = $config['smtp']['host'];
		$mail->Port = $config['smtp']['port'];
		$mail->Username = $config['smtp']['username'];
		$mail->Password = $config['smtp']['password'];

		$mail->From = $config['mail']['form'];
		$mail->FromName = $config['mail']['formName'];
		$mail->addReplyTo($config['mail']['reply'], $config['mail']['replyName']);
		$mail->addCC($config['mail']['CC']);
		$mail->AddAddress($to);
		$mail->Subject = $subject;
		$mail->Body = $message;

		if (!$mail->Send()){
			$this->e = $mail->ErrorInfo;
			return false;
		}
		try{
			$stmt = $this->dbHandle->prepare('INSERT INTO `maillog` (`to`, `subject`, `time`) VALUES (:to, :subject, NOW());');
			$stmt->bindParam(':to', $to);
			$stmt->bindParam(':subject', $subject);
			$stmt->execute();
		}catch(PDOException $e){
			$this->e = $e->getMessage();
			return false;
		}
		return true;
	}
	
	public function MailContact($name, $email, $phone, $title, $msg){
		try{
			$stmt = $this->dbHandle->prepare('SELECT * FROM `mailform` WHERE `id` = 1 LIMIT 1;');
			$stmt->execute();
			$arr = $stmt->fetch();
		}catch(PDOException $e){
			$this->e = $e->getMessage();
			return false;
		}
		$msg = nl2br($msg);
		$fide = array('{name}', '{email}', '{phone}', '{title}', '{msg}');
		$replace = array($name, $email, $phone, $title, $msg);
		$subject = str_replace($fide, $replace, $arr['title']);
		$message = str_replace($fide, $replace, $arr['msg']);
		if ($this->SendMail($email, $subject, $message))
			return true;
		return false;
	}
	
	public function MailMemberRegiste($email, $password, $name, $tel){
		try{
			$stmt = $this->dbHandle->prepare('SELECT * FROM `mailform` WHERE `id` = 2 LIMIT 1;');
			$stmt->execute();
			$arr = $stmt->fetch();
		}catch(PDOException $e){
			$this->e = $e->getMessage();
			return false;
		}
		$fide = array('{email}', '{password}', '{name}', '{phone}');
		$replace = array($email, $password, $name, $tel);
		$subject = str_replace($fide, $replace, $arr['title']);
		$message = str_replace($fide, $replace, $arr['msg']);
		if ($this->SendMail($email, $subject, $message))
			return true;
		return false;
	}
	
	public function MailMemberResetPassword($email, $password){
		try{
			$stmt = $this->dbHandle->prepare('SELECT * FROM `mailform` WHERE `id` = 3 LIMIT 1;');
			$stmt->execute();
			$arr = $stmt->fetch();
		}catch(PDOException $e){
			$this->e = $e->getMessage();
			return false;
		}
		$objMember = new MemberFunction($this->dbHandle);
		$MemberDetail = $objMember->GetDetailByEmail($email);
		if (!$MemberDetail){
			$this->e = $objMember->e;
			return false;
		}
		$fide = array('{id}', '{email}', '{password}', '{name}', '{phone}');
		$replace = array($MemberDetail['id'], $MemberDetail['email'], $password, $MemberDetail['name'], $MemberDetail['tel']);
		$subject = str_replace($fide, $replace, $arr['title']);
		$message = str_replace($fide, $replace, $arr['msg']);
		if ($this->SendMail($email, $subject, $message))
			return true;
		return false;
	}
}