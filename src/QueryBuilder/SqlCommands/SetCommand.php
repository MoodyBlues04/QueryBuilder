<?php

declare(strict_types=1);

namespace src\QueryBuilder\SqlCommands;

class SetCommand extends SqlCommand
{
    private array $query;

    public function __construct(array $set)
    {
        $this->query = $set;
    }

    public function getStatementName(): string
    {
        return SqlStatements::SET;
    }

    public function getSqlQuery(): string
    {
        $query = '';
        foreach ($this->query as $column => $value) {
            $query .= "{$column} = '{$value}', ";
        }
        return rtrim($query, ', ');
    }
}
