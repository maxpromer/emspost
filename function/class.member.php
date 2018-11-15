<?Php
class MemberFunction{
	private $dbHandle;
	public $e;
	
	public function __construct($dbHandle){
		$this->dbHandle = $dbHandle;
	}
	
	public function Registe($email, $password, $name, $tel){
		if ($this->ExistMemberByEmail($email) == true){
			$this->e = 'Email exist true.';
			return false;
		}
		$encode_password = $this->EncodePassword($password);
		try{
			$stmt = $this->dbHandle->prepare('INSERT INTO `member` (`id`, `email`, `password`, `name`, `tel`, `credit_email`, `credit_sms`) VALUES (NULL, :email, :password, :name, :tel, 0, 0);');
			$stmt->bindParam(':email', $email);
			$stmt->bindParam(':password', $encode_password);
			$stmt->bindParam(':name', $name);
			$stmt->bindParam(':tel', $tel);
			$stmt->execute();
		}catch(PDOException $e){
			$this->e = $e->getMessage();
			return false;
		}
		include(__Path__ . '/function/class.mail.php');
		$objMail = new MailFunction($this->dbHandle);
		if ($objMail->MailMemberRegiste($email, $password, $name, $tel))
			return true;
		else{
			$this->e = $objMail->e;
			return false;
		}
	}
	
	public function ResetPassword($email, $password = NULL){
		if ($password == NULL){
			include(__Path__ . '/function/function.php');
			$password = StrRandom(10);
		}
		$uid = $this->GetIdByEmail($email);
		if (!$uid)
			return false;
		if (!$this->ModifyPassword($uid, $password))
			return false;
		include(__Path__ . '/function/class.mail.php');
		$objMail = new MailFunction($this->dbHandle);
		if ($objMail->MailMemberRegiste($email, $password))
			return true;
		else{
			$this->e = $objMail->e;
			return false;
		}
	}
	
	public function Login($email, $password, $rememberme = false){
		$MemberDetail = $this->GetDetailByEmail($email);
		if (!$MemberDetail)
			return false;
		$encode_password = $this->EncodePassword($password);
		if ($MemberDetail['password'] != $encode_password){
			$this->e = 'Password incorrect.';
			return false;
		}
		if ($rememberme)
			$timeout = time() + 155520000;
		else
			$timeout = time() + 1800;
		return $this->NewSession($MemberDetail['id'], $timeout);
	}
	
	public function Logout($key, $toket){
		try{
			$stmt = $this->dbHandle->prepare('DELETE FROM `session` WHERE `session`.`key` = :key AND `session`.`toket` = :toket LIMIT 1;');
			$stmt->bindParam(':key', $key);
			$stmt->bindParam(':toket', $toket);
			$stmt->execute();
		}catch(PDOException $e){
			$this->e = $e->getMessage();
			return false;
		}
		return true;
	}
	
	public function GetDetailByEmail($email){
		try{
			$stmt = $this->dbHandle->prepare('SELECT COUNT(`id`) AS `Count`, `id`, `email`, `password`, `name`, `tel`, `credit_email`, `credit_sms` FROM `member` WHERE `email` = ? LIMIT 1;');
			$stmt->execute(array($email));
			$arr = $stmt->fetch();
		}catch(PDOException $e){
			$this->e = $e->getMessage();
			return false;
		}
		if ($arr['Count'] <= 0){
			$this->e = 'Not found member.';
			return false;
		}
		return $arr;
	}
	
	public function GetDetailByID($id){
		try{
			$stmt = $this->dbHandle->prepare('SELECT COUNT(`id`) AS `Count`, `id`, `email`, `password`, `name`, `tel`, `credit_email`, `credit_sms` FROM `member` WHERE `id` = ? LIMIT 1;');
			$stmt->execute(array($id));
			$arr = $stmt->fetch();
		}catch(PDOException $e){
			$this->e = $e->getMessage();
			return false;
		}
		if ($arr['Count'] <= 0){
			$this->e = 'Not found member.';
			return false;
		}
		return $arr;
	}
	
	public function ValiEmail($email){
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
			$this->e = 'Invalid email format.';
			return false;
		}
		$MemberDetail = $this->GetDetailByEmail($email);
		if (!$MemberDetail)
			return false;
		return true;
	}
	
	public function CheckLogin($key, $toket){
		$SessionDetail = $this->GetDetailSession($key, $toket);
		$timeout = strtotime($SessionDetail['timeout']);
		if ($timeout < time()){
			$this->e = 'Session time out.';
			return false;
		}
		return $SessionDetail['uid'];
	}
	
	public function GetDetailSession($key, $toket){
		try{
			$stmt = $this->dbHandle->prepare('SELECT COUNT(`id`) AS `Count`, `id`, `uid`, `time`, `timeout` FROM `session` WHERE `key` = ? AND `toket` = ? LIMIT 1;');
			$stmt->execute(array($key, $toket));
			$arr = $stmt->fetch();
		}catch(PDOException $e){
			$this->e = $e->getMessage();
			return false;
		}
		if ($arr['Count'] <= 0){
			$this->e = 'Not found session.';
			return false;
		}
		return $arr;
	}
	
	public function GetIdByEmail($email){
		try{
			$stmt = $this->dbHandle->prepare('SELECT COUNT(`id`) AS `Count`, `id` FROM `member` WHERE `email` = ? LIMIT 1;');
			$stmt->execute(array($email));
			$arr = $stmt->fetch();
		}catch(PDOException $e){
			$this->e = $e->getMessage();
			return false;
		}
		if ($arr['Count'] <= 0){
			$this->e = 'Not found member.';
			return false;
		}
		return $arr['id'];
	}
	
	public function ModifyProfile($uid, $name, $tel){
		try{
			$stmt = $this->dbHandle->prepare('UPDATE `member` SET `name` = :name, `tel` = :tel WHERE `member`.`id` = :id;');
			$stmt->bindParam(':name', $name);
			$stmt->bindParam(':tel', $tel);
			$stmt->bindParam(':id', $uid);
			$stmt->execute();
		}catch(PDOException $e){
			$this->e = $e->getMessage();
			return false;
		}
		return true;
	}
	
	public function ModifyPassword($uid, $password){
		$encode_password = $this->EncodePassword($password);
		try{
			$stmt = $this->dbHandle->prepare('UPDATE `member` SET `password` = :password WHERE  `member`.`id` = :id;');
			$stmt->bindParam(':password', $encode_password);
			$stmt->bindParam(':id', $uid);
			$stmt->execute();
		}catch(PDOException $e){
			$this->e = $e->getMessage();
			return false;
		}
		return true;
	}
	
	public function ExistMemberByEmail($email){
		try{
			$stmt = $this->dbHandle->prepare('SELECT COUNT(`id`) AS `Count` FROM `member` WHERE `email` = ? LIMIT 1;');
			$stmt->execute(array($email));
			$arr = $stmt->fetch();
		}catch(PDOException $e){
			$this->e = $e->getMessage();
			return false;
		}
		return ($arr['Count'] > 0 ? true : false);
	}
	
	public function EncodePassword($password){
		return md5(sha1(sha1($password)));
	}
	
	private function NewSession($uid, $timeout){
		include(__Path__ . '/function/function.php');
		$key = StrRandom(32);
		$toket = StrRandom(64);
		$str_timeout = date('Y-m-d H:i:s', $timeout);
		try{
			$stmt = $this->dbHandle->prepare('INSERT INTO `session` (`id`, `key`, `toket`, `uid`, `time`, `timeout`) VALUES (NULL, :key, :toket, :uid, NOW(), :timeout);');
			$stmt->bindParam(':key', $key);
			$stmt->bindParam(':toket', $toket);
			$stmt->bindParam(':uid', $uid);
			$stmt->bindParam(':timeout', $str_timeout);
			$stmt->execute();
		}catch(PDOException $e){
			$this->e = $e->getMessage();
			return false;
		}
		return array('key' => $key, 'toket' => $toket, 'timeout' => $timeout);
	}
}