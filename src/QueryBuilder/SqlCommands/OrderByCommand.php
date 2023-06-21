<?php

declare(strict_types=1);

namespace src\QueryBuilder\SqlCommands;

class OrderByCommand extends SqlCommand
{
    const SORT_ASC = 'ASC';
    const SORT_DESC = 'DESC';

    private array $query;

    public function __construct(array $orderBy)
    {
        if (is_string($orderBy)) {
            $orderBy = [$orderBy => self::SORT_ASC];
        }
        $this->query = $orderBy;
    }

    public function getStatementName(): string
    {
        return SqlStatements::ORDER_BY;
    }

    public function getSqlQuery(): string
    {
        $query = '';
        foreach ($this->query as $key => $sortType) {
            $query .= "{$key} {$sortType}, ";
        }

        return rtrim($query, ', ');
    }
}
