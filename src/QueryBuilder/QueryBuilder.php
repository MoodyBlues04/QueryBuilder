<?php

declare(strict_types=1);

namespace src\QueryBuilder;

use src\db\DbConfigDto;
use src\QueryBuilder\Builders\QueryDeleteBuilder;
use src\QueryBuilder\Builders\QueryInsertBuilder;
use src\QueryBuilder\Builders\QuerySelectBuilder;
use src\QueryBuilder\Builders\QueryUpdateBuilder;

class QueryBuilder
{
    private DbConfigDto $dbConfigDto;

    public function __construct(DbConfigDto $dbConfigDto)
    {
        $this->dbConfigDto = $dbConfigDto;
    }

    public function select(string|array $select): QuerySelectBuilder
    {
        $selectQueryBuilder = new QuerySelectBuilder($this->dbConfigDto);
        return $selectQueryBuilder->select($select);
    }

    public function insert(): QueryInsertBuilder
    {
        $insertQueryBuilder = new QueryInsertBuilder($this->dbConfigDto);
        return $insertQueryBuilder->insert();
    }

    public function update(string $table): QueryUpdateBuilder
    {
        $updateQueryBuilder = new QueryUpdateBuilder($this->dbConfigDto);
        return $updateQueryBuilder->update($table);
    }

    public function delete(): QueryDeleteBuilder
    {
        $deleteQueryBuilder = new QueryDeleteBuilder($this->dbConfigDto);
        return $deleteQueryBuilder->delete();
    }
}
