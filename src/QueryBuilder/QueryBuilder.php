<?php

declare(strict_types=1);

namespace src\QueryBuilder;

use src\db\DbConfigDto;

class QueryBuilder
{
    private DbConfigDto $dbConfigDto;

    public function __construct(DbConfigDto $dbConfigDto)
    {
        $this->dbConfigDto = $dbConfigDto;
    }

    /**
     * @throws \LogicException
     */
    public function select(string|array $select): QuerySelectBuilder
    {
        $selectQueryBuilder = new QuerySelectBuilder($this->dbConfigDto);
        $selectQueryBuilder->select($select);
        return $selectQueryBuilder;
    }

    public function insert(): QueryInsertBuilder
    {
        $insertQueryBuilder = new QueryInsertBuilder($this->dbConfigDto);
        return $insertQueryBuilder;
    }

    public function update(string $table): QueryUpdateBuilder
    {
        $updateQueryBuilder = new QueryUpdateBuilder($this->dbConfigDto);
        return $updateQueryBuilder->update($table);
    }

    public function delete(): QueryDeleteBuilder
    {
        $deleteQueryBuilder = new QueryDeleteBuilder($this->dbConfigDto);
        return $deleteQueryBuilder;
    }
}
