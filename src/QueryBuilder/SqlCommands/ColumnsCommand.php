<?php

declare(strict_types=1);

namespace src\QueryBuilder\SqlCommands;

class ColumnsCommand extends SqlCommand
{
    private array $query;

    public function __construct(array|string $columns)
    {
        if (is_string($columns)) {
            $columns = array($columns);
        }
        $this->query = $columns;
    }

    public function getStatementName(): string
    {
        return SqlStatements::COLUMNS;
    }

    public function getSqlQuery(): string
    {
        return '(' . implode(',', $this->query) . ')';
    }
}
