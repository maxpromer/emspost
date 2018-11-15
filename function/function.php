<?Php
function thai_date($time){
	$thai_day_arr=array('อาทิตย์','จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์');
	$thai_month_arr = array(
		'0' => '',
		'1' => 'มกราคม',
		'2' => 'กุมภาพันธ์',
		'3' => 'มีนาคม',
		'4' => 'เมษายน',
		'5' => 'พฤษภาคม',
		'6' => 'มิถุนายน',	
		'7' => 'กรกฎาคม',
		'8' => 'สิงหาคม',
		'9' => 'กันยายน',
		'10' => 'ตุลาคม',
		'11' => 'พฤศจิกายน',
		'12' => 'ธันวาคม'					
	);
	$thai_date_return = 'วัน'.$thai_day_arr[date('w', $time)].'ที่ '.date('j', $time).' '.$thai_month_arr[date('n', $time)].' พ.ศ.'.(date('Y', $time) + 543).' '.date('H:i:s', $time).' น.';
	return $thai_date_return;
}

function fb_date($timestamp){
	$difference = time() - $timestamp;
	$periods = array('วินาที', 'นาที', 'ชั่วโมง');
	$ending = 'ที่แล้ว';
	if($difference<60){
		$j=0;
		//$difference=($difference==3 || $difference==4)?"a few ":$difference;
		$text = "{$difference} {$periods[$j]}{$ending}";
	}elseif($difference<3600){
		$j=1;
		$difference=round($difference/60);
		//$difference=($difference==3 || $difference==4)?"a few ":$difference;
		$text = "{$difference} {$periods[$j]}{$ending}";		
	}elseif($difference<86400){
		$j=2;
		$difference=round($difference/3600);
		//$difference=($difference != 1)?$difference:"about an ";
		$text = "{$difference} {$periods[$j]}{$ending}";		
	}elseif($difference<172800){
		$difference=round($difference/86400);
		$text = "{$difference} {$periods[$j]}{$ending}";								
	}else{
		if($timestamp<strtotime(date("Y-01-01 00:00:00")))
			$text = date("l j, Y",$timestamp)." at ".date("g:ia",$timestamp);		
		else
			$text = date("l j",$timestamp)." at ".date("g:ia",$timestamp);			
	}
	return $text;
}

function ClientIP(){
	$ip = (!empty($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : (!empty($_SERVER['HTTP_X_FORWARDED_FOR'] ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'])));
	return $ip;
}

function StrRandom($n){
	return substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'), 0, $n);
}
?>