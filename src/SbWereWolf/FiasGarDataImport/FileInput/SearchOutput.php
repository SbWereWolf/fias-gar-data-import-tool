<?php

declare(strict_types=1);

namespace SbWereWolf\FiasGarDataImport\FileInput;

use JsonSerializable;
use SbWereWolf\JsonSerializable\JsonSerializeTrait;

class SearchOutput implements JsonSerializable
{
    use JsonSerializeTrait;

    private string $directory;
    private string $filename;

    public function __construct(string $directory, string $filename)
    {
        $this->directory = $directory;
        $this->filename = $filename;
    }

    /**
     * @return string
     */
    public function getDirectory(): string
    {
        return $this->directory;
    }

    /**
     * @return string
     */
    public function getFilename(): string
    {
        return $this->filename;
    }
}