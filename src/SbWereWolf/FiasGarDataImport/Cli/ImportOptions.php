<?php

declare(strict_types=1);

namespace SbWereWolf\FiasGarDataImport\Cli;

use Generator;
use JsonSerializable;
use SbWereWolf\JsonSerializable\JsonSerializeTrait;

class ImportOptions implements JsonSerializable
{
    use JsonSerializeTrait;

    private string $regionDataDirectoryPattern;
    private array $dataPatterns;
    private array $referencePatterns;
    private bool $doAddNewWithCheck;

    /**
     * @param bool $doAddNewWithCheck
     * @param array $referencePatterns
     * @param string $regionDataDirectoryPattern
     * @param array $dataPatterns
     */
    public function __construct(
        bool $doAddNewWithCheck,
        array $referencePatterns,
        string $regionDataDirectoryPattern,
        array $dataPatterns,
    ) {
        $this->regionDataDirectoryPattern = $regionDataDirectoryPattern;
        $this->dataPatterns = $dataPatterns;
        $this->referencePatterns = $referencePatterns;
        $this->doAddNewWithCheck = $doAddNewWithCheck;
    }

    /**
     * @return string
     */
    public function getRegionDataDirectoryPattern(): string
    {
        return $this->regionDataDirectoryPattern;
    }

    public function nextRegionDataFilePattern(): Generator
    {
        foreach ($this->dataPatterns as $importer => $pattern) {
            yield $importer => $pattern;
        }
    }

    public function nextCommonReferenceFilePattern(): Generator
    {
        foreach ($this->referencePatterns as $importer => $pattern) {
            yield $importer => $pattern;
        }
    }

    /**
     * @return bool
     */
    public function isDoAddNewWithCheck(): bool
    {
        return $this->doAddNewWithCheck;
    }
}