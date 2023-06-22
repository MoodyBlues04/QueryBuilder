<?php

declare(strict_types=1);

namespace src\QueryBuilder\SqlCommands;

class InsertCommand extends SqlCommand
{
    public function getStatementName(): string
    {
        return SqlStatements::INSERT;
    }

    public function getSqlQuery(): string
    {
        return '';
    }
}
