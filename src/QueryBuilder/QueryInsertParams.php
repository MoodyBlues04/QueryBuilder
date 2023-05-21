<?php

declare(strict_types=1);

namespace src\QueryBuilder;

class QueryInsertParams
{
    private ?string $into = null;
    private ?array $columns = null;
    private ?array $values = null;

    public function setInto(string $into): void
    {
        $this->into = $into;
    }

    public function setColumns(array|string $columns): void
    {
        if (is_string($columns)) {
            $columns = array($columns);
        }
        $this->columns = $columns;
    }

    public function setValues(array|string $values): void
    {
        if (is_string($values)) {
            $values = array($values);
        }
        $this->values = $values;
    }

    public function getRequest(): string
    {
        $this->validateRequest();

        $request = 'INSERT ';
        $request .= $this->getIntoAsString() . "\n";

        if (!is_null($this->columns)) {
            $request .= $this->getColumnsAsString() . "\n";
        }
        $request .= $this->getValuesAsString();

        return $request;
    }

    /**
     * @throws \LogicException
     */
    private function validateRequest(): void
    {
        if (is_null($this->into)) {
            throw new \LogicException('SQL INSERT request must include INTO statement');
        }
        if (is_null($this->values)) {
            throw new \LogicException('SQL INSERT request must include VALUES statement');
        }
        if (!is_null($this->columns) && sizeof($this->columns) != sizeof($this->values)) {
            throw new \InvalidArgumentException("The number of columns and values must be the same");
        }
    }

    private function getIntoAsString(): string
    {
        return "INTO {$this->into}";
    }

    private function getColumnsAsString(): string
    {
        return '(' . implode(',', $this->columns) . ')';
    }

    private function getValuesAsString(): string
    {
        $condition = 'VALUES (';
        foreach ($this->values as $value) {
            $condition .= "'{$value}',";
        }

        return rtrim($condition, ',') . ')';
    }
}
