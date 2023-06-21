<?php

declare(strict_types=1);

namespace src\QueryBuilder\SqlCommands;

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
