<?Php
class OrderFunction{
	private $dbHandle;
	public $e;
	
	public function __construct($dbHandle){
		$this->dbHandle = $dbHandle;
	}
	
	public function AddTmpProducts($uid, $planid){
		try{
			$stmt = $this->dbHandle->prepare('INSERT INTO `tmporder` (`id`, `uid`, `planid`, `time`) VALUES (NULL, :uid, :planid, NOW());');
			$stmt->bindParam(':uid', $uid);
			$stmt->bindParam(':planid', $planid);
			$stmt->execute();
		}catch(PDOException $e){
			$this->e = $e->getMessage();
			return false;
		}
		return true;
	}
	
	public function RemoveTmpProducts($id, $uid){
		try{
			$stmt = $this->dbHandle->prepare('DELETE FROM `tmporder` WHERE `id` = ? AND `uid` = ? LIMIT 1;');
			$stmt->execute(array($id, $uid));
		}catch(PDOException $e){
			$this->e = $e->getMessage();
			return false;
		}
		return true;
	}
	
	public function TmpAll($uid){
		try{
			$stmt = $this->dbHandle->prepare('SELECT * FROM `tmporder` WHERE `uid` = ? ORDER BY `time` ASC');
			$stmt->execute(array($uid));
			$arr = $stmt->fetchAll();
		}catch(PDOException $e){
			$this->e = $e->getMessage();
			return false;
		}
		return $arr;
	}
	
	public function CountTmp($uid){
		try{
			$stmt = $this->dbHandle->prepare('SELECT COUNT(*) AS `Count` FROM `tmporder` WHERE `uid` = ?;');
			$stmt->execute(array($uid));
			$arr = $stmt->fetch();
		}catch(PDOException $e){
			$this->e = $e->getMessage();
			return false;
		}
		return $arr['Count'];
	}
	
	public function TmpToOrderAndInvoice($uid, $note = ''){
		$CountTmp = $this->CountTmp($uid);
		if ($CountTmp <= 0){
			$this->e = 'Not found tmp order.';
			return false;
		}
		$GetAll = $this->TmpAll($uid);
		include(__Path__ . '/function/class.plan.php');
		$objPlan = new PlanFunction($this->dbHandle);
		$allprice = 0;
		foreach ($GetAll as $TmpOrder){
			$PlanDetail = $objPlan->GetDetailByID($TmpOrder['planid']);
			$allprice += $PlanDetail['price'];
		}
		$paydate = date('Y-m-d', strtotime('+1 day'));
		$invoiceid = $this->NewInvoice($uid, $allprice, $paydate, $note);
		if ($invoiceid == false)
			return false;
		foreach ($GetAll as $TmpOrder){
			$PlanDetail = $objPlan->GetDetailByID($TmpOrder['planid']);
			$this->AddOrder($uid, $invoiceid, $TmpOrder['planid'], $PlanDetail['price']);
		}
		$this->TmpClean($uid);
		return $invoiceid;
	}
	
	public function NewInvoice($uid, $price, $paydate, $note){
		try{
			$stmt = $this->dbHandle->prepare('INSERT INTO `invoice` (`id`, `uid`, `status`, `price`, `date`, `paydate`, `note`) VALUES (NULL, :uid,\'\', :price, NOW(), :paydate, :note);');
			$stmt->bindParam(':uid', $uid);
			$stmt->bindParam(':price', $price);
			$stmt->bindParam(':paydate', $paydate);
			$stmt->bindParam(':note', $note);
			$stmt->execute();
		}catch(PDOException $e){
			$this->e = $e->getMessage();
			return false;
		}
		return $this->dbHandle->lastInsertId();
	}
	
	public function AddOrder($uid, $invoiceid, $planid, $price){
		try{
			$stmt = $this->dbHandle->prepare('INSERT INTO `order` (`id`, `uid`, `invoiceid`, `planid`, `price`, `time`) VALUES (NULL, :uid, :invoiceid, :planid, :price, NOW());');
			$stmt->bindParam(':uid', $uid);
			$stmt->bindParam(':invoiceid', $invoiceid);
			$stmt->bindParam(':planid', $planid);
			$stmt->bindParam(':price', $price);
			$stmt->execute();
		}catch(PDOException $e){
			$this->e = $e->getMessage();
			return false;
		}
		return true;
	}

	public function TmpClean($uid){
		try{
			$stmt = $this->dbHandle->prepare('DELETE FROM `tmporder` WHERE `uid` = ?;');
			$stmt->execute(array($uid));
		}catch(PDOException $e){
			$this->e = $e->getMessage();
			return false;
		}
		return true;
	}
	
	public function GetInvoiceDetailByID($id){
		try{
			$stmt = $this->dbHandle->prepare('SELECT COUNT(`id`) AS `Count`, `id`, `uid`, `price`, `date`, `paydate`, `note` FROM `invoice` WHERE `id` = ? LIMIT 1;');
			$stmt->execute(array($id));
			$arr = $stmt->fetch();
		}catch(PDOException $e){
			$this->e = $e->getMessage();
			return false;
		}
		if ($arr['Count'] <= 0){
			$this->e = 'Not found invoice.';
			return false;
		}
		return $arr;
	}
	
	public function ExistInvoiceByID($uid, $id){
		try{
			$stmt = $this->dbHandle->prepare('SELECT COUNT(`id`) AS `Count` FROM `invoice` WHERE `id` = ? AND `uid` = ? LIMIT 1;');
			$stmt->execute(array($id, $uid));
			$arr = $stmt->fetch();
		}catch(PDOException $e){
			$this->e = $e->getMessage();
			return false;
		}
		if ($arr['Count'] <= 0)
			return false;
		return true;
	}
	
	public function AllOrderForInvoice($invoiceid){
		try{
			$stmt = $this->dbHandle->prepare('SELECT * FROM `order` WHERE `invoiceid` = ? ORDER BY `id` ASC');
			$stmt->execute(array($invoiceid));
			$arr = $stmt->fetchAll();
		}catch(PDOException $e){
			$this->e = $e->getMessage();
			return false;
		}
		return $arr;
	}
	
	public function AllInvoiceForUid($uid){
		try{
			$stmt = $this->dbHandle->prepare('SELECT * FROM `invoice` WHERE `uid` = ? ORDER BY `id` DESC');
			$stmt->execute(array($uid));
			$arr = $stmt->fetchAll();
		}catch(PDOException $e){
			$this->e = $e->getMessage();
			return false;
		}
		return $arr;
	}
	
	public function RemoveInvoice($id){
		try{
			$stmt = $this->dbHandle->prepare('DELETE FROM `invoice` WHERE `invoice`.`id` = ? LIMIT 1;');
			$stmt->execute(array($id));
			$stmt = $this->dbHandle->prepare('DELETE FROM `order` WHERE `order`.`invoiceid` = ?;');
			$stmt->execute(array($id));
		}catch(PDOException $e){
			$this->e = $e->getMessage();
			return false;
		}
		return true;
	}
}