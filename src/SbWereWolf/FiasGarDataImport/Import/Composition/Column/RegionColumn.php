<?php

namespace SbWereWolf\FiasGarDataImport\Import\Composition\Column;


use SbWereWolf\FiasGarDataImport\Import\Composition\KeyColumn;

class RegionColumn extends KeyColumn
{
    protected const COLUMN_NAME = 'REGION';
    protected const PARAMETER_NAME = ':REGION';

    public function getParam(): string
    {
        return static::PARAMETER_NAME;
    }

    protected function getColumnName(): string
    {
        return static::COLUMN_NAME;
    }
}