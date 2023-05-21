<?php

declare(strict_types=1);

namespace src\QueryBuilder;

use src\QueryBuilder\helpers\QueryConditionHelper;

class QueryDeleteParams
{
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

    public function setFrom(string $from): void
    {
        $this->from = $from;
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

        $request = "DELETE\n";
        $request .= $this->getFromAsString() . "\n";
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
        if (is_null($this->from)) {
            throw new \LogicException('SQL DELETE request must include FROM statement');
        }
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
}
