<?php

declare(strict_types=1);

namespace src\QueryBuilder\params;

use src\QueryBuilder\helpers\QueryConditionHelper;

class QueryUpdateParams
{
    private ?string $table = null;
    /**
     * @var array<string,mixed>
     */
    private ?array $columnsValues = null;
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

    public function setTable(string $table): void
    {
        $this->table = $table;
    }

    public function setColumnsValues(array $columnsValues): void
    {
        $this->columnsValues = $columnsValues;
    }

    public function setWhere(array $where): void
    {
        $this->where = $where;
    }

    /**
     * @throws \LogicException
     */
    public function getRequest(): string
    {
        $this->validateRequest();

        $request = "UPDATE {$this->table}\n";
        $request .= $this->getSetAsString() . "\n";

        if (!is_null($this->where)) {
            $request .= $this->getWhereAsString() . "\n";
        }

        return $request;
    }

    /**
     * @throws \LogicException
     */
    private function validateRequest(): void
    {
        if (is_null($this->table)) {
            throw new \LogicException('SQL UPDATE request must include table name');
        }
        if (is_null($this->columnsValues)) {
            throw new \LogicException('SQL UPDATE request must include SET statement');
        }
    }

    public function getSetAsString(): string
    {
        $statement = 'SET ';
        foreach ($this->columnsValues as $column => $value) {
            $statement .= "{$column} = '{$value}', ";
        }
        return rtrim($statement, ', ');
    }

    /**
     * @throws \InvalidArgumentException
     */
    private function getWhereAsString(): string
    {
        return (new QueryConditionHelper($this->where))->getWhereAsString();
    }
}
