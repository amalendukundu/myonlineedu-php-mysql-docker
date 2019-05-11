<?php

echo 'Hello from logtest.php';


require_once './fluentd-log/Exception.php';
require_once './fluentd-log/Entity.php';
require_once './fluentd-log/PackerInterface.php';
require_once './fluentd-log/JsonPacker.php';
require_once './fluentd-log/LoggerInterface.php';
require_once './fluentd-log/FluentLogger.php';

use Fluent\Logger\FluentLogger;

if(!empty($_ENV['AKTTS_LOG_HOST']))
   $host = $_ENV['AKTTS_LOG_HOST'];
else
   $host = '192.168.99.100';

if(!empty($_GET['hostip']))
   $host = $_GET['hostip'];

if(!empty($_GET['msg']))
   $msg = $_GET['msg'];
else
   $msg = time();

echo '<br>';
echo "Forward to Host= $host and Message = $msg";

//$logger = ConsoleLogger::open("debug.test",fopen("php://stdout","w"));
//$logger = HttpLogger::open("debug.test","localhost","8888");
//$logger = FluentLogger::open("192.168.99.100","24224");   ////this is for Docker
//$logger = FluentLogger::open("172.17.0.8","24224");   //this is for Kubenetes
$logger = FluentLogger::open($host, "24224");

$logger->post("kubernetes.aktts.debug.aktts-php_default_debug.log",array("AKTTS-PHP Forward Debug" => "This is debug message from AKTTS app with Custom Msg = " . $msg));


$out = fopen('php://stdout', 'w');
fputs($out, "AKTTS writing to STDOUT for FLUENTD with Custom Msg = " . $msg . " \n");
fclose($out);