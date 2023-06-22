<?php

namespace src\QueryBuilder\SqlCommands\Condition;

class Operators
{
    const SUM   = 'SUM';
    const AVG   = 'AVG';
    const MAX   = 'MAX';
    const MIN   = 'MIN';
    const COUNT = 'COUNT';

    const AND = 'AND';
    const OR  = 'OR';
    const NOT = 'NOT';

    const EQUALS         = '=';
    const MORE           = '>';
    const MORE_OR_EQUALS = '>=';
    const LESS           = '<';
    const LESS_OR_EQUALS = '<=';
    const LIKE           = 'LIKE';
    const BETWEEN        = 'BETWEEN';

    public static function isBoolOperator(string $operator): bool
    {
        return in_array($operator, [self::AND, self::OR, self::NOT]);
    }

    public static function isHavingFunction(string $operator): bool
    {
        return in_array($operator, [self::SUM, self::MAX, self::MIN, self::AVG, self::COUNT]);
    }

    public static function isBaseOperator(string $operator): bool
    {
        return in_array($operator, [
            self::EQUALS,
            self::MORE,
            self::MORE_OR_EQUALS,
            self::LESS,
            self::LESS_OR_EQUALS,
            self::LIKE,
            self::BETWEEN
        ]);
    }
}
