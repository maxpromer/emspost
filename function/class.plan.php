<?Php
class PlanFunction{
	private $dbHandle;
	public $e;
	
	public function __construct($dbHandle){
		$this->dbHandle = $dbHandle;
	}
	
	public function AddPlan($name, $credit_email, $credit_sms, $price){
		try{
			$stmt = $this->dbHandle->prepare('INSERT INTO `plan` (`id`, `name`, `credit_email`, `credit_sms`, `price`) VALUES (NULL, :name, :credit_email, :credit_sms, :price);');
			$stmt->bindParam(':name', $name);
			$stmt->bindParam(':credit_email', $credit_email);
			$stmt->bindParam(':credit_sms', $credit_sms);
			$stmt->bindParam(':price', $price);
			$stmt->execute();
		}catch(PDOException $e){
			$this->e = $e->getMessage();
			return false;
		}
		return true;
	}
	
	public function RemovePlan($id){
		try{
			$stmt = $this->dbHandle->prepare('DELETE FROM `plan` WHERE `plan`.`id` = ? LIMIT 1;');
			$stmt->execute(array($id));
			$arr = $stmt->fetch();
		}catch(PDOException $e){
			$this->e = $e->getMessage();
			return false;
		}
		return true;
	}
	
	public function GetDetailByID($id){
		try{
			$stmt = $this->dbHandle->prepare('SELECT COUNT(`id`) AS `Count`, `id`, `name`, `credit_email`, `credit_sms`, `price` FROM `plan` WHERE `id` = ? LIMIT 1;');
			$stmt->execute(array($id));
			$arr = $stmt->fetch();
		}catch(PDOException $e){
			$this->e = $e->getMessage();
			return false;
		}
		if ($arr['Count'] <= 0){
			$this->e = 'Not found plan.';
			return false;
		}
		return $arr;
	}
}