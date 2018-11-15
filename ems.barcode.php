<?Php
function IsFilter($strBarCode){
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

function IsBarcode($strBarCode) {  
	if (strlen($strBarCode) < 13)
		return false;
	if (!empty($strBarCode)) { 	
		if (strlen($strBarCode) == 13) {
			if (strtoupper(substr($strBarCode, 10, 1))  == 'X') {
				if (IsFilter($strBarCode))
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
				if (IsFilter($strBarCode))
					return  true;
				else
					return  false;
			}
			else
				return  false;
		} else if ($Result == 1) {
			if (substr($strBarCode, 10, 1) == 0) {
				if (IsFilter($strBarCode))
					return  true;
				else
					return  false;
			}
			else
				return  false;
		} else {
			if (substr($strBarCode, 10, 1) == (11 - $Result)) {
				if (IsFilter($strBarCode))
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

var_dump(IsBarcode('EL049715277TH'));
