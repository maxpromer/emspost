<?Php
//PHP Data Objects (PDO)
$dbHandle = new PDO("mysql:host={$config['sql']['host']};dbname={$config['sql']['db']};charset=utf8;", $config['sql']['user'], $config['sql']['pass'],array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
$dbHandle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$dbHandle->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
?>