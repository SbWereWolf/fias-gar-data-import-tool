<?php

namespace SbWereWolf\FiasGarDataImport\Import\Composition\Column;


use SbWereWolf\FiasGarDataImport\Import\Composition\StrColumn;

class ObjectGuidColumn extends StrColumn
{
    protected const COLUMN_NAME = 'OBJECTGUID';
    protected const PARAMETER_NAME = ':OBJECTGUID';

    public function getParam(): string
    {
        return static::PARAMETER_NAME;
    }

    protected function getColumnName(): string
    {
        return static::COLUMN_NAME;
    }
}