<?php

declare(strict_types=1);

namespace SbWereWolf\FiasGarDataImport\Import\Composition;


abstract class BegColumn extends DataColumn
{
    protected const DEFAULT_BEG_VALUE = '1900-01-01';

    public function getDefaultValue(): string
    {
        return static::DEFAULT_BEG_VALUE;
    }
}