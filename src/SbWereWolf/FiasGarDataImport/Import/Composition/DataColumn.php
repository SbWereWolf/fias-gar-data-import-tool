<?php

declare(strict_types=1);

namespace SbWereWolf\FiasGarDataImport\Import\Composition;

abstract class DataColumn extends Column
{

    protected const HAS_DEFAULT_VALUE = true;
    protected const SHOULD_USE_FOR_SELECT = false;
    protected const SHOULD_USE_FOR_UPDATE = true;

    public static function hasDefaultValue(): bool
    {
        return static::HAS_DEFAULT_VALUE;
    }

    public static function convertToDbValue($val)
    {
        return $val;
    }

    public static function shouldUseForSelect(): bool
    {
        return static::SHOULD_USE_FOR_SELECT;
    }

    public static function shouldUseForUpdate(): bool
    {
        return static::SHOULD_USE_FOR_UPDATE;
    }

    public function getForWherePhrase(): string
    {
        return $this->getColumnName() . '!=' . $this->getParam();
    }

    public function getColumnForUpdate(): string
    {
        return $this->getColumnName() . '=' . $this->getParam();
    }
}