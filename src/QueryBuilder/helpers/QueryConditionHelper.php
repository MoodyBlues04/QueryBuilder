<?php

namespace src\QueryBuilder\helpers;

class QueryConditionHelper
{
    private array $rawCondition;

    public function __construct(array $rawCondition)
    {
        $this->rawCondition = $rawCondition;
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function getWhereAsString(): string
    {
        // means key => val request
        if (!isset($this->rawCondition[0]) && !is_null($this->rawCondition)) {
            $key = key($this->rawCondition);
            return "WHERE {$key} = '{$this->rawCondition[$key]}'";
        }

        return "WHERE {$this->getConditionAsString($this->rawCondition)}";
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function getHavingAsString(): string
    {
        $this->checkHavingFunc($this->rawCondition[0]);

        return "HAVING  {$this->getHavingConditionAsString()}";
    }

    private function getHavingConditionAsString(): string
    {
        $condition = array_slice($this->rawCondition, 1);
        $condition[0] = $condition[1];
        $condition[1] = "{$this->rawCondition[0]}({$this->rawCondition[1]})";

        return $this->getConditionAsString($condition);
    }

    private function getConditionAsString(array $condition): string
    {
        $operator = $condition[0];
        $this->checkConditionOperator($operator);

        if ($operator === 'between') {
            return "{$condition[1]} {$operator} '{$condition[2]}' AND '{$condition[3]}'";
        }
        return "{$condition[1]} {$operator} '{$condition[2]}'";
    }

    /**
     * @throws \InvalidArgumentException
     */
    private function checkHavingFunc(string $func): void
    {
        $validFuncs = ['sum', 'avg', 'max', 'min', 'count'];
        if (!in_array($func, $validFuncs)) {
            throw new \InvalidArgumentException("Invalid func: {$func}");
        }
    }

    /**
     * @throws \InvalidArgumentException
     */
    private function checkConditionOperator(string $operator): void
    {
        $validOperators = [
            // 'and', 'not', 'or', 
            '=',
            '>',
            '>=',
            '<',
            '<=',
            'like',
            'between'
        ];
        if (!in_array($operator, $validOperators)) {
            throw new \InvalidArgumentException("Invalid operator: {$operator}");
        }
    }
}
