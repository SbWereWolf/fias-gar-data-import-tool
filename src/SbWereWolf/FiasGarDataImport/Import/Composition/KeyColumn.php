<?php

declare(strict_types=1);

namespace SbWereWolf\FiasGarDataImport\Import\Composition;

use Exception;

abstract class KeyColumn extends Column
{
    protected const HAS_DEFAULT_VALUE = false;
    protected const SHOULD_USE_FOR_SELECT = true;
    protected const SHOULD_USE_FOR_UPDATE = false;

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

    public function getDefaultValue(): int
    {
        throw new Exception(
            $this->getColumnName() .
            ' column do not have default value'
        );
    }

    public function getForWherePhrase(): string
    {
        $phrase = $this->getColumnName() . '=' . $this->getParam();

        return $phrase;
    }

    public function getColumnForUpdate(): string
    {
        throw new Exception(
            $this->getColumnName() .
            ' column not should use for update'
        );
    }
}