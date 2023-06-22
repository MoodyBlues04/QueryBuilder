<?php

declare(strict_types=1);

namespace src\QueryBuilder\SqlCommands;

class ValuesCommand extends SqlCommand
{
    private array $query;

    public function __construct(array|string $values)
    {
        if (is_string($values)) {
            $values = array($values);
        }
        $this->query = $values;
    }

    public function getStatementName(): string
    {
        return SqlStatements::VALUES;
    }

    public function getSqlQuery(): string
    {
        $query = ' (';
        foreach ($this->query as $value) {
            $query .= "'{$value}',";
        }
        return rtrim($query, ',') . ')';
    }
}
