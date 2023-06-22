<?php

declare(strict_types=1);

namespace src\QueryBuilder\SqlCommands;

/**
 * Adds having statement
 * 
 * Supports types:
 * ```
 * ['func', 'key', '>', 'value']
 * ['func', 'key', 'between', 'value_from', 'value_to]
 * ```
 * 
 * supported funcs: ```sum, max, min, count```
 */
class HavingCommand extends SqlCommand
{
    private ConditionCommand $conditionCommand;

    public function __construct(array $condition)
    {
        $this->conditionCommand = new ConditionCommand($condition);
    }

    public function getStatementName(): string
    {
        return SqlStatements::HAVING;
    }

    public function getSqlQuery(): string
    {
        return $this->conditionCommand->getHaving();
    }
}
