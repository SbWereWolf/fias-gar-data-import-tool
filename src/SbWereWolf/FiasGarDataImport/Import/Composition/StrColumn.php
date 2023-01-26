<?php

declare(strict_types=1);

namespace SbWereWolf\FiasGarDataImport\Import\Composition;


abstract class StrColumn extends DataColumn
{
    protected const DEFAULT_STR_VALUE = '';

    public function getDefaultValue(): string
    {
        return static::DEFAULT_STR_VALUE;
    }
}