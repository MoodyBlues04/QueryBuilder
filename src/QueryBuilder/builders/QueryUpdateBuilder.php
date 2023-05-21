<?php

declare(strict_types=1);

namespace src\QueryBuilder\builders;

use src\db\db;
use src\db\DbConfigDto;
use src\QueryBuilder\params\QueryUpdateParams;

class QueryUpdateBuilder
{
    private db $db;

    private QueryUpdateParams $params;

    public function __construct(DbConfigDto $dbConfigDto)
    {
        $this->db = db::getInstance($dbConfigDto);
        $this->params = new QueryUpdateParams();
    }

    public function update(string $table): self
    {
        $this->params->setTable($table);
        return $this;
    }

    public function set(array $columnValues): self
    {
        $this->params->setColumnsValues($columnValues);
        return $this;
    }

    public function where(array $where): self
    {
        $this->params->setWhere($where);
        return $this;
    }

    public function execute(): bool
    {
        $request = $this->params->getRequest();
        return $this->db->execute($request);
    }
}
