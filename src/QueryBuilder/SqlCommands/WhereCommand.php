<?php

declare(strict_types=1);

namespace src\QueryBuilder\SqlCommands;

use src\QueryBuilder\SqlCommands\Condition\Condition;

/**
 * Adds where statement
 * 
 * Supported param types:
 * ```
 * ['key' => 'value']
 * ['>', 'key', 'value']
 * ['between', 'key', 'value_from', 'value_to']
 * ['like', 'value', 'regexp']
 * ['and', [['condition1'], ['condition2']]]
 * ```
 */
class WhereCommand extends SqlCommand
{
    private Condition $condition;

    public function __construct(array $condition)
    {
        $this->condition = new Condition($condition);
    }

    public function getStatementName(): string
    {
        return SqlStatements::WHERE;
    }

    public function addCondition(string $boolOperator, array $newCondition): void
    {
        $this->condition->addCondition($boolOperator, $newCondition);
    }

    public function getSqlQuery(): string
    {
        return $this->condition->getConditionRequest();
    }
}
