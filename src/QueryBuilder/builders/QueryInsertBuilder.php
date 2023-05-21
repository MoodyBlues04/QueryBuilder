<?php

declare(strict_types=1);

namespace src\QueryBuilder\builders;

use src\db\db;
use src\db\DbConfigDto;
use src\QueryBuilder\params\QueryInsertParams;

class QueryInsertBuilder
{
    private db $db;

    private QueryInsertParams $params;

    public function __construct(DbConfigDto $dbConfigDto)
    {
        $this->db = db::getInstance($dbConfigDto);
        $this->params = new QueryInsertParams();
    }

    public function into(string $into): self
    {
        $this->params->setInto($into);
        return $this;
    }

    public function columns(array|string $columns): self
    {
        $this->params->setColumns($columns);
        return $this;
    }

    public function values(array|string $values): self
    {
        $this->params->setValues($values);
        return $this;
    }

    public function execute(): bool
    {
        $request = $this->params->getRequest();
        return $this->db->execute($request);
    }
}
