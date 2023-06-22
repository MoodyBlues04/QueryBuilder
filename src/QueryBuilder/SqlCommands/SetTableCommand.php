<?php

declare(strict_types=1);

namespace src\QueryBuilder\SqlCommands;

class SetTableCommand extends SqlCommand
{
    private string $statement;
    private string $query;

    public function __construct(string $statement, string $table)
    {
        $this->statement = $statement;
        $this->query = $table;
    }

    public function getStatementName(): string
    {
        return $this->statement;
    }

    public function getSqlQuery(): string
    {
        return $this->query;
    }
}
