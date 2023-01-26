<?php

declare(strict_types=1);

namespace SbWereWolf\FiasGarDataImport\FileInput;

use Generator;
use JsonSerializable;
use SbWereWolf\JsonSerializable\JsonSerializeTrait;
use XMLReader;

class FileReader implements JsonSerializable
{
    use JsonSerializeTrait;

    public function read(string $filename): Generator
    {
        $reader = XMLReader::open(
            $filename,
            null,
            LIBXML_BIGLINES | LIBXML_COMPACT
        );

        /** @var XMLReader $reader */
        while ($reader->read()) {
            if (
                $reader->depth === 1 &&
                $reader->nodeType === XMLReader::ELEMENT
            ) {
                $attribs = [];
                while ($reader->moveToNextAttribute()) {
                    $attribs[$reader->localName] = $reader->value;
                }

                yield $attribs;
            }
        }

        $reader->close();
    }
}