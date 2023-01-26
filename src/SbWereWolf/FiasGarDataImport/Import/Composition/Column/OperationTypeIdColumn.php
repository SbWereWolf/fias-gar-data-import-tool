<?php

namespace SbWereWolf\FiasGarDataImport\Import\Composition\Column;


use SbWereWolf\FiasGarDataImport\Import\Composition\IntColumn;

class OperationTypeIdColumn extends IntColumn
{
    protected const COLUMN_NAME = 'OPERTYPEID';
    protected const PARAMETER_NAME = ':OPERTYPEID';

    public function getParam(): string
    {
        return static::PARAMETER_NAME;
    }

    protected function getColumnName(): string
    {
        return static::COLUMN_NAME;
    }
}