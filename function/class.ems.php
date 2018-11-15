<?Php
class EMSFunction{
	private $dbHandle;
	public $e;
	
	public function __construct($dbHandle){
		$this->dbHandle = $dbHandle;
	}
	
	public function Add($uid, $barcode, $alert){
		if (!$this->IsBarcode($barcode)){
			$this->e = 'Barcode error.';
			return false;
		}
		$Tracks = $this->Track($barcode);
		if (!$Tracks)
			return false;
		try{
			$stmt = $this->dbHandle->prepare('INSERT INTO `ems` (`id`, `uid`, `barcode`, `time`, `updata`, `alert`) VALUES (NULL, :uid, :barcode, NOW(), NOW(), :alert);');
			$stmt->bindParam(':uid', $uid);
			$stmt->bindParam(':barcode', $barcode);
			$stmt->bindParam(':alert', $alert);
			$stmt->execute();
			$eid = $this->dbHandle->lastInsertId();
		}catch(PDOException $e){
			$this->e = $e->getMessage();
			return false;
		}
		try{
			foreach ($Tracks as $Track){
				$datetime = (!empty($Track['time']) ? $Track['time'] : '-');
				$institution = (!empty($Track['institution']) ? $Track['institution'] : '-');
				$description = (!empty($Track['description']) ? $Track['description'] : '-');
				$result = (!empty($Track['result']) ? $Track['result'] : '-');
				$stmt = $this->dbHandle->prepare('INSERT INTO `track` (`id`, `eid`, `datetime`, `institution`, `description`, `result`, `time`) VALUES (NULL, :eid, :datetime, :institution, :description, :result, NOW());');
				$stmt->bindParam(':eid', $eid);
				$stmt->bindParam(':datetime', $datetime);
				$stmt->bindParam(':institution', $institution);
				$stmt->bindParam(':description', $description);
				$stmt->bindParam(':result', $result);
				$stmt->execute();
			}
		}catch(PDOException $e){
			$this->e = $e->getMessage();
			return false;
		}
		return true;
	}
	
	public function Remove($id){
		try{
			$stmt = $this->dbHandle->prepare('DELETE FROM `ems` WHERE `id` = ? LIMIT 1;');
			$stmt->execute(array($id));
			$stmt = $this->dbHandle->prepare('DELETE FROM `track` WHERE `eid` = ?;');
			$stmt->execute(array($id));
		}catch(PDOException $e){
			$this->e = $e->getMessage();
			return false;
		}
		return true;
	}
	
	public function AllEMSForUid($uid, $start = 0, $limit = 30){
		try{
			$stmt = $this->dbHandle->prepare('SELECT * FROM `ems` WHERE `uid` = ? ORDER BY `id` DESC LIMIT ?, ?;');
			$stmt->execute(array($uid, $start, $limit));
			$arr = $stmt->fetchAll();
		}catch(PDOException $e){
			$this->e = $e->getMessage();
			return false;
		}
		return $arr;
	}
	
	public function CountEMSForUid($uid){
		try{
			$stmt = $this->dbHandle->prepare('SELECT COUNT(*) AS `Count` FROM `ems` WHERE `uid` = ?;');
			$stmt->execute(array($uid));
			$arr = $stmt->fetch();
		}catch(PDOException $e){
			$this->e = $e->getMessage();
			return false;
		}
		return $arr['Count'];
	}
	
	public function LatestStatus($eid){
		try{
			$stmt = $this->dbHandle->prepare('SELECT `description` FROM `track` WHERE `eid` = ? ORDER BY `id` DESC LIMIT 1;');
			$stmt->execute(array($eid));
			$arr = $stmt->fetch();
		}catch(PDOException $e){
			$this->e = $e->getMessage();
			return false;
		}
		return $arr['description'];
	}
	
	public function ExistEMSByID($uid, $id){
		try{
			$stmt = $this->dbHandle->prepare('SELECT COUNT(`id`) AS `Count` FROM `ems` WHERE `id` = ? AND `uid` = ? LIMIT 1;');
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
	
	public function ExistEMSByBarcode($uid, $barcode){
		try{
			$stmt = $this->dbHandle->prepare('SELECT COUNT(`id`) AS `Count` FROM `ems` WHERE `uid` = ? AND `barcode` = ? LIMIT 1;');
			$stmt->execute(array($uid, $barcode));
			$arr = $stmt->fetch();
		}catch(PDOException $e){
			$this->e = $e->getMessage();
			return false;
		}
		if ($arr['Count'] <= 0)
			return false;
		return true;
	}
	
	private function Track($TextBarcode){
		require_once(__Path__ . '/function/simple_html_dom.php');
		$cookies = __Path__ . '/tmp/cookies.txt';

		if (!file_exists($cookies)) touch($cookies);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/535.6 (KHTML, like Gecko) Chrome/16.0.897.0 Safari/535.6");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookies);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $cookies);
		curl_setopt($ch, CURLOPT_TIMEOUT, 120);
		curl_setopt($ch, CURLOPT_URL, 'http://track.thailandpost.co.th/trackinternet/Default.aspx');
		$data = curl_exec($ch);
		if ($data === false){
			$this->e = 'cUrl error: ' . curl_error($ch);
			return false;
		}

		$html = str_get_html($data);
		$__EVENTTARGET = $html->find("input[name='__EVENTTARGET']", 0)->value;
		$__VIEWSTATE = $html->find("input[name='__VIEWSTATE']", 0)->value;
		$__EVENTVALIDATION = $html->find("input[name='__EVENTVALIDATION']", 0)->value; 

		$data_post = array('__EVENTTARGET' => $__EVENTTARGET, '__VIEWSTATE' => $__VIEWSTATE, '__EVENTVALIDATION' => $__EVENTVALIDATION, 'TextBarcode' => $TextBarcode);

		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_post);
		curl_setopt($ch, CURLOPT_URL, 'http://track.thailandpost.co.th/trackinternet/Default.aspx');
		$data = curl_exec($ch);
		if ($data === false){
			$this->e = 'cUrl error: ' . curl_error($ch);
			return false;
		}
		
		$status = curl_getinfo($ch);
		if ($status['http_code'] != 302){
			$this->e = 'Barcode error.';
			return false;
		}

		curl_setopt($ch, CURLOPT_POST, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, '');
		curl_setopt($ch, CURLOPT_URL, 'http://track.thailandpost.co.th/trackinternet/Result.aspx');
		$data = curl_exec($ch);
		if ($data === false){
			$this->e = 'cUrl error: ' . curl_error($ch);
			return false;
		}
		curl_close($ch);
		$i1 = 0;
		$html = str_get_html($data);
		foreach($html->find("table[height='100%'] tr") as $tr){
			if (strpos($this->clean($tr->find('td', 0)->plaintext), 'วันที่') !== false) continue;
			foreach($tr->find('td') as $val)
				$arr[$i1][] = $this->clean($val->plaintext);
			$i1++;
		}
		$emss = array();
		foreach ($arr as $ems){
			$emss[] = array('time' => $this->toTime($ems[0]), 'institution' => $ems[1], 'description' => $ems[2], 'result' => $ems[3]);
		}
		return $emss;
	}

	private function clean($text) {
		$text = trim($text);
		$text = str_replace(array('&nbsp;', "\n", '  '), array('', ' ', ' '), $text);
		return $text;
	}

	private function toTime($str){
		$str = str_replace(array('', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'), '', $str);
		$str = str_replace(array('มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'), array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'), $str);
		$str = str_replace(array('น.', " \r\n", " \r"), '', $str);
		$str = trim($str);
		$str = preg_replace('/^(.*) (.*) (.*) (.*)\:(.*)\:(.*)$/', '$3-$2-$1 $4:$5:6', $str);
		$Y = substr($str, 0, 4) - 543;
		$str = preg_replace('/^(.*)-(.*)-(.*) (.*)\:(.*)\:(.*)$/', $Y . '-$2-$3 $4:$5:6', $str);
		$time = strtotime($str);
		return $time;
	}
	
	private function IsFilter($strBarCode){
		if (strtoupper(substr($strBarCode, 0, 1)) == 'E')
			return  true;
		elseif (strtoupper(substr($strBarCode, 0, 1)) == 'C')
			return  true;
		elseif (strtoupper(substr($strBarCode, 0, 1)) == 'R')
			return  true;
		elseif (strtoupper(substr($strBarCode, 0, 1)) == 'L')
			return  true;
		else if ((strlen($strBarCode) > 1) && (strtoupper(substr($strBarCode, 0, 2))  == 'DS'))
			return true;
		else if ((strlen($strBarCode) == 13) && (strtoupper(substr($strBarCode, 0, 2))  == 'VA') && (strtoupper(substr($strBarCode, 11, 2))  == 'TH'))
			return true;
		else if ((strlen($strBarCode) == 13) && (strtoupper(substr($strBarCode, 0, 2))  == 'VR') && (strtoupper(substr($strBarCode, 11, 2))  == 'TH'))
			return true;
		else if ((strlen($strBarCode) == 13) && (strtoupper(substr($strBarCode, 0, 2))  == 'VS') && (strtoupper(substr($strBarCode, 11, 2))  == 'TH'))
			return true;
		else if ((strlen($strBarCode) == 13) && (strtoupper(substr($strBarCode, 0, 2))  == 'V') && (strtoupper(substr($strBarCode, 11, 2))  == 'TH'))
			return true;
		else if ((strlen($strBarCode) == 13) && (strtoupper(substr($strBarCode, 0, 2))  == 'PE') && (strtoupper(substr($strBarCode, 11, 2))  == 'TH'))
			return true;
		else
			return false;
	}

	private function IsBarcode($strBarCode) {  
		if (strlen($strBarCode) < 13)
			return false;
		if (!empty($strBarCode)) { 	
			if (strlen($strBarCode) == 13) {
				if (strtoupper(substr($strBarCode, 10, 1))  == 'X') {
					if ($this->IsFilter($strBarCode))
						return  true;
					else
						return  false;
				}
			}
			else
				return false;
			$SumAll = 0;
			$SumAll += substr($strBarCode, 2, 1) * 8;
			$SumAll += substr($strBarCode, 3, 1) * 6;
			$SumAll += substr($strBarCode, 4, 1) * 4;
			$SumAll += substr($strBarCode, 5, 1) * 2;
			$SumAll += substr($strBarCode, 6, 1) * 3;
			$SumAll += substr($strBarCode, 7, 1) * 5;
			$SumAll += substr($strBarCode, 8, 1) * 9;
			$SumAll += substr($strBarCode, 9, 1) * 7;
			$Result = $SumAll % 11;
			if ($Result == 0) {
				if (substr($strBarCode, 10, 1) == 5) {
					if ($this->IsFilter($strBarCode))
						return  true;
					else
						return  false;
				}
				else
					return  false;
			} else if ($Result == 1) {
				if (substr($strBarCode, 10, 1) == 0) {
					if ($this->IsFilter($strBarCode))
						return  true;
					else
						return  false;
				}
				else
					return  false;
			} else {
				if (substr($strBarCode, 10, 1) == (11 - $Result)) {
					if ($this->IsFilter($strBarCode))
						return  true;
					else
						return  false;			
				}
				else				
					return  false;
			} 
		}
		else
			return false; 
	}
}
