<?php

namespace src;

require __DIR__ . '/../vendor/autoload.php';

use src\db\DbConfigDto;
use src\db\DbConnectionFactory;
use src\QueryBuilder\CommandsBuilders\CommandsQuerySelectBuilder;

$configDto = new DbConfigDto();
$configDto->dbType = DbConnectionFactory::DB_TYPE_MYSQL;
$configDto->dbHost = '127.0.0.1';
$configDto->dbName = 'todo';
$configDto->user = 'root';

$queryBuilder = new CommandsQuerySelectBuilder($configDto);

// $queryBuilder->insert()
//     ->into('logger')
//     ->columns(['message'])
//     ->values(['test'])
//     ->execute();

$res = $queryBuilder->select('*')
    ->from('logger')
    ->where(['message' => 'confirm error'])
    // ->groupBy('message')
    // ->having(['count', 'id', '>', 1])
    // ->orderBy(['id' => QuerySelectParams::SORT_DESC])
    // ->limit(2)
    ->all();
var_dump($res);
