<?Php
class NewsFunction{
	private $dbHandle;
	public $e;
	
	public function __construct($dbHandle){
		$this->dbHandle = $dbHandle;
	}
	
	public function Add($msg){
		try{
			$stmt = $this->dbHandle->prepare('INSERT INTO `news` (`id`, `msg`, `time`) VALUES (NULL, :msg, NOW());');
			$stmt->bindParam(':msg', $msg);
			$stmt->execute();
		}catch(PDOException $e){
			$this->e = $e->getMessage();
			return false;
		}
		return true;
	}
	
	public function Remove($id){
		try{
			$stmt = $this->dbHandle->prepare('DELETE FROM `news` WHERE `news`.`id` = ? LIMIT 1;');
			$stmt->execute(array($id));
			$arr = $stmt->fetch();
		}catch(PDOException $e){
			$this->e = $e->getMessage();
			return false;
		}
		return true;
	}
	
	public function GetAll($limit = 30){
		try{
			$stmt = $this->dbHandle->prepare('SELECT * FROM `news` ORDER BY `time` DESC LIMIT ?;');
			$stmt->execute(array($limit));
			$arr = $stmt->fetchAll();
		}catch(PDOException $e){
			$this->e = $e->getMessage();
			return false;
		}
		return $arr;
	}
}