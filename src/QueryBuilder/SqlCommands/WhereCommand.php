<?php

declare(strict_types=1);

namespace src\QueryBuilder\SqlCommands;

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
