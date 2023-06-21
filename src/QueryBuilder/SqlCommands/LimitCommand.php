<?php

declare(strict_types=1);

namespace src\QueryBuilder\SqlCommands;

class LimitCommand extends SqlCommand
{
    private int $query;

    public function __construct(int $limit)
    {
        $this->query = $limit;
    }

    public function getStatementName(): string
    {
        return SqlStatements::LIMIT;
    }

    public function getSqlQuery(): string
    {
        return (string)$this->query;
    }
}
