<?php

declare(strict_types=1);

namespace SbWereWolf\FiasGarDataImport\Import\Composition;


abstract class Column implements IColumn
{
    public function getColumnForInsert(): string
    {
        return $this->getColumnName();
    }

    abstract protected function getColumnName(): string;
}