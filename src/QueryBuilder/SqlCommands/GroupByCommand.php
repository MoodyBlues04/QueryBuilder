<?php

declare(strict_types=1);

namespace src\QueryBuilder\SqlCommands;

class GroupByCommand extends SqlCommand
{
    private array $query;

    public function __construct(array|string $groupBy)
    {
        if (is_string($groupBy)) {
            $groupBy = array($groupBy);
        }
        $this->query = $groupBy;
    }

    public function getStatementName(): string
    {
        return SqlStatements::GROUP_BY;
    }

    public function getSqlQuery(): string
    {
        return implode(',', $this->query);
    }
}
