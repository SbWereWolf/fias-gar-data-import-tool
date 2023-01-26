<?php

declare(strict_types=1);

namespace SbWereWolf\FiasGarDataImport\Import;

use JsonSerializable;
use SbWereWolf\JsonSerializable\JsonSerializeTrait;

class ImportSummary implements JsonSerializable
{
    use JsonSerializeTrait;

    private ImportStatus $status;

    public function __construct(
        ImportStatus $previous,
        ImportStatus $current,
    ) {
        $successInserts =
            $current->getSuccessInserts() +
            $previous->getSuccessInserts();
        $insertAffected =
            $current->getInsertAffected() +
            $previous->getInsertAffected();
        $failureInserts =
            $current->getFailureInserts() +
            $previous->getFailureInserts();
        $successUpdates =
            $current->getSuccessUpdates() +
            $previous->getSuccessUpdates();
        $updateAffected =
            $current->getUpdateAffected() +
            $previous->getUpdateAffected();
        $failureUpdates =
            $current->getFailureUpdates() +
            $previous->getFailureUpdates();

        /*$scriptMem = $current->getScriptMem();
        $scriptAllocated = $current->getAllocatedMem();
        $scriptMaxMem = $current->getScriptMaxMem();*/

        $this->status = new ImportStatus(
            $successInserts,
            $insertAffected,
            $failureInserts,
            $successUpdates,
            $updateAffected,
            $failureUpdates,
        );
    }

    /**
     * @return ImportStatus
     */
    public function getStatus(): ImportStatus
    {
        return $this->status;
    }
}