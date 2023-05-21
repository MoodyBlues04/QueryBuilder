<?php

declare(strict_types=1);

namespace src\QueryBuilder;

use src\db\db;
use src\db\DbConfigDto;

class QuerySelectBuilder
{
    private db $db;

    private QuerySelectParams $params;

    public function __construct(DbConfigDto $dbConfigDto)
    {
        $this->db = db::getInstance($dbConfigDto);
        $this->params = new QuerySelectParams();
    }

    /**
     * @throws \LogicException
     */
    public function select(string|array $select): self
    {
        $this->params->setSelect($select);
        return $this;
    }

    /**
     * @throws \LogicException
     */
    public function from(string $from): self
    {
        $this->params->setFrom($from);
        return $this;
    }

    /**
     * Adds where statement
     * 
     * Supported param types:
     * ['key' => 'value']
     * ['>', 'key', 'value']
     * ['between', 'key', 'value_from', 'value_to']
     * ['like', 'value', 'regexp']
     */
    public function where(array $where): self
    {
        $this->params->setWhere($where);
        return $this;
    }

    public function groupBy(array|string $groupBy): self
    {
        $this->params->setGroupBy($groupBy);
        return $this;
    }

    /**
     * Adds having statement
     * 
     * Supports types:
     * ['func', 'key', '>', 'value']
     * ['func', 'key', 'between', 'value_from', 'value_to]
     * 
     * func can be: sum, max, min, count
     */
    public function having(array|string $having): self
    {
        $this->params->setHaving($having);
        return $this;
    }

    /**
     * Adds order by statement
     * 
     * Supported types:
     * [key => SORT_DESC|SORT_ASC]
     * 'key' default sort asc
     */
    public function orderBy(array|string $orderBy): self
    {
        $this->params->setOrderBy($orderBy);
        return $this;
    }

    public function limit(int $limit): self
    {
        $this->params->setLimit($limit);
        return $this;
    }

    public function all(): ?array
    {
        $request = $this->params->getRequest();
        var_dump($request);
        return $this->db->query($request);
    }

    public function one(): ?array
    {
        $rows = $this->all();
        return $rows[0] ?? null;
    }
}
