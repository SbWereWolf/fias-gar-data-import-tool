<?php

namespace SbWereWolf\FiasGarDataImport\Import\Composition\Column;


use SbWereWolf\FiasGarDataImport\Import\Composition\IntColumn;

class ApartamentTypeColumn extends IntColumn
{
    protected const COLUMN_NAME = 'APARTTYPE';
    protected const PARAMETER_NAME = ':APARTTYPE';

    public function getParam(): string
    {
        return static::PARAMETER_NAME;
    }

    protected function getColumnName(): string
    {
        return static::COLUMN_NAME;
    }
}