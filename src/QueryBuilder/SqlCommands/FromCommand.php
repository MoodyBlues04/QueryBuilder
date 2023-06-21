<?php

declare(strict_types=1);

namespace src\QueryBuilder\SqlCommands;

class FromCommand extends SqlCommand
{
    private string $query;

    public function __construct(string $from)
    {
        $this->query = $from;
    }

    public function getStatementName(): string
    {
        return SqlStatements::FROM;
    }

    public function getSqlQuery(): string
    {
        return $this->query;
    }
}
