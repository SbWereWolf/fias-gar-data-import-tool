<?php

declare(strict_types=1);

namespace SbWereWolf\FiasGarDataImport\Import\Composition;


abstract class IntColumn extends DataColumn
{
    protected const DEFAULT_INT_VALUE = -1;

    public function getDefaultValue(): int
    {
        return static::DEFAULT_INT_VALUE;
    }
}