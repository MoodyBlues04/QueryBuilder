<?php

namespace src;

require __DIR__ . '/../vendor/autoload.php';

use src\db\DbConfigDto;
use src\db\DbConnectionFactory;
use src\QueryBuilder\QueryBuilder;
use src\QueryBuilder\SqlCommands\OrderByCommand;

$configDto = new DbConfigDto();
$configDto->dbType = DbConnectionFactory::DB_TYPE_MYSQL;
$configDto->dbHost = '127.0.0.1';
$configDto->dbName = 'todo';
$configDto->user = 'root';

$queryBuilder = new QueryBuilder($configDto);

// $queryBuilder->insert()->into('logger')->columns(['id', 'message'])->values([21, 'test'])->execute();

// $queryBuilder->update('logger')->set(['created_at' => '2023-06-22'])->where(['id' => 21])->execute();

// $queryBuilder->delete()->from('logger')->where(['id' => 21])->execute();

$res = $queryBuilder->select('*')
    ->from('logger')
    ->where(['message' => 'test'])
    ->andWhere(['>', 'id', 20])
    // ->groupBy('message')
    // ->having(['count', 'id', '>', 1])
    ->orderBy(['id' => OrderByCommand::SORT_DESC])
    // ->limit(2)
    ->all();
var_dump($res);



/**
 * final all TODO-s in project
 * 
 * TODO condition operators validation
 * TODO last commands validation
 * TODO remove request dumps
 * TODO may be composition in QueryBuilder
 * 
 * TODO mb only one Builder with all funcs??
 */
