<?php

declare(strict_types=1);

namespace src\QueryBuilder\SqlCommands;

class ConditionCommand
{
    private array $condition;

    public function __construct(array $condition)
    {
        $this->condition = $condition;
    }

    public function addCondition()
    {
        return;
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function getWhere(): string
    {
        // means key => val request
        if (!isset($this->condition[0]) && !is_null($this->condition)) {
            $key = key($this->condition);
            return "{$key} = '{$this->condition[$key]}'";
        }

        return $this->getConditionAsString($this->condition);
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function getHaving(): string
    {
        $this->checkHavingFunc($this->condition[0]);

        return $this->getHavingConditionAsString();
    }

    private function getHavingConditionAsString(): string
    {
        $condition = array_slice($this->condition, 1);
        $condition[0] = $condition[1];
        $condition[1] = "{$this->condition[0]}({$this->condition[1]})";

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
