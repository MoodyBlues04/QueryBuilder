<?php

declare(strict_types=1);

namespace src\QueryBuilder\SqlCommands;

/**
 * Adds where statement
 * 
 * Supported param types:
 * ```
 * ['key' => 'value']
 * ['>', 'key', 'value']
 * ['between', 'key', 'value_from', 'value_to']
 * ['like', 'value', 'regexp']
 * ```
 */
class WhereCommand extends SqlCommand
{
    private ConditionCommand $conditionCommand;

    public function __construct(array $condition)
    {
        $this->conditionCommand = new ConditionCommand($condition);
    }

    public function getStatementName(): string
    {
        return SqlStatements::WHERE;
    }

    public function getSqlQuery(): string
    {
        return $this->conditionCommand->getWhere();
    }
}
