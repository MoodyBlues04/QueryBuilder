<?php

declare(strict_types=1);

namespace src\QueryBuilder\params;

use src\QueryBuilder\helpers\QueryConditionHelper;

class QuerySelectParams
{
    const SORT_ASC = 'asc';
    const SORT_DESC = 'desc';

    private ?array $select = null;
    private ?string $from = null;

    /**
     * Where statement
     * 
     * Supports types:
     * ['key' => 'value']
     * ['>', 'key', 'value']
     * ['between', 'key', 'value_from', 'value_to']
     * ['like', 'value', 'regexp']
     */
    private ?array $where = null;
    private ?array $groupBy = null;

    /**
     * Having statement
     * 
     * Supports types:
     * ['func', 'key', '>', 'value']
     * ['func', 'key', 'between', 'value_from', 'value_to]
     * 
     * func can be: sum, max, min, count
     */
    private ?array $having = null;

    /**
     * OrderBy statement
     * 
     * Supported types:
     * ```[key => SORT_DESC|SORT_ASC]```
     */
    private ?array $orderBy = null;
    private ?int $limit = null;

    public function setSelect(array|string $select): void
    {
        if (is_string($select)) {
            $select = array($select);
        }
        $this->select = $select;
    }

    public function setFrom(string $from): void
    {
        $this->from = $from;
    }

    public function setWhere(array $where): void
    {
        $this->where = $where;
    }

    public function setGroupBy(array|string $groupBy): void
    {
        if (is_string($groupBy)) {
            $groupBy = array($groupBy);
        }
        $this->groupBy = $groupBy;
    }

    public function setHaving(array|string $having): void
    {
        if (is_string($having)) {
            $having = array($having);
        }
        $this->having = $having;
    }

    public function setOrderBy(array|string $orderBy): void
    {
        if (is_string($orderBy)) {
            $orderBy = [$orderBy => self::SORT_ASC];
        }
        $this->orderBy = $orderBy;
    }

    public function setLimit(int $limit): void
    {
        $this->limit = $limit;
    }

    /**
     * @throws \LogicException
     */
    public function getRequest(): string
    {
        $this->validateRequest();

        $request = '';
        $request .= $this->getSelectAsString() . "\n";
        $request .= $this->getFromAsString() . "\n";

        if (!is_null($this->where)) {
            $request .= $this->getWhereAsString() . "\n";
        }
        if (!is_null($this->groupBy)) {
            $request .= $this->getGroupByAsString() . "\n";
        }
        if (!is_null($this->groupBy) && !is_null($this->having)) {
            $request .= $this->getHavingAsString() . "\n";
        }
        if (!is_null($this->orderBy)) {
            $request .= $this->getOrderByAsString() . "\n";
        }
        if (!is_null($this->limit)) {
            $request .= $this->getLimitAsString() . "\n";
        }
        return $request;
    }

    /**
     * @throws \LogicException
     */
    private function validateRequest(): void
    {
        if (is_null($this->select)) {
            throw new \LogicException('SQL SELECT request must include SELECT statement');
        }
        if (is_null($this->from)) {
            throw new \LogicException('SQL SELECT request must include FROM statement');
        }
    }

    private function getSelectAsString(): string
    {
        return 'SELECT ' . implode(',', $this->select);
    }

    private function getFromAsString(): string
    {
        return "FROM {$this->from}";
    }

    /**
     * @throws \InvalidArgumentException
     */
    private function getWhereAsString(): string
    {
        return (new QueryConditionHelper($this->where))->getWhereAsString();
    }

    private function getGroupByAsString(): string
    {
        return 'GROUP BY ' . implode(',', $this->groupBy);
    }

    /**
     * @throws \InvalidArgumentException
     */
    private function getHavingAsString(): string
    {
        return (new QueryConditionHelper($this->having))->getHavingAsString();
    }

    private function getOrderByAsString(): string
    {
        $statement = 'ORDER BY';
        foreach ($this->orderBy as $key => $sortType) {
            $statement .= " {$key} {$sortType},";
        }

        return rtrim($statement, ',');
    }

    private function getLimitAsString(): string
    {
        return "LIMIT {$this->limit}";
    }
}
