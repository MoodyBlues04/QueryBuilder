<?php

declare(strict_types=1);

namespace src\QueryBuilder\SqlCommands\Condition;

class Condition
{
    private array $condition;

    public function __construct(array $condition)
    {
        $this->condition = $condition;
    }

    public function addCondition(string $boolOperator, array $addCondition): void
    {
        $this->condition = [$boolOperator, [$this->condition, $addCondition]];
    }

    public function getConditionRequest(): string
    {
        return $this->parseCondition($this->condition);
    }

    /**
     * @throws \InvalidArgumentException
     */
    private function parseCondition(array $condition): string
    {
        if ($this->isKeyValueCondition($condition)) {
            return $this->parseKeyValueCondition($condition);
        }
        if (Operators::isBaseOperator($condition[0])) {
            return $this->parseBaseCondition($condition);
        }
        if (Operators::isHavingFunction($condition[0])) {
            return $this->parseHavingCondition($condition);
        }
        if (Operators::isBoolOperator($condition[0])) {
            return $this->parseComplicatedCondition($condition);
        }

        throw new \InvalidArgumentException('Unknown condition type: ' . json_encode($condition));
    }

    /**
     * Complicated condition should have that structure:
     * ```
     * ['and', [['key' => 'value'], ['>', 'key2', 'val2']]]
     * ```
     * Or globally:
     * ```
     * ['bool operator', [['condition1'], ['condition2'], ..., ['condition_Nth']]]
     * ```
     * 
     * @param array $complicatedCondition
     * 
     * @return string
     */
    private function parseComplicatedCondition(array $complicatedCondition): string
    {
        $operator = $complicatedCondition[0];
        if ($operator === 'not') {
            return 'NOT (' . $this->parseCondition($complicatedCondition[1]) . ')';
        }

        $result = '';
        foreach ($complicatedCondition[1] as $condition) {
            $result .= $this->parseCondition($condition) . " {$operator} ";
        }
        return rtrim($result, " {$operator} ");
    }

    /**
     * Having condition should have that structure:
     * ```
     * ['function', 'key', 'operator', 'value']
     * ```
     * 
     * @param array $havingCondition
     * 
     * @return string
     */
    private function parseHavingCondition(array $havingCondition): string
    {
        $parsedCondition = array_slice($havingCondition, 1);

        $parsedCondition[0] = $parsedCondition[1];
        $parsedCondition[1] = "{$havingCondition[0]}({$havingCondition[1]})";

        return $this->parseBaseCondition($parsedCondition);
    }

    /**
     * Base condition is condition like:
     * ```
     * ['>', 'key', 'value']
     * ['between', 'key', 'value_from', 'value_to']
     * ```
     * 
     * @param array $baseCondition
     * 
     * @return string
     */
    private function parseBaseCondition(array $baseCondition): string
    {
        $operator = $baseCondition[0];

        if ($operator === 'between') {
            return "{$baseCondition[1]} {$operator} '{$baseCondition[2]}' AND '{$baseCondition[3]}'";
        }
        return "{$baseCondition[1]} {$operator} '{$baseCondition[2]}'";
    }

    private function parseKeyValueCondition(array $keyValueCondition): string
    {
        $query = '';
        foreach ($keyValueCondition as $key => $value) {
            $query .= "{$key} = '{$value}' AND ";
        }
        return rtrim($query, ' AND ');
    }

    private function isKeyValueCondition(array $condition): bool
    {
        return !isset($condition[0]) && !empty($condition);
    }
}
