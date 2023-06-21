<?php

declare(strict_types=1);

namespace src\QueryBuilder\SqlCommands;

class SelectCommand extends SqlCommand
{
    private array $query;

    public function __construct(array|string $select)
    {
        if (is_string($select)) {
            $select = array($select);
        }
        $this->query = $select;
    }

    public function getStatementName(): string
    {
        return SqlStatements::SELECT;
    }

    public function getSqlQuery(): string
    {
        return implode(',', $this->query);
    }
}
