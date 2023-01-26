<?php

declare(strict_types=1);

namespace SbWereWolf\FiasGarDataImport\FileInput;

use Generator;
use JsonSerializable;
use SbWereWolf\JsonSerializable\JsonSerializeTrait;

class FileFinder implements JsonSerializable
{
    use JsonSerializeTrait;

    private string $directoriesPattern;

    public function __construct(string $directoriesPattern)
    {
        $this->directoriesPattern = $directoriesPattern;
    }

    /**
     * @param string $filesPattern
     * @return Generator
     */
    public function find(string $filesPattern): Generator
    {
        $directoryList = glob(
            $this->directoriesPattern,
            GLOB_ONLYDIR | GLOB_BRACE
        );

        foreach ($directoryList as $directory) {
            $directory = rtrim($directory, DIRECTORY_SEPARATOR);
            $directories = explode(DIRECTORY_SEPARATOR, $directory);
            $lastDir = array_pop($directories);

            $path = $directory . DIRECTORY_SEPARATOR . $filesPattern;
            $fileList = glob($path, GLOB_BRACE);

            foreach ($fileList as $dataFile) {
                $result = new SearchOutput($lastDir, $dataFile);
                yield $result;
            }
        }
    }
}