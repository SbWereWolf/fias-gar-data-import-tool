<?php

namespace SbWereWolf\FiasGarDataImport\Import\Composition\Column;


use SbWereWolf\FiasGarDataImport\Import\Composition\BegColumn;

class AcceptanceDateColumn extends BegColumn
{
    protected const COLUMN_NAME = 'ACCDATE';
    protected const PARAMETER_NAME = ':ACCDATE';

    public function getParam(): string
    {
        return static::PARAMETER_NAME;
    }

    protected function getColumnName(): string
    {
        return static::COLUMN_NAME;
    }
}