<?php

class QueryBuilder
{
    private db $db;

    public function __construct(DbConfigDto $dbConfigDto)
    {
        $this->db = db::getInstance($dbConfigDto);
    }

    public function select(string $params)
    {
    }
}
