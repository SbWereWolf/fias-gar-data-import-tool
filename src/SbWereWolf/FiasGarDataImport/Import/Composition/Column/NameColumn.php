<?php

namespace SbWereWolf\FiasGarDataImport\Import\Composition\Column;


use SbWereWolf\FiasGarDataImport\Import\Composition\StrColumn;

class NameColumn extends StrColumn
{
    protected const COLUMN_NAME = 'NAME';
    protected const PARAMETER_NAME = ':NAME';

    public function getParam(): string
    {
        return static::PARAMETER_NAME;
    }

    protected function getColumnName(): string
    {
        return static::COLUMN_NAME;
    }
}