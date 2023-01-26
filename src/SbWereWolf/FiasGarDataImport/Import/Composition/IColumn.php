<?php

declare(strict_types=1);

namespace SbWereWolf\FiasGarDataImport\Import\Composition;

interface IColumn
{
    public static function hasDefaultValue(): bool;

    public static function convertToDbValue($val);

    public static function shouldUseForSelect(): bool;

    public static function shouldUseForUpdate(): bool;

    public function getParam(): string;

    public function getDefaultValue();

    public function getForWherePhrase(): string;

    public function getColumnForInsert(): string;

    public function getColumnForUpdate(): string;
}