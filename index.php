<?php

include_once './DbConfigDto.php';
include_once './DbConnectionFactory.php';
include_once './db.php';

$configDto = new DbConfigDto();
$configDto->dbType = DbConnectionFactory::DB_TYPE_MYSQL;
$configDto->dbHost = '127.0.0.1';
$configDto->dbName = 'basic';
$configDto->user = 'root';

$db = db::getInstance($configDto);
$res = $db->query("SELECT * FROM job");
var_dump($res);
