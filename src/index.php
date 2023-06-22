<?php

namespace src;

require __DIR__ . '/../vendor/autoload.php';

use src\db\db;
use src\db\DbConfigDto;
use src\db\DbConnectionFactory;
use src\QueryBuilder\QueryBuilder;
use src\QueryBuilder\SqlCommands\OrderByCommand;

$configDto = new DbConfigDto();
$configDto->dbType = DbConnectionFactory::DB_TYPE_MYSQL;
$configDto->dbHost = '127.0.0.1';
$configDto->dbName = 'todo';
$configDto->user = 'root';

// $queryBuilder = new QueryBuilder($configDto);

// $queryBuilder->insert()->into('logger')->columns(['id', 'message'])->values([21, 'test'])->execute();

// $queryBuilder->update('logger')->set(['created_at' => '2023-06-22'])->where(['id' => 21])->execute();

// $queryBuilder->delete()->from('logger')->where(['id' => 21])->execute();

// $res = $queryBuilder->select('*')
//     ->from('logger')
//     ->where(['message' => 'test'])
//     // ->groupBy('message')
//     // ->having(['count', 'id', '>', 1])
//     ->orderBy(['id' => OrderByCommand::SORT_DESC])
//     // ->limit(2)
//     ->all();
// var_dump($res);

// $request = 'SELECT * FROM logger WHERE NOT (id = 22) ORDER BY id DESC LIMIT 3';
// $db = db::getInstance($configDto);
// var_dump($db->query($request));


$conditionTest = new ConditionTest(['id' => 1]);
$conditionTest->addCondition('or', ['created_at' => '2022-06-06']);
var_dump($conditionTest->getConditionRequest());

/**
 * final all TODO-s in project
 * 
 * TODO condition operators validation
 * TODO remove request dumps
 * TODO may be composition in QueryBuilder
 */
