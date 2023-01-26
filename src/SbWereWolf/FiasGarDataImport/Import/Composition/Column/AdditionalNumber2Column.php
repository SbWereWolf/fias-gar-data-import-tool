<?php

namespace SbWereWolf\FiasGarDataImport\Import\Composition\Column;


use SbWereWolf\FiasGarDataImport\Import\Composition\StrColumn;

class AdditionalNumber2Column extends StrColumn
{
    protected const COLUMN_NAME = 'ADDNUM2';
    protected const PARAMETER_NAME = ':ADDNUM2';

    public function getParam(): string
    {
        return static::PARAMETER_NAME;
    }

    protected function getColumnName(): string
    {
        return static::COLUMN_NAME;
    }
}