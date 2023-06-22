<?php

declare(strict_types=1);

namespace src\QueryBuilder\SqlCommands;

class DeleteCommand extends SqlCommand
{
    public function getStatementName(): string
    {
        return SqlStatements::DELETE;
    }

    public function getSqlQuery(): string
    {
        return '';
    }
}
