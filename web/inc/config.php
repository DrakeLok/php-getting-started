<?php
/************************************
FILENAME	: inc/config.php
AUTHOR		: CAHYA DSN
CREATED DATE: 2017-12-02
UPDATED DATE: 2017-12-02
*************************************/
//-- 
define('_ISONLINE',true);
//-- assets folder
define('_ASSET','assets/');
//-- database configuration
$dbhost='ec2-52-205-61-230.compute-1.amazonaws.com';
$dbuser='phjiyacuwqmewt';
$dbpass='d93b7ddccad98e388e6f33b8cf75dd0a3336f936895ff10b61fc0996ebd07f1f';
$dbname='dci6k6atjnt67c';
//-- database connection
$db=pg_connect("host=ec2-52-205-61-230.compute-1.amazonaws.com dbname=dci6k6atjnt67c user=phjiyacuwqmewt password=d93b7ddccad98e388e6f33b8cf75dd0a3336f936895ff10b61fc0996ebd07f1f") or die('Could not connect: ' . preg_last_error());