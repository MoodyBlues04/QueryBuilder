<?php

declare(strict_types=1);

namespace src\QueryBuilder\SqlCommands;

use src\QueryBuilder\SqlCommands\Condition\Condition;

/**
 * Adds having statement
 * 
 * Supports types:
 * ```
 * ['func', 'key', '>', 'value']
 * ['func', 'key', 'between', 'value_from', 'value_to']
 * ['and', [['condition1'], ['condition2']]]
 * ```
 * 
 * For supported funcs:
 * @see src\QueryBuilder\SqlCommands\Condition\Operators.php
 */
class HavingCommand extends SqlCommand
{
    private Condition $condition;

    public function __construct(array $condition)
    {
        $this->condition = new Condition($condition);
    }

    public function getStatementName(): string
    {
        return SqlStatements::HAVING;
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
