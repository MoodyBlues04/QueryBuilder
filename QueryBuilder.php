<?php

declare(strict_types=1);

class QueryBuilder
{
    private db $db;

    public function __construct(DbConfigDto $dbConfigDto)
    {
        $this->db = db::getInstance($dbConfigDto);
    }

    public function select(string|array $params): self
    {
        return $this;
    }
}
