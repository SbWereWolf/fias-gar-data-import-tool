<?php

namespace SbWereWolf\FiasGarDataImport\Import\Composition\Column;


use SbWereWolf\FiasGarDataImport\Import\Composition\IntColumn;

class IsActualColumn extends IntColumn
{
    protected const COLUMN_NAME = 'ISACTUAL';
    protected const PARAMETER_NAME = ':ISACTUAL';

    public function getParam(): string
    {
        return static::PARAMETER_NAME;
    }

    protected function getColumnName(): string
    {
        return static::COLUMN_NAME;
    }
}