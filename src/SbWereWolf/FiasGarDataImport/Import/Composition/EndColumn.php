<?php

declare(strict_types=1);

namespace SbWereWolf\FiasGarDataImport\Import\Composition;


abstract class EndColumn extends DataColumn
{
    protected const DEFAULT_FIN_VALUE = '2079-06-06';

    public function getDefaultValue(): string
    {
        return static::DEFAULT_FIN_VALUE;
    }
}