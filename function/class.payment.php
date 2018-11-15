<?Php
class PaymentFunction{
	private $dbHandle;
	public $e;
	
	public function __construct($dbHandle){
		$this->dbHandle = $dbHandle;
	}
	
	public function AddPayment($name, $detail){
		try{
			$stmt = $this->dbHandle->prepare('INSERT INTO `payment` (`id`, `name`, `detail`) VALUES (NULL, :name, :detail);');
			$stmt->bindParam(':name', $name);
			$stmt->bindParam(':detail', $detail);
			$stmt->execute();
		}catch(PDOException $e){
			$this->e = $e->getMessage();
			return false;
		}
		return true;
	}
	
	public function RemovePayment($id){
		try{
			$stmt = $this->dbHandle->prepare('DELETE FROM `payment` WHERE `payment`.`id` = ? LIMIT 1;');
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
			$stmt = $this->dbHandle->prepare('SELECT COUNT(`id`) AS `Count`, `id`, `name`, `detail` FROM `payment` WHERE `id` = ? LIMIT 1;');
			$stmt->execute(array($id));
			$arr = $stmt->fetch();
		}catch(PDOException $e){
			$this->e = $e->getMessage();
			return false;
		}
		if ($arr['Count'] <= 0){
			$this->e = 'Not found payment.';
			return false;
		}
		return $arr;
	}
	
	public function GetAllName(){
		try{
			$stmt = $this->dbHandle->prepare('SELECT `id`, `name` FROM `payment` ORDER BY  `id` ASC;');
			$stmt->execute();
			$arr = $stmt->fetchAll();
		}catch(PDOException $e){
			$this->e = $e->getMessage();
			return false;
		}
		return $arr;
	}
}